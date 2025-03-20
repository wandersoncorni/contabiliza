<?php

namespace App\AccessControl\Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\AccessControl\Models\User;
use App\AccessControl\Models\Role;
use App\AccessControl\Models\Action;
use App\AccessControl\Models\Asset;
use App\AccessControl\Models\Permission;
use App\AccessControl\Models\UserRole;

class RbacSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Popula a tabela de perfis
        $roles = [
            [
                'name' => 'Super usuário',
                'label' => 'root',
                'parent_id' => null
            ],
            [
                'name' => 'Administrador',
                'label' => 'admin',
                'parent_id' => 1
            ],
            [
                'name' => 'Gerente',
                'label' => 'manager',
                'parent_id' => 2
            ],
            [
                'name' => 'Consultor',
                'label' => 'consultant',
                'parent_id' => 3
            ],
            [
                'name' => 'Cliente',
                'label' => 'client',
                'parent_id' => 4
            ],
            [
                'name' => 'Agente',
                'label' => 'agent',
                'parent_id' => 5
            ],
        ];
        foreach ($roles as $role) {
            Role::factory()->create($role);
        }

        // Popula a tabela de recursos/ativos (assets)
        $assets = [
            ['name' => 'Usuário administrador', 'label' => 'admin'],
            ['name' => 'Usuário gerente', 'label' => 'manager'],
            ['name' => 'Usuário consultor', 'label' => 'consultant'],
            ['name' => 'Usuário cliente', 'label' => 'client'],
            ['name' => 'Usuário Adminitrativo do Cliente', 'label' => 'agent'],
            ['name' => 'Usuário do sistema', 'label' => 'user'],
            ['name' => 'Reenvio de email', 'label' => 'email_resend'],
            // ['name' => 'Reenvio de email', 'label' => 'change_state_admin'],
            // ['name' => 'Reenvio de email', 'label' => 'change_state_manager'],
            // ['name' => 'Reenvio de email', 'label' => 'change_state_consultant'],            
            // ['name' => 'Reenvio de email', 'label' => 'change_state_client'],
            // ['name' => 'Reenvio de email', 'label' => 'change_state_agent'],
        ];
        foreach ($assets as $asset) {
            Asset::factory()->create($asset);
        }

        $actions = [
            [
                'name' => 'Criar',
                'label' => 'create'
            ],
            [
                'name' => 'Ler',
                'label' => 'read'
            ],
            [
                'name' => 'Editar',
                'label' => 'update'
            ],
            [
                'name' => 'Excluir',
                'label' => 'delete'
            ],
            [
                'name' => 'Executar',
                'label' => 'execute'
            ]
            ,
            [
                'name' => 'Mudar estado',
                'label' => 'change_state'
            ]
        ];
        foreach ($actions as $action) {
            Action::factory()->create($action);
        }

        /*
         * Ids das ações:
         * 1 - Criar
         * 2 - Ler
         * 3 - Editar
         * 4 - Excluir
         * 5 - Executar
         * 
         * Ids dos perfis:
         * 1 - root
         * 2 - admin
         * 3 - manager
         * 4 - consultant
         * 5 - client
         * 6 - agent
         * 7 - user
         * 
         * Ids dos ativos:
         * 1 - admin
         * 2 - manager
         * 3 - consultant
         * 4 - client
         * 5 - agent
         * 6 - user
         * 7 - email_resend
         */
        $permissions = [
            // O admin pode criar, editar e excluir qualquer perfil
            ['role_id' => 2, 'action_id' => 1, 'asset_id' => 1],
            ['role_id' => 2, 'action_id' => 3, 'asset_id' => 1],
            ['role_id' => 2, 'action_id' => 4, 'asset_id' => 1],
            ['role_id' => 2, 'action_id' => 6, 'asset_id' => 1],

            // O admin pode criar, editar e excluir um perfil gerente
            ['role_id' => 2, 'action_id' => 1, 'asset_id' => 2],
            ['role_id' => 2, 'action_id' => 3, 'asset_id' => 2],
            ['role_id' => 2, 'action_id' => 4, 'asset_id' => 2],
            ['role_id' => 2, 'action_id' => 6, 'asset_id' => 2],

            // O gerente pode criar, editar e excluir um perfil gerente, consultor e cliente
            ['role_id' => 3, 'action_id' => 1, 'asset_id' => 3],
            ['role_id' => 3, 'action_id' => 3, 'asset_id' => 3],
            ['role_id' => 3, 'action_id' => 4, 'asset_id' => 3],
            ['role_id' => 3, 'action_id' => 4, 'asset_id' => 4],

            ['role_id' => 4, 'action_id' => 1, 'asset_id' => 4],
            ['role_id' => 4, 'action_id' => 3, 'asset_id' => 4],
            ['role_id' => 4, 'action_id' => 5, 'asset_id' => 7],

            // O cliente pode criar, editar e excluir um agente (pessoa que representa o cliente)
            ['role_id' => 5, 'action_id' => 1, 'asset_id' => 5],
            ['role_id' => 5, 'action_id' => 3, 'asset_id' => 5],
            ['role_id' => 5, 'action_id' => 4, 'asset_id' => 5],
        ];
        foreach ($permissions as $permission) {
            Permission::factory()->create($permission);
        }
    }
}
