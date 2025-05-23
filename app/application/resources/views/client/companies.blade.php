    <style>
        .nav-tabs .nav-link {
            padding: 0.5em 1em !important;
        }

    </style>
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
                <div class="d-block mb-4 mb-md-0">
                    <h2 class="h4 d-flex">
                        <i class="heroicon heroicon-modern-house me-2" style="width: 24px;height: 24px;"></i> Empresas
                    </h2>
                </div>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <button class="btn btn-sm btn-primary d-inline-flex align-items-center me-2" data-bs-toggle="modal" data-bs-target="#modal-form-company" id="new-company">
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
                            <table id="tb-companies" class="table table-striped table-hover table-app">
                                <thead class="bg-gray-700 bg-gradient text-white">
                                    <tr>
                                        <th>Nome</th>
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

    @include('application::client.company-form')

    @include('application::client.company-partner')

    <script src="{{ asset('js/companies.js') }}"></script>
