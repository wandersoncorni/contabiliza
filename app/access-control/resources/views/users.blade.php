 <style>
     .table th,
     .table td {
         vertical-align: middle;
     }

     .table th {
         font-size: inherit !important;
         text-transform: none !important;
     }
    #search-users {
        background-image: url('data:image/svg+xml,<svg data-slot="icon" aria-hidden="true" fill="%23afafaf" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path clip-rule="evenodd" d="M9 3.5a5.5 5.5 0 1 0 0 11 5.5 5.5 0 0 0 0-11ZM2 9a7 7 0 1 1 12.452 4.391l3.328 3.329a.75.75 0 1 1-1.06 1.06l-3.329-3.328A7 7 0 0 1 2 9Z" fill-rule="evenodd"></path></svg>');
        background-repeat: no-repeat;
        background-position: 0px center;
        padding-left: 30px;
        background-size: 24px;
    }
    .dt-search {
        display: none;
    }
</style>
<div class="row">
    <div class="col-md-12">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
            <div class="d-block mb-4 mb-md-0">
                <h2 class="h4 d-flex">
                    <i class="heroicon heroicon-users me-2" style="width: 24px;height: 24px;"></i> Usuários
                </h2>
            </div>
            <div class="btn-toolbar mb-2 mb-md-0">
                <button class="btn btn-sm btn-primary d-inline-flex align-items-center me-2" data-bs-toggle="modal" data-bs-target="#modal-form-user" id="new-user">
                    <i class="heroicon heroicon-user-plus me-2"></i> Novo Usuário
                </button>
                <button class="btn btn-sm btn-danger d-inline-flex align-items-center disabled" disabled="disabled">
                    <i class="heroicon heroicon-trash me-2"></i> Excluir Usuários
                </button>
            </div>
        </div>
    </div>
</div>
<div class="col-md-12">
    <div class="table-settings mb-4">
        <div class="row justify-content-between align-items-center">
            <div class="col-12 d-md-flex">
                <div class="input-group me-2 me-lg-3 fmxw-300">
                <input type="text" class="form-control" placeholder="Buscar usuários" aria-label="Search" id="search-users">
            </div>
            <select class="form-select d-none w-auto pe-5 d-md-inline me-2 me-lg-3" aria-label="Perfil" id="filter-perfil">
                <option value="todos"selected="selected">Todos os perfis</option>
                <option>Administrador</option>
                <option>Gerente</option>
                <option>Consultor</option>
                <option>Cliente</option>
                <option>Agente</option>
            </select>
            <select class="form-select w-auto pe-5 d-none d-md-inline me-2 me-lg-3" aria-label="Status" id="filter-status">
                <option value="todos" selected="selected">Todos os estados</option>
                <option value="Ativo">Ativo</option>
                <option value="Inativo">Inativo</option>
                <option value="Pendente">Pendente</option>
            </select>
            <div>
                <button type="button" class="btn btn-xs btn-transparent" id="clear-user-filters" title="Limpar filtros">
                    <i class="heroicon erase-icon"></i>
                </button>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card card-primary card-outline">
            <div class="card-body">
                <div class="row">
                        <div class="table-responsive">
                            <table id="users-table" class="table table-striped table-hover">
                                <thead class="bg-gray-700 bg-gradient text-white">
                                    <tr>
                                        <th width="1%"><input type="checkbox" id="check-all"></th>
                                        <th>Usuário</th>
                                        <th width="1%">Perfil</th>
                                        <th width="1%">Estado</th>
                                        <th width="1%">Criado em</th>
                                        <th width="1%">Ações</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-form-user" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-header-dark">
                <h5 class="modal-title">Novo Usuário</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="form-user" method="POST" action="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nome</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="role_id" class="form-label">Perfil</label>
                        <select class="form-select" id="role_id" name="role_id"></select>
                    </div>
                    @if(Auth::user()->hasRole('admin'))
                    <div class="mb-3">
                        <label for="licensed_id" class="form-label">Licenciado</label>
                        <select class="form-select" id="licensed_id" name="licensed_id"></select>
                    </div>
                    @endif
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                <button type="submit" form="form-user" class="btn btn-primary">Salvar</button>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('vendor/datatables/datatables.min.js') }}"></script>
<script src="{{ asset('js/users.js') }}"></script>
