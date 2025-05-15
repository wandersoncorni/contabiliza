<?php

namespace App\AccessControl\Http\Controllers;

use App\AccessControl\Models\User as UserModel;
use App\AccessControl\Mail\UserDeletedMail;
use App\AccessControl\Http\Requests\RegisterValidationRequest;
use App\AccessControl\Mail\UserCreatedAdminNotification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\Registered;

/**
 * Classe para manutencao da conta do usuario
 */
class Account
{
    /**
     * Lista os dados da conta de um usuario
     * @param Request $request
     */
    public function list(Request $request): JsonResponse
    {
        return response()->json(['message' => 'Conta listada com sucesso!'], 200);
    }
    /**
     * Cria a conta do cliente
     * @param Request $request
     */
    public function create(RegisterValidationRequest $request): JsonResponse
    {
        $formData = $request->all();
        if(!isset($formData['password'])){
            return response()->json(['error' => 'O campo "Senha" é obrigatorio.'], 400);
        }
        $user = null;
        try {
            $user = UserModel::create($request->all(['email', 'password']));
        } catch (\Exception $e) {
            Log::channel('database')->error('Erro ao criar um novo usuário.', [$e->getMessage()]);
            if ($e->getCode() == 23000) {
                return response()->json(['message' => 'Email já cadastrado!'], 400);
            }
            return response()->json(['message' => 'Erro ao criar o usuário.'], 500);
        }

        if (!$user) {
            return response()->json(['message' => 'Erro ao criar o usuário.'], 500);
        }

        try {
            $user->active = true;
            $user->save();
            \App\Application\Models\Person::create([
                'user_id' => $user->id,
                'name' => $formData['name'],
                'roles' => ['client'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } catch (\Exception $e) {
            Log::channel('database')->error('Erro ao criar uma nova pessoa.', [$e->getMessage()]);
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
     * Atualiza dados da conta
     * @param Request $request
     */
    public function update(RegisterValidationRequest $request): JsonResponse
    {
        $validatedData = $request->all();

        if(isset($validatedData['password']) && !isset($validatedData['current_password'])){
            return response()->json(['error' => 'O campo "Senha atual" eh obrigatorio.'], 400);
        }

        if (isset($validatedData['password']) && !Hash::check($validatedData['current_password'], Auth::user()->password)) {
            return response()->json(['error' => ' A senha atual não confere!'], 401);
        }

        if (isset($validatedData['name'])) {
            Auth::user()->person->name = $validatedData['name'];
            Auth::user()->person->save();
        }

        if (Auth::user()->update($validatedData) && Auth::user()->save()) {
            if (isset($validatedData['email'])) {
                Auth::user()->update(['email_verified_at' => null]);
                Auth::user()->save();
                event(new Registered(Auth::user()));
            }
            return response()->json(['message' => 'Conta atualizada com sucesso!'], 200);
        }

        return response()->json(['error' => 'Ocorreu um erro ao tenttar atualizar sua conta!'], 400);
    }
    /**
     * Deleta a conta do usuario
     * @param Request $request
     */
    public function delete(Request $request): JsonResponse
    {
        request()->merge(['id' => Auth::user()->id]);// Adiciona o ID do usuario a requisicao para acionar o observer
        if (Auth::user()->delete()) {
            Mail::to(Auth::user()->email)->send(new UserDeletedMail(Auth::user()));
            Log::channel('database')->info('Exclusão da conta pelo usuário', ['user_id' => Auth::user()->id, 'email' => Auth::user()->email]);
            session()->flush();
            session()->regenerate();
            return response()->json(['message' => 'Conta deletada com sucesso!'], 200);
        }
        return response()->json(['error' => 'Ocorreu um erro ao tenttar deletar sua conta!'], 400);
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
