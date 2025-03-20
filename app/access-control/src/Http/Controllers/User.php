<?php

namespace App\AccessControl\Http\Controllers;

use App\AccessControl\Models\User as UserModel;
use App\AccessControl\Mail\ConfirmEmail;
use App\AccessControl\Mail\EmailConfirmacaoEdicao;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Auth\Events\Verified;
use Illuminate\Auth\Events\Registered;
use App\AccessControl\Mail\UserCreatedAdminNotification;
use App\AccessControl\Http\Requests\RegisterValidationRequest;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class User
{
    /**
     * Lista os usuarios da aplicacao
     * Filtra o campos desejados na requisicao e retorna somnete os permitidos
     * Campos permitidos: id, name, company, email, photo, username, profile_id, active
     * @param $req Objeto
     * @return String O JSON com os campos ou o erro
     */
    public function list(Request $req): JsonResponse
    {
        $fields = $req->query('fields');

        // Se o parâmetro 'fields' existir, validamos os campos
        if ($fields) {
            // Converte a string de campos separados por virgula em um array
            $fieldsArray = explode(',', $fields);

            // Define os campos permitidos
            $validFields = ['id', 'name', 'email', 'photo', 'perfil', 'active',];

            // Cria uma validacao para garantir que os campos sejam validos
            $validator = Validator::make(
                ['fields' => $fieldsArray],
                [
                    'fields' => 'array', // Verifica se eh um array
                    'fields.*' => 'in:' . implode(',', $validFields) . '|distinct' // Verifica se cada campo eh valido
                ]
            );

            // Se a validacao falhar, retorna um erro
            if ($validator->fails()) {
                $errorsMessages = [];
                foreach ($validator->errors()->getMessages() as $key => $errors) {
                    $invalidField = $fieldsArray[str_replace('fields.', '', $key)];
                    $errorsMessages[] = str_replace($key, $invalidField, current($errors));
                }
                return response()->json($errorsMessages, 400);
            }

            // Filtra os campos validos
            $fieldsArray = array_intersect($fieldsArray, $validFields);

            // Realiza a consulta com os campos filtrados
            $users = UserModel::select($fieldsArray)->with('profile:id,label')->orderBy('name', 'ASC')->get();
        } else {
            // Se não houver o parâmetro 'fields', retorna todos os dados
            $users = UserModel::orderBy('name', 'ASC')->with('profile:id,label')->get();
        }

        return response()->json($users);
        return response()->json([], 200);
    }
    /**
     * Metodo para criar um novo usuario
     * Usa a classe form validator RegisterValidationRequest para validar os campos
     * Funcionalidades:
     * - Criar um novo usuario - se o usuario nao estiver logado serah setado o perfil de cliente.
     *      Do conntrario o perfil serah setado confome o form e obrigatorio
     * - Enviar um email de confirmacao para o email do usuario
     * - Criar um novo registro no banco de dados
     * @param RegisterValidationRequest $request
     * @return JsonResponse
     */
    public function create(RegisterValidationRequest $req): JsonResponse
    {
        $formData = $req->all();
        // Se o usuario nao estiver autenticado setar o perfil de cliente
        if (!Auth::check()) {
            $formData['roles'] = 'client';
        }
        // Se o usuario estiver autenticado o envio do peril serah obrigatorio 
        elseif (!isset($formData['roles']) || empty($formData['roles'])) {
            return response()->json(['error' => 'O campo "Perfil" eh obrigatorio.'], 400);
        }
        // Valida se o usuario logado tem permissao para criar um usuario com o perfil selecionado
        elseif (Auth::user()->hasPermission('create.' . $formData['roles'])) {
            $req->merge(['password' => Hash::make(Str::random(8))]);
        }
        else{
            return response()->json(['error' => 'Você não tem permissao para criar um usuario com o perfil selecionado.'], 403);
        }
        // Criar o usuário
        $user = UserModel::create($req->all(['email', 'password']));

        if (!$user) {
            return response()->json(['message' => 'Erro ao criar o usuário.'], 500);
        }

        try {
            $user->active = true;
            $user->save();
            \App\Application\Models\People::create([
                'user_id' => $user->id,
                'name' => $formData['name'],
                'roles' => [$formData['roles']],
                'created_at' => now(),
                'updated_at' => now(),
                'licenciado_id' => 1,
            ]);
        } catch (\Exception $e) {
            Log::stack('database')->error('user.create:' . $e->getMessage());
            $user->delete();
            return response()->json(['message' => 'Erro ao criar o usuário.'], 500);
        }
        // Disparar evento de verificação de email
        event(new Registered($user));

        Mail::to(config('mail.admin_email'))->send(new UserCreatedAdminNotification($user));

        Log::channel('database')->info('Usuário criado com sucesso.', ['user' => $user->email, 'created_by' => 'system']);

        return response()->json(['message' => 'Usuário registrado. Verifique seu e-mail para ativar a conta.'], 201);
    }
    /**
     * Reenvia o email de confirmacao de email
     * @param Request $req
     * @return JsonResponse
     */
    public function emailResend(Request $req): JsonResponse
    {
        // Valida se o usuario logado tem permissao para executar essa funcao
        if(!Auth::user()->hasPermission('execute.email_resend')){
            return response()->json(['error' => ' Vocé nao tem permissao para executar essa funcao.'], 403);
        }

        $validated = $req->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        if (empty($validated)) {
            return response()->json(['message' => 'O endereço de email não existe!'], 400);
        }

        $user = UserModel::where('email', $validated['email'])->first();
        if ($user->hasVerifiedEmail()) {
            return response()->json(['error' => 'O e-mail ja foi validado!'], 400);
        }

        event(new Registered($user));

        return response()->json(['message' => 'Novo link de verificação enviado para o e-mail do usuário.'], 200);
    }
    /**
     * Verifica o email do usuario
     * @param $id
     * @param $hash
     * @return mix JsonResponse ou Redirect
     */
    public function verify($id, $hash)
    {
        $validator = Validator::make(['id' => $id, 'hash' => $hash], [
            'id' => 'required|exists:users,id',
            'hash' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'O endereço de email não existe!'], 400);
        }
        $validated = $validator->validated();
        $user = UserModel::where('id', $validated['id'])->first();

        if (!$user->hasVerifiedEmail() && sha1($user->email) == $validated['hash']) {
            $user->markEmailAsVerified();
        }

        return redirect()->route('login.view');
    }
    /**
     * Atualiza os dados do usuario
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * TODO: logar a acao
     */
    public function update(Request $req): JsonResponse
    {
        $user = Auth::user();

        $validatedData = $req->validate([
            'email' => 'nullable|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'current_password' => 'nullable|string'
        ]);

        // Desativa a conta do usuario e envia um email de confirmacao
        $emailMsg = '';
        if (isset($validatedData['email']) && $validatedData['email'] !== $user->email) {
            try {
                $validatedData['active'] = 0;
                Mail::to($validatedData['email'])->send(new EmailConfirmacaoEdicao($user));
                $emailMsg = ' O endereço de e-mail de sua conta foi alterado. Valide seu novo e-mail para desbloquear sua conta.';
            } catch (\Exception $e) {
                $emailMsg = 'Ocorreu um erro ao mudar seu email. Informe o administrador.';
            }
        }

        if (isset($validatedData['password'])) {
            // Valida a senha atual antes de permitir a alteração
            if (!Hash::check($req->current_password, $user->password)) {
                return response()->json([
                    'message' => 'A senha atual está incorreta.',
                ], 400);
            }
        }

        // Atualiza o usuário com os dados validados
        $user->update($validatedData);

        // Retorna a resposta de sucesso com os dados atualizados
        return response()->json([
            'message' => 'Cadastro atualizado com sucesso!' . $emailMsg,
            'user' => $user,
        ], 200);
    }
    /**
     * Muda o estado de ativacao (active) e perfil (profile)
     * Condicao: O usuario deve estar logado e ter permissao
     */
    public function changeState(Request $req): JsonResponse
    {
        // Somente o perfil administrador poderah alterar o estado e o perfil
        if (Auth::user()->hasPermition('execute.change_state')) {
            return response()->json(['message' => 'Usuário não autorizado'], 401);
        }
        $profiles = [];
        $pids = [];
        $pNames = [];
        foreach ($profiles as $profile) {
            $pNames[$profile['id']] = $profile['name'];
        }

        $validated = $req->validate([
            'id' => 'required|numeric|gt:0',
            'active' => 'nullable|numeric|in:0,1',
            'profile_id' => 'nullable|numeric|in:' . $pids,
        ]);

        if (isset($validated['active']) || isset($validated['profile_id'])) {
            $user = UserModel::find($validated['id']);
            $message = '';

            // Formata a mensagem
            if (isset($validated['active'])) {
                $message = "O usuário $user->name foi " . ($validated['active'] ? '' : 'in') . "ativado!";
            } else {
                $message = "O perfil do usuário $user->name foi para " . $pNames[$validated['id']];
            }
            unset($validated['id']);

            // Executa a query
            if ($user->update($validated)) {
                return response()->json(['message' => $message], 200);
            };

            return response()->json(['Ocorreu um erro na tentativa de alterar o ' . (isset($validated['active']) ? 'estado' : 'perfil') . 'do usuário'], 400);
        }
        return response()->json(['error' => 'Parametros incorretos.'], 422);
    }
    /**
     * Exclui um usuario
     * Para realizar a acao o usuario deverah tender as seguintes requisitos
     *  - Estar logado;
     *  - Ter um perfil autorizado a executar a acao; ou
     *  - Ser o proprietario do registro (autoexclusao)
     * @param Array Dos dados da requisicao
     * @return Object JSON text
     * TODO: validar o perfil (admin e o proprio) e logar a acao
     */
    public function delete(Request $req): mixed
    {
        $validated = $req->validate([
            'id' => 'required|numeric|gt:0'
        ]);

        if (!isset($validated['id'])) {
            return response()->json(['error' => "Identificador inválido!"], 401);
        }

        $mesmoID = Auth::user()->id === $validated['id'];

        if (!Auth::user()->hasPermission('delete.user')) {
            if ($this->hasPermission($validated['id'], 'delete')) {
            }
            return response()->json(['error' => "Você não tem permissão para excluir o usuário!"], 403);
        }



        $user = UserModel::find($validated['id']);
        if ($user && $user->delete()) {
            $uname = $user->name;
            // Loga a acao e o responsavel
            Log::channel('database')->warning('Exclusão de usuário', [
                'id' => $user->id,
                'nome' => $user->name,
                'acao' => $mesmoID ? 'autoexclusao' : 'exclusao por terceiro',
                'autor' => Auth::user()->name
            ]);
            if ($mesmoID) {
                return redirect('logout');
            }
            return response()->json(['message' => "O usuário $uname foi excluído com sucesso!"], 200);
        };
        return response()->json(['message' => "Ocorreu um erro ao tentar excluir o usuário $user->name!"], 400);
    }
    /**
     * Metodo para enviar o link para redefinicao de senha esquecida pelo usuarioo
     * Condicoes:
     * - O usuario deverar estar cadstrado na aplicacao
     * - A conta deve estar habilitada
     * @param Request $request
     * @return JsonResponse
     */
    public function forgotPassword(Request $req): JsonResponse
    {
        $validated = $req->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        if (empty($validated)) {
            return response()->json(['message' => 'O endereço de email não existe!'], 400);
        }

        $active = UserModel::where('email', $validated['email'])
            ->get()
            ->pluck('active')[0];

        if (!$active) {
            return response()->json(['message' => 'A conta se encontra inativa!'], 400);
        }

        Password::sendResetLink($validated);

        if (Password::RESET_LINK_SENT) {
            return response()->json(['message' => 'O link para redefinição de senha foi enviado para o seu e-mail.'], 200);
        }

        return response()->json(['message' => 'Não conseguimos encontrar um usuário com esse e-mail.'], 401);
    }
    /**
     * Verifica se o usuário tem permissão para executar uma ação em outro usuário.
     *
     * @param int $userId O ID do usuário a ser verificado.
     * @param string $action A ação a ser verificada.
     *
     * @return bool
     */
    protected function hasUserPermission(int $userId, string $action): bool
    {
        $userToCheck = UserModel::findOrFail($userId);
        $userRoles = json_decode($userToCheck->people->roles);

        $loggedUser = Auth::user();

        foreach ($userRoles as $role) {
            if ($loggedUser->hasPermission($action . $role)) {
                return true;
            }
        }

        return false;
    }
    /**
     * Exclui um usuário e suas dependências.
     *
     * @param int $userId O ID do usuário a ser excluído.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    function deleteUser($userId)
    {
        // Inicia a transação
        DB::beginTransaction();

        try {
            // Encontra o usuário
            $user = User::findOrFail($userId);

            // Remove relacionamento many-to-many
            $user->roles()->detach();

            // Exclui posts do usuário
            $user->posts()->delete();

            // Exclui comentários do usuário
            $user->comments()->delete();

            // Exclui o próprio usuário
            $user->delete();

            // Confirma a transação
            DB::commit();

            // Retorna uma resposta de sucesso
            return response()->json(['message' => 'Usuário e dependências excluídos com sucesso.']);
        } catch (\Exception $e) {
            // Reverte a transação em caso de erro
            DB::rollBack();

            // Retorna uma resposta de erro
            return response()->json(['error' => 'Erro ao excluir usuário.', 'details' => $e->getMessage()], 500);
        }
    }
}
