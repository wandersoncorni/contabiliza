<link rel="stylesheet" href="{{ asset('css/step-wizard.css') }}">
<div class="modal fade" id="modal-form-company" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modal-form-company" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header modal-header-dark">
                <h5 class="modal-title">Nova Empresa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <ul class="step-wizard-list">
                            <li class="step-wizard-item current-item">
                                <span class="progress-count">
                                    <i class="heroicon heroicon-modern-house"></i>
                                </span>
                                <span class="progress-label">Dados da Empresa</span>
                            </li>
                            <li class="step-wizard-item">
                                <span class="progress-count">
                                    <i class="heroicon heroicon-usergroup"></i>
                                </span>
                                <span class="progress-label">Dados dos Sócios</span>
                            </li>
                            <li class="step-wizard-item">
                                <span class="progress-count">
                                    <i class="heroicon heroicon-briefcase"></i>
                                </span>
                                <span class="progress-label">Plano de serviço</span>
                            </li>
                            <li class="step-wizard-item">
                                <span class="progress-count">
                                    <i class="heroicon heroicon-currency"></i>
                                </span>
                                <span class="progress-label">Pagamento</span>
                            </li>
                        </ul>
                    </div>
                </div>
                <form id="form-company">
                    <div class="row">
                        <div class="col-12">
                            <div class="tab-content" id="nav-tabContent">
                                <div class="tab-pane fade show active" id="nav-empresa" role="tabpanel" aria-labelledby="nav-empresa-tab">
                                    @include('application::client.company.partials.company')
                                </div>
                                <div class="tab-pane fade" id="nav-partners" role="tabpanel" aria-labelledby="nav-partners-tab">
                                    @include('application::client.company.partials.partners')
                                </div>
                                <div class="tab-pane fade" id="nav-plano" role="tabpanel" aria-labelledby="nav-plano-tab">
                                    @include('application::client.company.partials.plan')
                                </div>
                                <div class="tab-pane fade" id="nav-cobranca" role="tabpanel" aria-labelledby="nav-cobranca-tab">
                                    @include('application::client.company.partials.billing')
                                </div>
                                <div class="tab-pane fade" id="nav-billings" role="tabpanel" aria-labelledby="nav-billings-tab">
                                    @include('application::client.company.partials.billings')
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
            </form>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-info disabled" id="btn-prev">Voltar</button>
                <button type="button" class="btn btn-info" id="btn-next">Próximo</button>
                <button type="button" class="btn btn-primary disabled" id="btn-save-company">Salvar</button>
            </div>
        </div>
    </div>
</div>
