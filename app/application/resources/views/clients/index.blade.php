<div class="row">
    <div class="col-md-12">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
            <div class="d-block mb-4 mb-md-0">
                <h2 class="h4 d-flex">
                    <i class="heroicon heroicon-users me-2" style="width: 24px;height: 24px;"></i> Clientes
                </h2>
            </div>
            <div class="btn-toolbar mb-2 mb-md-0">
                <button class="btn btn-sm btn-primary d-inline-flex align-items-center me-2" data-bs-toggle="modal" data-bs-target="#modal-form-client" id="new-client">
                    <i class="heroicon heroicon-plus-circle me-2"></i> Novo
                </button>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                        <div class="table-responsive">
                            <table id="tb-clients" class="table table-striped table-hover table-app">
                                <thead class="bg-gray-700 bg-gradient text-white">
                                    <tr>
                                        <th>Nome</th>
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
<div class="modal fade" id="modal-form-client" tabindex="-1" role="dialog" aria-labelledby="modal-form-client" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header modal-header-dark">
                <h5 class="modal-title">Novo Licenciado</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="form-client" method="POST" action="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nome</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                <button type="submit" form="form-client" class="btn btn-primary">Salvar</button>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('js/clients.js') }}"></script>