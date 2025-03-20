<?php

namespace App\AccessControl\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;
use App\AccessControl\Models\User;

class Authentication
{
    /**
     * Metodo para fazer o login do usuario
     * Condição: O usuario deve estar ativo
     * Para a versao 3 do elattes foi implementada a funcionalidade para
     * trocar o tipo do hash da senha de MD5 para argon2id
     * @param Request $request
     * @return JsonResponse
     */
    public function login(Request $request): JsonResponse
    {
        //Validacao dos dados de entrada
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);
        //Executa a validacao
        if (!$validator->fails()) {
            // Recupera o usuário pelo email
            $user = User::select('id', 'password', 'active','email_verified_at')->where('email', $request->email)->first();
            if ($user) {
                
                if (!$user->hasVerifiedEmail()) {
                    return response()->json(['error' => 'Verifique seu e-mail antes de fazer login.'], 403);
                }

                // Verifica se o usuário esta ativo
                if ((int)$user->active == 0) {
                    return response()->json(['error' => 'Conta inativa! Verifique seu email ou informe ao administrador.'], 403);
                }

                // Verifica se a senha é MD5 e troca para argon
                if (strlen($user->password) == 32) {
                    // Senha armazenada é MD5, faz a validação com MD5
                    if (md5($request->password) !== $user->password) {
                        return response()->json(['error' => 'Credenciais inválidas.'], 401);
                    }

                    // Se a senha estiver correta, converte para Argon2id
                    $user->password = Hash::make($request->password);
                    $user->save();
                }

                if (Auth::attempt($validator->validated())) {
                    $user = Auth::user();
                    $token = $user->createToken('app')->plainTextToken; 
                    return response()->json(['token' => $token], 200);
                }
            }
        }
        return response()->json(['error' => 'Credenciais inválidas!'], 401);
    }
    /**
     * Metodo para fazer o logout do usuario
     * @return void
     */
    public function logout()
    {   
        if (!Auth::check()) {dd('ok');
            return redirect()->route('login');
        }

        Auth::user()->tokens->each(function ($token) {
            $token->delete();
        });

        return redirect()->route('login.view');
    }
}
