<?php

use App\AccessControl\Services\RBACService;
use Illuminate\Support\Facades\Cache;

beforeEach(function () {
    Cache::forget('rbac_roles'); // Limpa o cache antes de cada teste
    $this->rbacService = new RBACService();
});
// Valida permissoes e herancas]
it('usuário tem as permissoes corretas', function () {
    // O perfil "cliente" pode criar um agente e o root herda a permissao
    expect($this->rbacService->hasPermission('root', 'create.agent'))->toBeTrue();
    expect($this->rbacService->hasPermission('root', 'delete.agent'))->toBeTrue();
    // O gerente pode criar, editar ou excluir um cliente e herda as permissoes dos seus subordinados
    expect($this->rbacService->hasPermission('manager', 'create.client'))->toBeTrue();
    expect($this->rbacService->hasPermission('manager', 'update.client'))->toBeTrue();
    expect($this->rbacService->hasPermission('manager', 'delete.client'))->toBeTrue();
    // O consultor pode criar e editar mas nao excluir um cliente
    expect($this->rbacService->hasPermission('consultant', 'create.client'))->toBeTrue();
    expect($this->rbacService->hasPermission('consultant', 'update.client'))->toBeTrue();
    expect($this->rbacService->hasPermission('consultant', 'delete.client'))->toBeFalse();
    // O cliente pode criar, editar e excluir um agente
    expect($this->rbacService->hasPermission('client', 'create.agent'))->toBeTrue();
    expect($this->rbacService->hasPermission('client', 'update.agent'))->toBeTrue();
    expect($this->rbacService->hasPermission('client', 'delete.agent'))->toBeTrue();

});

it('permssoes a rotas', function () {
    // O gerente herda as permissoes do consultor
    expect($this->rbacService->hasPermission('consultant', 'access.users_route'))->toBeTrue();
});

it('persitencia do cache', function () {
    $this->rbacService->clearCache();
    $rbacService = new RBACService();
    $rbacService->getRbac()->addRole('superadmin');
    // O novo papel "superadmin" deve estar carregado
    expect($rbacService->getRbac()->hasRole('superadmin'))->toBeTrue();
});

it('limpeza do cache', function () {
    // Garante que o cache inicial está setado
    Cache::put('rbac_roles', ['testrole' => ['permissions' => ['dummy'], 'children' => []]], 3600);

    // Apaga o cache e reinicializa o serviço
    $this->rbacService->clearCache();
    $this->rbacService = new RBACService();

    // O cache original foi apagado, então a permissão dummy não deve existir mais
    expect($this->rbacService->hasPermission('testrole', 'dummy'))->toBeFalse();
});

it('expiração do cache', function () {
    $this->rbacService->clearCache();
    expect($this->rbacService->getRbac()->hasRole('admin'))->toBeFalse();
});
