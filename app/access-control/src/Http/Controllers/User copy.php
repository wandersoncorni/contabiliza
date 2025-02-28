<?php

namespace App\AccessControl\Http\Controllers;

use App\AccessControl\Models\User as UserModel;
use App\AccessControl\Mail\ConfirmEmail;
use App\AccessControl\Mail\EmailConfirmacaoEdicao;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Auth\Events\Verified;

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
            $validFields = ['id', 'name', 'company', 'email', 'photo', 'username', 'profile_id', 'active',];

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
     * Lista os dados do usuario logado
     * @param String o JSON
     */
    public function listUser(): JsonResponse
    {
        $user = Auth::user();
        return response()->json([$user], 200);
    }
    /**
     * Método para criar de novo usuário com perfil de cliente 
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createClient(Request $req): JsonResponse
    {
        $validator = Validator::make($req->all(), [
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $user = UserModel::create($validator->validated());

        if (is_null($user)) {
            return response()->json(['message' => 'Ocorreu um erro interno e sua conta não foi criada!'], 400);
        }

        Mail::to($user->email)->send(new ConfirmEmail($user));

        return response()->json(['message' => 'Usuário registrado com sucesso!'], 201);
    }
    /**
     * Método para criar de novo usuário
     * O usuario cliente fara o cadastro na pagina de cadastro.
     * Os demais usuario serao cadastrados pelo usuario administrador
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $req): JsonResponse
    {
        $validator = Validator::make($req->all(), [
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'required|string|max:20',
            'role' => 'required|string|max:20',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $user = UserModel::create($validator->validated());

        if (is_null($user)) {
            return response()->json(['message' => 'Ocorreu um erro interno e sua conta não foi criada!'], 400);
        }

        Mail::to($user->email)->send(new ConfirmEmail($user));

        return response()->json(['message' => 'Usuário registrado com sucesso!'], 201);
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
        if(Auth::user()->profile->label !=  'admin'){
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
        // Dados do usuario logado
        $perfilLogado = 'admin';
        $idLogado = Auth::user()->id;
        // Variavel para validacao de dominio do registro
        $mesmoID = $idLogado == $validated['id'];
        /*
         * Verifica se usuario que esta tentando executar a acao esta locado
         * Verifica se o usuario tem o perfil de administrado
         * Verifica se o id do usuario logado eh mesmo do enviado na requisicao (autoexclusao) 
         */
        if (is_null(Auth::user()) || ($perfilLogado != 'admin' && !$mesmoID)) {
            return response()->json(['message' => "Usuário não permitido!"], 403);
        }

        if (count($validated) == 0) {
            return response()->json(['message' => "Usuário inválido!"], 400);
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

        $active = UserModel::where('email',$validated['email'])
        ->get()
        ->pluck('active')[0];

        if(!$active){
            return response()->json(['message' => 'A conta se encontra inativa!'], 400);
        }

        Password::sendResetLink($validated);

        if (Password::RESET_LINK_SENT) {
            return response()->json(['message' => 'O link para redefinição de senha foi enviado para o seu e-mail.'], 200);
        }

        return response()->json(['message' => 'Não conseguimos encontrar um usuário com esse e-mail.'], 401);
    }
    /**
     * Metodo para enviar o email de validacao do endereço de email para o usuario.
     * No caso de um registro novo, sera enviado no ato do registro
     * Caso seja necessario, o admin podera reenviar o link de validacao
     */
    public function sendEmailValidation($id, $email): mixed
    {
        if(Auth::user()->profile->label != 'admin'){
            return response()->json(['message' => 'Usuário não tem permissão para realizar essa operação'], 400);
        }

        $validar = Validator::make(['id' => $id, 'email' => $email], [
            'id' => 'required|int',
            'email' => 'required|string|email',
        ]);
        $data = $validar->validated();
        $user = UserModel::where('id', $data['id'])
            ->where('email', $data['email'])
            ->first();
        // Valida os dados de entrada
        if ($validar->fails()) {
            return response()->json(['message' => $validar->errors()], 400);
        }
        // Verifica se o usuario existe
        if (is_null($user)) {
            return response()->json(['message' => 'Usuário não encontrado!'], 400);
        }
        // Se o campo email_verified_at do banco nao for nulo o email ja foi validado
        if ($user->hasVerifiedEmail()) {
            return response()->json(['message' => 'O email já foi validado!'], 400);
        }

        Mail::to($user->email)->send(new ConfirmEmail($user));
        return response()->json(['message' => 'Mensagem de validação de e-mail enviado com sucesso!'], 200);
    }
    /**
     * Metodo para validar o email de um novo usuario ou editado por ele
     * @param Request $request
     * @return JsonResponse
     */
    public function validateEmail(Request $request): JsonResponse
    {
        $user = UserModel::select('id', 'email')->findOrFail($request->id);

        if ($user->hasVerifiedEmail()) {
            return response()->json(['message' => 'O e-mail já foi validado.'], 200);
        }

        if (sha1($user->email) == $request->token && $user->markEmailAsVerified()) {
            event(new Verified($user));
        }

        return response()->json(['message' => 'E-mail validado com sucesso!'], 200);
    }
}
