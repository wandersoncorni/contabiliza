<?php
use App\AccessControl\Services\RBACService;
$rbacService = new RBACService();

$menuItens = [];
$userRoles = Auth::user()->person->roles;
/**
 * O array de intens de menu que esta na configuracao possui, entre outro,
 * indice que define os perfis (roles) que podem ver o item.
 * Se não for definido um perfil, o item serah exibido para todos
 */
foreach(Config('menu') as $item) {
    if(!isset($item['roles'])){
        $menuItens[] = $item;
        continue;
    }
    foreach($userRoles as $role) {
        if(in_array($role, $item['roles'])) {
            $menuItens[] = $item;
        }
    }
}
?>
@push('scripts')
<script>
    const menuItens = @php print json_encode($menuItens);
    @endphp;
</script>
@endpush
<nav id="sidebarMenu" class="sidebar d-lg-block bg-gray-800 text-white collapse" data-simplebar>
    <div class="sidebar-inner px-4 pt-3">
        <div class="user-card d-flex d-md-none align-items-center justify-content-between justify-content-md-center pb-4">
            <div class="d-flex align-items-center">
                <div class="avatar-lg me-4">
                    <img src="{{Auth::user()->photo ?? $userImage}}" class="card-img-top rounded-circle" style="background-color: #dfdfdf;" alt="{{Auth::user()->name}}">
                </div>
                <div class="d-block">
                    <h2 class="h5 mb-3">{{Auth::user()->person->name}}</h2>
                    <button type="button" class="btn btn-white btn-logout" >
                        <i class="heroicon heroicon-out-left" style="margin-top: 0px;float: left;"></i>
                        Sair
                    </button>
                </div>
            </div>
            <div class="collapse-close d-md-none">
                <a href="#sidebarMenu" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="true" aria-label="Toggle navigation">
                    <svg class="icon icon-xs" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </a>
            </div>
        </div>
        <ul class="nav flex-column pt-3 pt-md-0">
            <li class="nav-item">
                <a href="/" class="d-flex align-items-center mb-4">
                    <span class="sidebar-icon mb-2">
                        <img src="/img/logo3.png" alt="ContabilizaTech">
                    </span>
                </a>
            </li>
        </ul>
    </div>
</nav>