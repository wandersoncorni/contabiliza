<?php

use App\AccessControl\Services\RBACService;
use Illuminate\Support\Facades\Cache;

beforeEach(function () {
    Cache::forget('rbac_roles'); // Limpa o cache antes de cada teste
    $this->rbacService = new RBACService();
});

it('usuário tem as permissoes corretas', function () {
    expect($this->rbacService->hasPermission('root', 'create.user'))->toBeTrue();
    expect($this->rbacService->hasPermission('root', 'delete.user'))->toBeTrue();
    expect($this->rbacService->hasPermission('admin', 'create.user'))->toBeTrue();
    expect($this->rbacService->hasPermission('manager', 'create.user'))->toBeTrue();
    expect($this->rbacService->hasPermission('consultant', 'create.register'))->toBeTrue();
    expect($this->rbacService->hasPermission('client', 'read.reports'))->toBeTrue();

    // O usuário normal não pode excluir usuários
    expect($this->rbacService->hasPermission('client', 'delete.user'))->toBeFalse();
});

it('a hierarquia de pefis está correta', function () {
    // Root pode tudo
    expect($this->rbacService->hasPermission('root', 'create.user'))->toBeTrue();
    expect($this->rbacService->hasPermission('root', 'update.user'))->toBeTrue();
    expect($this->rbacService->hasPermission('root', 'delete.user'))->toBeTrue();
    expect($this->rbacService->hasPermission('root', 'read.reports'))->toBeTrue();

    // Admin herda de user e pode criar/atualizar, mas não excluir
    expect($this->rbacService->hasPermission('admin', 'create.user'))->toBeTrue();
    expect($this->rbacService->hasPermission('admin', 'update.user'))->toBeTrue();
    expect($this->rbacService->hasPermission('admin', 'read.reports'))->toBeTrue();
    expect($this->rbacService->hasPermission('consultant', 'read.reports'))->toBeTrue();
    expect($this->rbacService->hasPermission('consultant', 'delete.user'))->toBeFalse();

    // User só pode ver relatórios
    expect($this->rbacService->hasPermission('client', 'read.reports'))->toBeTrue();
    expect($this->rbacService->hasPermission('client', 'create.user'))->toBeFalse();
});

it('cache persistence', function () {
    $this->rbacService->clearCache();
    $this->rbacService = new RBACService([
        'superadmin' => [
            'permissions' => ['manage.everything'],
            'parents' => []
        ]
    ]);
        
    // O novo papel "superadmin" deve estar carregado
    expect($this->rbacService->hasPermission('superadmin', 'manage.everything'))->toBeTrue();

    // O papel "admin" original não deve estar no cache modificado
    expect($this->rbacService->hasPermission('admin', 'create.user'))->toBeFalse();
});

it('clear cache works', function () {
    // Garante que o cache inicial está setado
    Cache::put('rbac_roles', ['testrole' => ['permissions' => ['dummy'], 'children' => []]], 3600);

    // Apaga o cache e reinicializa o serviço
    $this->rbacService->clearCache();
    $this->rbacService = new RBACService();

    // O cache original foi apagado, então a permissão dummy não deve existir mais
    expect($this->rbacService->hasPermission('testrole', 'dummy'))->toBeFalse();
});
