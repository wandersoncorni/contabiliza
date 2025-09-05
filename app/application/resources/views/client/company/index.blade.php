<link type="text/css" href="{{ asset('css/step-wizard.css') }}" rel="stylesheet">
<style>
    .nav-tabs .nav-link {
        padding: 0.5em 1em !important;
    }

    label.required::after,
    label[required]::after {
        content: " *";
        color: red;
    }
    .col-value{
        padding: 24px 0 0 15px;
    }
    .hidden {
        display: none;
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
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <nav>
                            <div class="nav nav-tabs mb-4" id="nav-tab" role="tablist">
                                <a class="nav-item nav-link active" id="nav-companies-tab" data-bs-toggle="tab" href="#nav-companies" role="tab" aria-controls="nav-companies" aria-selected="true">Empresas</a>
                                <a class="nav-item nav-link" id="nav-company-tab" data-bs-toggle="tab" href="#nav-company" role="tab" aria-controls="nav-company" aria-selected="false">Solicitações de abertura de empresa</a>
                            </div>
                        </nav>
                        <div class="tab-content" id="companyTabContent">
                            <div class="tab-pane fade show active" id="nav-companies" role="tabpanel" aria-labelledby="tab-companies">
                                <div class="table-responsive">
                                    <table id="tb-companies" class="table table-striped table-hover table-app">
                                        <thead class="bg-gray-700 bg-gradient text-white">
                                            <tr>
                                                <th width="1%">CNPJ</th>
                                                <th>Nome</th>
                                                <th width="1%">Ações</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="nav-company" role="tabpanel" aria-labelledby="tab-company">
                                <div class="btn-toolbar d-flex mb-3">
                                    <button class="btn btn-sm btn-tertiary ms-auto d-flex" data-bs-toggle="modal" data-bs-target="#modal-form-company" id="new-company">
                                        <i class="heroicon heroicon-plus-circle me-2"></i> Novo
                                    </button>
                                </div>
                                <div class="table-responsive">
                                    <table id="tb-new-companies" class="table table-striped table-hover table-app">
                                        <thead class="bg-gray-700 bg-gradient text-white">
                                            <tr>
                                                <th>Nome Fantasia</th>
                                                <th width="1%">Estado</th>
                                                <th width="1%">Situação</th>
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
    </div>
</div>

@include('application::client.company.form')

<script src="{{ asset('js/company/company.js') }}"></script>
