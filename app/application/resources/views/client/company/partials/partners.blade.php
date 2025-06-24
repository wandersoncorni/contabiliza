<style>
.accordion-item.is-invalid {
    border-color: #dc3545 !important;
}
</style>
<div class="row">
    <div class="col-lg-12 col-md-12 bg-gray-100 rounded-lg shadow p-4 mb-3">
        <div class="row">
            <div class="col-12 mb-3">
                <div class="float-end">
                    <button type="button" class="btn btn-primary d-flex" id="add-partner">
                        <i class="heroicon heroicon-plus-circle me-2"></i> Adicionar
                    </button>
                </div>
            </div>
            
            <div class="progress-wrapper mt-2 mb-3">
                <div class="progress-info">
                    <div class="h6 mb-0">Participação dos sócios</div>
                    <div class="small fw-bold text-gray-500">
                        <span>0 %</span>
                    </div>
                </div>
                <div class="progress mb-0">
                    <div class="progress-bar bg-info" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>
                </div>
            </div>
        </div>
        {{-- <div class="row">
            <div class="col-12">
                <div class="table-responsive">
                    <table class="table table-striped table-hover" id="tb-partners">
                        <thead class="bg-gray-700 bg-gradient text-white">
                            <tr>
                                <th>Nome</th>
                                <th width="1%">Receita Federal</th>
                                <th width="1%">Ações</th>
                            </tr>
                    </table>
                </div>
            </div>
        </div> --}}
        <div class="accordion mb-3" id="accordionForm1">
            <div class="accordion-item">
                <h2 class="accordion-header" id="headerForm1">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseForm1" aria-expanded="false" aria-controls="collapseForm1">
                        Sócio 1
                    </button>
                </h2>
                <div id="collapseForm1" class="accordion-collapse collapse" aria-labelledby="headerForm1" data-bs-parent="#accordionForm1">
                    <div class="accordion-body">
                        <div class="modal-body">
                            <div class="col-lg-12 col-md-12 bg-gray-100 rounded-lg shadow p-4 mb-3">
                                <h5 class="mb-3">Dados pessoais</h5>
                                <div class="row mb-3">
                                    <div class="col-lg-6 col-md-5">
                                        <label for="nome" class="form-label">Nome</label>
                                        <input type="text" class="form-control" name="socio[][nome]" required />
                                    </div>
                                    <div class="col-lg-3 col-md-3">
                                        <label for="cpf" class="form-label">CPF</label>
                                        <input type="text" class="form-control cpf" name="socio[][cpf]" required />
                                    </div>
                                    <div class="col-lg-3 col-md-3">
                                        <label for="telefone" class="form-label">Telefone</label>
                                        <input type="text" class="form-control phone" name="socio[][telefone]" required />
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-6">
                                        <label for="email" class="form-label">E-mail</label>
                                        <input type="email" class="form-control" name="socio[][email]" required />
                                    </div>
                                    <div class="col-6">
                                        <label for="profissao" class="form-label">Profissão</label>
                                        <input type="text" class="form-control" name="socio[][profissao]" required />
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-6">
                                        <label for="estado_civil" class="form-label">Estado Civil</label>
                                        <input type="text" class="form-control" name="socio[][estado_civil]" required />
                                    </div>
                                    <div class="col-6">
                                        <label for="regime_bens" class="form-label">Regime de Bens</label>
                                        <input type="text" class="form-control" name="socio[][regime_bens]" required />
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12 bg-gray-100 rounded-lg shadow p-4 mb-3">
                                <h5 class="mb-3">Endereço</h5>
                                <div class="row mb-3">
                                    <div class="col-lg-2 col-md-2 mb-3">
                                        <label for="cep" class="form-label">CEP</label>
                                        <input type="text" name="socio[][cep]" class="form-control cep" data-address="socio1" required />
                                    </div>
                                    <div class="col-lg-4 col-md-4 mb-3">
                                        <label for="logradouro">Logradouro</label>
                                        <input type="text" name="socio[][logradouro]" class="form-control" data-address="socio1" required />
                                    </div>
                                    <div class="col-lg-1 col-md-2 mb-3">
                                        <label for="numero">Número</label>
                                        <input type="text" name="socio[][numero]" class="form-control" data-address="socio1" />
                                    </div>
                                    <div class="col-lg-5 col-md-4 mb-3">
                                        <label for="complemento">Complemento</label>
                                        <input type="text" name="socio[][complemento]" class="form-control" data-address="socio1" />
                                    </div>
                                    <div class="col-lg-4 col-md-4 mb-3">
                                        <label for="bairro">Bairro</label>
                                        <input type="text" name="socio[][bairro]" class="form-control" data-address="socio1" required />
                                    </div>
                                    <div class="col-lg-4 col-md-4 mb-3">
                                        <label for="localidade">Município</label>
                                        <input type="text" name="socio[][localidade]" class="form-control" data-address="socio1" required />
                                    </div>
                                    <div class="col-lg-4 col-md-4 mb-3">
                                        <label for="uf">Estado</label>
                                        <select name="socio[][uf]" class="form-control form-select uf" data-address="socio1" required ></select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12 bg-gray-100 rounded-lg shadow p-4 mb-3">
                                <h5 class="mb-3">Participação societária</h5>
                                <div class="row">
                                    <div class="col-12 d-flex align-items-center mb-3">
                                        <label for="prolabore" class="form-label me-3">Prolabore</label>
                                        <input type="text" class="form-control percentage" style="width: 70px;" name="socio[][prolabore]" placeholder="0%" required />
                                    </div>
                                    <div class="col-12 d-flex align-items-center mb-3">
                                        <label for="participacao" class="form-label me-3">Percentual de Participação sobre o Capital</label>
                                        <input type="text" class="form-control percentage participacao" style="width: 70px;" placeholder="0%" name="socio[][participacao]" required />
                                    </div>
                                    <div class="col-12 d-flex align-items-center">
                                        <label class="form-label me-3">Responsável perante a Receita Federal</label>
                                        <div class="p-1 ">
                                            <label for="resp_rf_0" class="form-label me-3">Não 
                                                <input type="radio" class="form-check-input" id="resp_rf_0" name="socio[][resp_rf]" value="0" required>
                                            </label>
                                            <label for="resp_rf_1" class="form-label">Sim 
                                                <input type="radio" class="form-check-input" id="resp_rf_1" name="socio[][resp_rf]" value="1" required>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
