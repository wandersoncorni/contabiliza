<?php

namespace App\AccessControl\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class HasPermission
{
    public function handle(Request $request, Closure $next, $actions = null): Response
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['error' => 'Usuário não autenticado.'], 401);
        }

        if (is_null($actions)) {
            return response()->json(['error' => 'Permissão não definida'], 403);
        }

        // Obtém o perfil do usuário
        $roles = $user->person->roles ?? ['guest'];
        $actions = explode('|', $actions);

        foreach ($actions as $action) {
            if ($user->hasPermission($action)) {
                return $next($request);
            }
        }

        return response()->json(['error' => 'Permissão negada.'], 403);
    }
}
