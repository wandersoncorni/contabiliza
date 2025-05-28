<?php

namespace App\AccessControl\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;
use App\AccessControl\Models\User;

class Authentication
{
    /**
     * Metodo para fazer o login do usuario
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
            $user = User::select('id', 'password', 'active', 'email_verified_at')->where('email', $request->email)->first();
            if ($user) {
                // Verifica se o usuário esta ativo
                if ((int)$user->active == 0) {
                    return response()->json(['error' => 'Conta inativa! Verifique seu email ou informe ao administrador.'], 403);
                }
                // Verifica se a senha eh valida
                $credencials = [
                    'email' => $request->email,
                    'password' => $request->password,
                    'active' => 1,
                ];
                // Autentica o usuário
                if (Auth::attempt($credencials)) {
                    // Verifica se o usuário estah verificado
                    if (!$user->hasVerifiedEmail()) {
                        if (!is_null(session('verify'))) {
                            $verify = session('verify');
                            session()->forget('verify');
                            $host = $request->getHost();
                            $request = Request::create("https://{$host}/api/v1/email/verify/{$user->id}/{$verify['hash']}?expires={$verify['expires']}&signature={$verify['signature']}", 'GET');

                            $request->setUserResolver(fn() => auth()->user());
                            $response = app()->handle($request);
                            if ($response->getStatusCode() !== 200) {
                                return response()->json(['error' => 'Link de verificação inválido!'], $response->getStatusCode());
                            }
                            if (!$user->fresh()->hasVerifiedEmail()) {
                                return response()->json(['error' => 'Ocorreu um erro ao tentar validar seu e-mail.'], 403);
                            }
                        } else {
                            return response()->json(['error' => 'Verifique seu e-mail antes de fazer login.'], 403);
                        }
                    }
                    session()->regenerate();
                    
                    // Insere o conntexto de autenticação
                    $uRole = Auth::user()->person->roles[0];
                    $uid = Auth::user()->person->id;
                    $lid = Auth::user()->person->id_licensed;
                    session([
                        'rule_context' => $uRole,
                        'client_context' => $uid ?? ($uRole == 'client' ? $uid : null),
                        'licensed_context' => $lid
                    ]);
                    return response()->json([], 200);
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
        session()->invalidate();
        session()->regenerateToken();
        return response()->json([], 200);
    }
}
