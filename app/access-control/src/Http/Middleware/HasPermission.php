<?php

namespace App\AccessControl\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class HasPermission
{
    public function handle(Request $request, Closure $next, $action = null): Response
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['error' => 'Usuário não autenticado.'], 401);
        }

        if (is_null($action)) {
            return response()->json(['error' => 'Permissão não definida'], 403);
        }

        // Obtém a role do usuário
        $roles = $user->person->roles ?? ['guest'];

        if($user->hasPermission($action)){
            return $next($request);
        }

        return response()->json(['error' => 'Permissão negada.'], 403);
        
    }
}
