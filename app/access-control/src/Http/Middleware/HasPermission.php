<?php

namespace App\AccessControl\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\AccessControl\Services\RBACService;
use Illuminate\Support\Facades\Auth;

class HasPermission
{
    protected RBACService $rbacService;

    public function __construct(RBACService $rbacService)
    {
        $this->rbacService = $rbacService;
    }

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
        $roles = $user->roles ?? ['guest'];

        foreach($roles as $role){
            // Verifica a permissão no RBAC
            if ($this->rbacService->hasPermission($role, $action)) {
                return $next($request);
            }
        }

        return response()->json(['error' => 'Permissão negada.'], 403);
        
    }
}
