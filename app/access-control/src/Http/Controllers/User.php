<?php

namespace App\AccessControl\Http\Controllers;

use App\AccessControl\Models\User as UserModel;
use App\AccessControl\Mail\EmailConfirmacaoEdicao;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Auth\Events\Registered;
use App\AccessControl\Mail\UserCreatedAdminNotification;
use App\AccessControl\Http\Requests\RegisterValidationRequest;
use Illuminate\Support\Str;
use App\AccessControl\Mail\UserDeletedMail;

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
        $requireds = ['name'=>'nome', 'email'=>'email', 'role'=>'perfil'];
        foreach ($requireds as $key=>$fieldName) {
            if (!isset($formData[$key]) || empty($formData[$key])) {
                return response()->json(['error' => 'O campo "' . $fieldName . '" é obrigatorio.'], 400);
            }
        }
        // Verifica se o perfil selecionado eh de agente e se nao foi informado o id do cliente
        if($formData['role'] == 'agent' && (!isset($formData['client_id']) || empty($formData['client_id']))) {
            return response()->json(['error' => 'Informe o cliente para o perfil de agente.'], 400);
        }
        // Valida se o usuario logado tem permissão para criar um usuario com o perfil selecionado
        if (!Auth::user()->hasPermission('any.users') && !Auth::user()->hasPermission('create.' . $formData['role'])) {
            return response()->json(['error' => ' Você nao tem permissão para criar um usuario com o perfil selecionado.'], 403);
        }
        // Cria a senha aleatoria
        $formData = array_merge($formData, ['password' => Hash::make(Str::random(8))]);
        
        // Criar o usuário
        $user = UserModel::create(['email' => $formData['email'], 'password' => $formData['password']]);

        if (!$user) {
            return response()->json(['message' => 'Erro ao criar o usuário.'], 500);
        }
        // Cria a pessoa relacionada ao usuario e associa a um cliente ou agente se for o caso
        try {
            $user->active = true;
            $user->save();
            $person = \App\Application\Models\people::create([
                'user_id' => $user->id,
                'name' => $formData['name'],
                'roles' => [$formData['role']],
                'created_at' => now(),
                'updated_at' => now(),
                'licenciado_id' => 1,
            ]);
            // Se o perfil for de cliente, cria um novo registro na tabela clients
            if ($formData['role'] == 'client') {
                \App\Application\Models\Client::create([
                    'name' => $formData['name'],
                    'people_id' => $person->id,
                ]);
            }
            elseif($formData['role'] == 'agent'){
                \App\Application\Models\Agent::create([
                    'client_id' => $formData['client_id'],
                    'people_id' => $person->id
                ]);
            }
        } catch (\Exception $e) {
            Log::channel('database')->error('user.create:' . $e->getMessage());
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
        // Valida se o usuario logado tem permissão para executar essa funcão
        if (!Auth::user()->hasPermission('any.users') && !Auth::user()->hasPermission('send_email.users')) {
            return response()->json(['error' => ' Você nao tem permissão para executar essa funcão.'], 403);
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
     * Atualiza os dados do usuario
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * TODO: logar a acao
     */
    public function update(Request $req): JsonResponse
    {
        // Valida os dados do formulario
        $validator = Validator::make($req->all(), [
            'id' => 'required|exists:users,id',
            'email' => 'required|email|unique:users,email',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $validatedData = $validator->validated();
        $user = UserModel::find($validatedData['id']);

        // Valida se o usuario logado tem permissão para executar essa funcao
        if (
            !Auth::user()->hasPermission('any.users') &&
            !Auth::user()->hasPermission('update.' . $user->person->roles[0])
        ) {
            return response()->json(['error' => ' Você nao tem permissão para editar dados de usuários.'], 401);
        }

        // Atualiza o usuário com os dados validados
        if ($user->update($validatedData)) {
            Log::channel('database')->warning('Edição de conta de usuário.', [
                'user_id' => $user->id,
                'nome' => $user->name,
                'acao' => 'Edição de conta',
                'autor' => Auth::user()->name
            ]);
            Mail::to($validatedData['email'])->send(new EmailConfirmacaoEdicao($user));
            return response()->json(['message' => 'Cadastro atualizado com sucesso!'], 200);
        }
        return response()->json(['error' => 'Ocorreu um erro ao editar o email do usuário. Informe o administrador.'], 400);
    }
    /**
     * Muda o estado de ativacao (active) e perfil (profile)
     * Condicao: O usuario deve estar logado e ter permissão
     */
    public function changeState(Request $req): JsonResponse
    {
        // Somente o perfil administrador poderah alterar o estado e o perfil
        if (Auth::user()->hasPermission('execute.change_state')) {
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
            'profile_id' => 'nullable|numeric|in:' . implode(',', $pids),
        ]);

        if (isset($validated['active']) || isset($validated['profile_id'])) {
            $user = UserModel::find($validated['id']);
            $message = '';

            // Formata a mensagem
            if (isset($validated['active'])) {
                $user->active = $validated['active'];
                $message = "O usuário $user->name foi " . ($validated['active'] ? '' : 'in') . "ativado!";
            } else {
                $user->profile_id = $validated['profile_id'];
                $message = "O perfil do usuário $user->name foi para " . $pNames[$validated['id']];
            }
            unset($validated['id']);
            // Executa a query
            if ($user->save()) {
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

        $user = UserModel::find($validated['id']);
        // Valida a permissao do suario       
        if (!Auth::user()->hasPermission('any.users')) {
            $canDelete = false;
            foreach ($user->person->roles as $role) {
                if (Auth::user()->hasPermission('delete.' . $role)) {
                    $canDelete = true;
                    break;
                }
            }
            if (!$canDelete) {
                return response()->json(['error' => "Você não tem permissão para excluir o usuário $user->name!"], 403);
            }
        }

        if ($user && $user->delete()) {
            // Loga a acao e o responsavel
            Log::channel('database')->warning('Exclusao de usuario', [
                'user_id' => $user->id,
                'Nome' => $user->name,
                'acao' => 'Exclusao de usuario',
                'autor' => Auth::user()->name
            ]);
            Mail::to($user->email)->send(new UserDeletedMail($user));
            return response()->json(['message' => "O usuário $user->name foi excluído com sucesso!"], 200);
        };
        return response()->json(['error' => "Ocorreu um erro ao tentar excluir o usuário $user->name!"], 400);
    }
    /**
     * Metodo para enviar o link para redefinicao de senha esquecida pelo usuarioo
     * Condicoes:
     * - O usuario deverar estar cadstrado na aplicacao
     * - A conta deve estar habilitada
     * @param Request $request
     * @return JsonResponse
     */
    public function forgotPassword(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        if (empty($validated)) {
            return response()->json(['error' => 'O endereço de email não existe!'], 400);
        }

        if (!Auth::user()->active) {
            return response()->json(['error' => 'A conta se encontra inativa!'], 400);
        }

        Password::sendResetLink($validated);

        if (Password::RESET_LINK_SENT) {
            return response()->json(['message' => 'O link para redefinição de senha foi enviado para o seu e-mail.'], 200);
        }

        return response()->json(['error' => 'Não conseguimos encontrar um usuário com esse e-mail.'], 401);
    }
}
