<style>
    .list-group-item {
        cursor: pointer;
        background: transparent;
    }
    #tb-plans tbody tr td:last-child {
        vertical-align: middle;
    }
</style>
<div class="row">
    <div class="col-md-12">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
            <div class="d-block mb-4 mb-md-0">
                <h2 class="h4 d-flex">
                    <i class="heroicon heroicon-users me-2" style="width: 24px;height: 24px;"></i> Planos de serviços
                </h2>
            </div>
            <div class="btn-toolbar mb-2 mb-md-0">
                <button class="btn btn-sm btn-primary d-inline-flex align-items-center me-2" data-bs-toggle="modal" data-bs-target="#modal-form-plan" id="new-plan">
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
                        <table id="tb-plans" class="table table-striped table-hover table-app">
                            <thead class="bg-gray-700 bg-gradient text-white">
                                <tr>
                                    <th>Nome</th>
                                    <th width="1%">Categoria</th>
                                    <th width="1%">Serviço</th>
                                    <th width="1%">Ações</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<div class="modal fade" id="modal-form-plan" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modal-form-plan" aria-hidden="true">
    <div class="modal-dialog modal-lg model-" role="document">
        <div class="modal-content">
            <div class="modal-header modal-header-dark">
                <h5 class="modal-title">Novo Plano de serviços</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <nav>
                    <div class="nav nav-tabs mb-4 custom-nav-tab" id="nav-tab" role="tablist">
                        <a class="nav-item nav-link active" id="nav-config-tab" data-bs-toggle="tab" href="#nav-config" role="tab" aria-controls="nav-config" aria-selected="true">Plano de serviços</a>
                        <a class="nav-item nav-link" id="nav-plan-tab" data-bs-toggle="tab" href="#nav-plan" role="tab" aria-controls="nav-plan" aria-selected="true">Plano</a>
                        <a class="nav-item nav-link" id="nav-category-tab" data-bs-toggle="tab" href="#nav-category" role="tab" aria-controls="nav-category" aria-selected="true">Categoria</a>
                        <a class="nav-item nav-link" id="nav-service-tab" data-bs-toggle="tab" href="#nav-service" role="tab" aria-controls="nav-service" aria-selected="false">Serviço</a>
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-config" role="tabpanel" aria-labelledby="nav-plan-tab">
                        @include('application::manager.services-plans.partials.service-plan')
                    </div>
                    <div class="tab-pane fade" id="nav-plan" role="tabpanel" aria-labelledby="nav-plan-tab">
                        @include('application::manager.services-plans.partials.plan')
                    </div>
                    <div class="tab-pane fade" id="nav-category" role="tabpanel" aria-labelledby="nav-category-tab">
                        @include('application::manager.services-plans.partials.category')
                    </div>
                    <div class="tab-pane fade" id="nav-service" role="tabpanel" aria-labelledby="nav-service-tab">
                        @include('application::manager.services-plans.partials.service')
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="{{ asset('js/service-plan/index.js') }}"></script>
