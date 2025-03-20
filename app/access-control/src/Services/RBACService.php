<?php

namespace App\AccessControl\Services;

use Exception;
use Laminas\Permissions\Rbac\Rbac;
use Laminas\Permissions\Rbac\Role;
use Illuminate\Support\Facades\Cache;
use App\AccessControl\Models\Role as RoleModel;
use App\AccessControl\Models\Permission;

class RBACService 
{
    protected Rbac $rbac;
    /**
     * Construtor
     * 
     * @param array $roles
     */
    public function __construct() {
        if(!Cache::has('rbac_roles')){
            $this->rbac = Cache::remember('rbac_roles', 60, fn () => $this->initialize());
        }
        $this->rbac = Cache::get('rbac_roles');
    }
    /**
     * Inicia o RBAC
     * 
     * @param array $roles
     */
    public function initialize(){
        $rbac = new Rbac();
        $permissions = Permission::with(['role:id,parent_id,label', 'action:id,label','asset:id,label','role.parent:id,label'])->get()->toArray();
        $roles = $roles ?? RoleModel::select(['id','name','label','parent_id'])->where('deleted_at', null)->get()->toArray();

        $rbac->setCreateMissingRoles(true);
        $rbac->addRole(new Role('root'));
        foreach ($permissions as $permission) {
            $role = $permission['role']['label'];
            if(!$rbac->hasRole($role)){
                $rbac->addRole(new Role($role));
            }
            $rbac->getRole($role)->addParent($rbac->getRole($permission['role']['parent']['label']));
            $rbac->getRole($role)->addPermission($permission['action']['label'].'.'. $permission['asset']['label']);
        }
        
        return $rbac;
    }
    /**
     * Verifica se o usuário tem permissão
     * 
     * @param string $role
     * @param string $permission
     */
    public function hasPermission(string $role, string $permission): bool {
        try{
            return $this->rbac->isGranted($role, $permission);
        }catch(Exception $e){
            return false;
        }
    }

    public function getRbac(): Rbac {
        return $this->rbac;
    }
    /**
     * Limpa o cache do RBAC
     */
    public function clearCache(): void {
        $this->rbac = new Rbac();
        Cache::forget('rbac_roles');
    }
}
