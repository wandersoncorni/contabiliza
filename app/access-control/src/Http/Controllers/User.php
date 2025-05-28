<?php

namespace App\AccessControl\Http\Controllers;

use App\AccessControl\Models\User as UserModel;
use App\AccessControl\Mail\EmailConfirmacaoEdicao;
use App\AccessControl\Http\Requests\UserValidationRequest;
use App\AccessControl\Mail\UserDeletedMail;
use App\AccessControl\Models\Role;
use App\AccessControl\Notifications\NewUser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Auth\Events\Registered;
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
        $query = UserModel::select('id','email', 'email_verified_at', 'active', 'created_at' );
        // Se o usuario nao for admin, ele so pode ver os usuarios da sua empresa licenciada para uso da aplicacao
        if(!Auth::user()->hasRole('admin')){
            $query->whereHas('person', function ($query) {
                $query->where('id_licensed', Auth::user()->person->id_licensed);
            });
        }
        $query->with([
            'person:id,id_user,id_licensed,name,roles,photo',
            'person.licensed:id,name',
            'person.client',
        ]);
        $roles = Role::all();
        $usersList = $query->get();
        $usersList->map(function ($user) use ($roles) {
            $user->person->role_name = $roles->where('label', $user->person->roles[0])->first()['name'];
            return $user;
        });
        return response()->json($usersList, 200);
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
    public function create(UserValidationRequest $req): JsonResponse
    {
        $formData = $req->all();

        // Verifica se o perfil selecionado eh de agente e se foi informado o id do cliente
        if ($formData['role'] == 'agent' && (!isset($formData['id_client']) || empty($formData['id_client']))) {
            return response()->json(['error' => 'Informe o cliente para o perfil de agente.'], 400);
        }
        // Valida se o usuario logado tem permissão para criar um usuario com o perfil selecionado
        if (!Auth::user()->hasPermission('any.any') && !Auth::user()->hasPermission('create.' . $formData['role'])) {
            return response()->json(['error' => 'Você nao tem permissão para criar um usuario com o perfil selecionado.'], 403);
        }
        // Cria a senha aleatoria
        $formData = array_merge($formData, ['password' => Hash::make(Str::random(8))]);

        // Criar o usuário
        $user = UserModel::create(['email' => $formData['email'], 'password' => $formData['password'], 'active' => 1]);

        if (!$user) {
            return response()->json(['message' => 'Erro ao criar o usuário.'], 500);
        }
        // Cria a pessoa relacionada ao usuario e associa a um cliente ou agente se for o caso
        try {
            $formData['id_user'] = $user->id;
            $formData['roles'] = [$formData['role']];
            $formData['id_licensed'] = Auth::user()->person->id_licensed; // Pega o licenciado do usuario logado
            if ($formData['role'] == 'agent') {
                $formData['id_client'] = $formData['id_client'] ?? null; // Se for agente, pega o cliente
            } 
            \App\Application\Models\Person::create($formData);
        } catch (\Exception $e) {
            Log::channel('database')->error('user.create:' . $e->getMessage());
            $user->delete();
            return response()->json(['message' => 'Erro ao criar o usuário e pessoa.'], 500);
        }
        // Disparar evento de verificação de email
        event(new Registered($user));

         UserModel::whereHas('person', function ($query) {
            $query->where('roles', 'LIKE', '%admin%');
        })->each(fn ($admin) => $admin->notify(new NewUser()));

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
                'id_user' => $user->id,
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

        $user = UserModel::with(['person.licensed'])->find($validated['id']);
        // Valida a permissao do suario       
        if (!Auth::user()->hasPermission('any.any')) {
            $canDelete = false;
            $authLicensedId = Auth::user()->person->id_licensed;// Id do licenciado do usuario logado
            $userLicensedId = $user->person->id_licensed;// Id do licenciado do usuario a ser excluido
            $userRole = $user->person->roles[0];// Pega o primeiro perfil do usuario a ser excluido
            
            if (!is_null($authLicensedId) && !is_null($userLicensedId) && ($authLicensedId == $userLicensedId)) {
                if (Auth::user()->hasPermission('delete.' . $userRole)) {
                    $canDelete = true;
                }
            }                
            if (!$canDelete) {
                return response()->json(['error' => "Você não tem permissão para excluir o usuário $user->name!"], 403);
            }
        }

        if ($user && $user->delete()) {
            // Loga a acao e o responsavel
            Log::channel('database')->warning('Exclusao de usuario', [
                'id_user' => $user->id,
                'Nome' => $user->name,
                'acao' => 'Exclusao de usuario',
                'autor' => Auth::user()->person->name
            ]);
            Mail::to($user->email)->send(new UserDeletedMail($user));
            return response()->json(['message' => "O usuário $user->name foi excluído com sucesso!"], 200);
        };
        return response()->json(['error' => "Ocorreu um erro ao tentar excluir o usuário $user->name!"], 400);
    }
}
