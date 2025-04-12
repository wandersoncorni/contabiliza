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
            // id 2
            [
                'name' => 'Administrador',
                'label' => 'admin',
                'parent_id' => 1
            ],
            // id 3
            [
                'name' => 'Gerente',
                'label' => 'manager',
                'parent_id' => 2
            ],
            // id 4
            [
                'name' => 'Consultor',
                'label' => 'consultant',
                'parent_id' => 3
            ],
            // id 5
            [
                'name' => 'Cliente',
                'label' => 'client',
                'parent_id' => 4
            ],
            // id 6
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
            ['name' => 'Ação irrestrita', 'label' => 'any'], // id 1
            ['name' => 'Usuário administrador', 'label' => 'admin'], // id 2
            ['name' => 'Usuário gerente', 'label' => 'manager'], // id 3
            ['name' => 'Usuário consultor', 'label' => 'consultant'], // id 4
            ['name' => 'Usuário cliente', 'label' => 'client'], // id 5
            ['name' => 'Usuário Adminitrativo do Cliente', 'label' => 'agent'], // id 6
            ['name' => 'Usuário do sistema', 'label' => 'user'], // id 7
            ['name' => 'Reenvio de email', 'label' => 'email_resend'], // id 8
            ['name' => 'Mudar estado do perfil adminstrador', 'label' => 'change_state_admin'], // id 9
            ['name' => 'Mudar estado do perfil gerente', 'label' => 'change_state_manager'], // id 10
            ['name' => 'Mudar estado do perfil consultor', 'label' => 'change_state_consultant'], // id 11        
            ['name' => 'Mudar estado do perfil cliente', 'label' => 'change_state_client'], // id 12
            ['name' => 'Mudar estado do perfil agent', 'label' => 'change_state_agent'], // id 13
            ['name' => 'Todos usuarios', 'label' => 'users'], // id 14
        ];
        foreach ($assets as $asset) {
            Asset::factory()->create($asset);
        }

        $actions = [
            // Todas as ações
            [
                'name' => 'Qualquer ação',
                'label' => 'any'
            ],
            // Id 2
            [
                'name' => 'Criar',
                'label' => 'create'
            ],
            // Id 3
            [
                'name' => 'Ler',
                'label' => 'read'
            ],
            // Id 4
            [
                'name' => 'Editar',
                'label' => 'update'
            ],
            // Id 5
            [
                'name' => 'Excluir',
                'label' => 'delete'
            ],
            // Id 6
            [
                'name' => 'Executar',
                'label' => 'execute'
            ]
            // Id 7
            ,
            [
                'name' => 'Mudar estado',
                'label' => 'change_state'
            ],
            // Id 8
            [
                'name' => 'Enviar email',
                'label' => 'send_email'
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
            ['role_id' => 2, 'action_id' => 1, 'asset_id' => 14], // O admin pode manter qualquer coisa
            
            ['role_id' => 3, 'action_id' => 2, 'asset_id' => 4], // O gerente pode criar um consultor
            ['role_id' => 3, 'action_id' => 4, 'asset_id' => 4], // O gerente pode editar um consultor
            ['role_id' => 3, 'action_id' => 5, 'asset_id' => 4], // O gerente pode excluir um consultor

            ['role_id' => 3, 'action_id' => 5, 'asset_id' => 5], // O gerente pode excluir um cliente

            ['role_id' => 4, 'action_id' => 2, 'asset_id' => 5], // O consultor pode criar um cliente
            ['role_id' => 4, 'action_id' => 4, 'asset_id' => 5], // O consultor pode editar um cliente
            ['role_id' => 4, 'action_id' => 8, 'asset_id' => 14], // O consultor pode enviar email aos usuarios

            ['role_id' => 4, 'action_id' => 5, 'asset_id' => 6], // O consultor pode excluir um agente
            
            ['role_id' => 5, 'action_id' => 2, 'asset_id' => 6], // O cliente pode criar um agente
            ['role_id' => 5, 'action_id' => 4, 'asset_id' => 6], // O cliente pode editar um agente
            ['role_id' => 5, 'action_id' => 5, 'asset_id' => 6], // O cliente pode excluir um agente
        ];

        foreach ($permissions as $permission) {
            Permission::factory()->create($permission);
        }
    }
}
