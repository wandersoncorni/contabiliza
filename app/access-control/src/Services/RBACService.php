<?php

namespace App\AccessControl\Services;

use Exception;
use Laminas\Permissions\Rbac\Rbac;
use Laminas\Permissions\Rbac\Role;
use Illuminate\Support\Facades\Cache;

class RBACService 
{
    protected Rbac $rbac;

    public function __construct($roles = null) {
        $roles = $roles ?? config('rbac.roles');
        $this->rbac = Cache::remember('rbac_roles', 60, fn () => $this->initialize($roles));
    }

    public function initialize($roles){
        $rbac = new Rbac();

        // Criando os perfis com as regras
        $roleObjects = [];
        foreach ($roles as $roleName => $data) {
            $roleObjects[$roleName] = new Role($roleName);
            foreach ($data['permissions'] as $permission) {
                $roleObjects[$roleName]->addPermission($permission);
            }
        }

        // Cria a hierarquia
        foreach ($roles as $roleName => $data) {
            if(!isset($data['parents']) || !count($data['parents'])){
                continue;
            }
            foreach ($data['parents'] as $parent) {
                $roleObjects[$roleName]->addParent($roleObjects[$parent]);
            }
        }
        
        // Adiciona ao RBAC
        foreach ($roleObjects as $role) {
            $rbac->addRole($role);
        }

        return $rbac;
    }

    public function hasPermission(string $role, string $permission): bool {
        try{
            return $this->rbac->isGranted($role, $permission);
        }catch(Exception $e){
            return false;
        }
    }
    
    public function clearCache(): void {
        Cache::forget('rbac_roles');
    }
}
