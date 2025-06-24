<div class="modal fade" id="modal-form-partner" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modal-form-partner" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header modal-header-dark">
                <h5 class="modal-title">Novo Sócio</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form-partner">
                <div class="modal-body">
                    <div class="col-lg-12 col-md-12 bg-gray-100 rounded-lg shadow p-4 mb-3">
                        <div class="row mb-3">
                            <div class="col-lg-6 col-md-5">
                                <label for="nome" class="form-label required">Nome</label>
                                <input type="text" class="form-control" id="nome" name="nome" required>
                            </div>
                            <div class="col-lg-2 col-md-3">
                                <label for="cpf" class="form-label required">CPF</label>
                                <input type="text" class="form-control" id="cpf" name="cpf" required>
                            </div>
                            <div class="col-lg-2 col-md-3">
                                <label for="telefone" class="form-label">Telefone</label>
                                <input type="text" class="form-control" id="telefone" name="telefone">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-6">
                                <label for="email" class="form-label">E-mail</label>
                                <input type="email" class="form-control" id="email" name="email">
                            </div>
                            <div class="col-6">
                                <label for="profissao" class="form-label">Profissão</label>
                                <input type="text" class="form-control" id="profissao" name="profissao">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-6">
                                <label for="estado_civil" class="form-label">Estado Civil</label>
                                <input type="text" class="form-control" id="estado_civil" name="estado_civil">
                            </div>
                            <div class="col-6">
                                <label for="regime_bens" class="form-label">Regime de Bens</label>
                                <input type="text" class="form-control" id="regime_bens" name="regime_bens">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 bg-gray-100 rounded-lg shadow p-4 mb-3">
                        <div class="row mb-3">
                            <div class="col-6 mb-3">
                                <label for="logradouro" class="form-label">Endereço</label>
                                <input type="text" class="form-control" id="logradouro" name="logradouro">
                            </div>
                            <div class="col-6 mb-3">
                                <label for="numero" class="form-label">Número</label>
                                <input type="text" class="form-control" id="numero" name="numero">
                            </div>
                            <div class="col-6 mb-3">
                                <label for="complemento" class="form-label">Complemento</label>
                                <input type="text" class="form-control" id="complemento" name="complemento">
                            </div>
                            <div class="col-6 mb-3">
                                <label for="bairro" class="form-label">Bairro</label>
                                <input type="text" class="form-control" id="bairro" name="bairro">
                            </div>
                            <div class="col-6 mb-3">
                                <label for="cep" class="form-label">CEP</label>
                                <input type="text" class="form-control" id="cep" name="cep">
                            </div>
                            <div class="col-6 mb-3">
                                <label for="estado" class="form-label">Estado</label>
                                <input type="text" class="form-control" id="estado" name="estado">
                            </div>
                            <div class="col-6 mb-3">
                                <label for="municipio" class="form-label">Município</label>
                                <input type="text" class="form-control" id="municipio" name="municipio">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 bg-gray-100 rounded-lg shadow p-4 mb-3">
                        <div class="row mb-3">
                            <div class="col-6">
                                <label for="prolabore" class="form-label">Prolabore</label>
                                <input type="text" class="form-control" id="prolabore" name="prolabore">
                            </div>
                            <div class="col-6">
                                <label class="form-label required">Responsável perante a Receita Federal</label>
                                <div class="p-1">
                                    <label for="resp_rf_0" class="form-label me-5">Não <input type="radio" class="form-check-input" id="resp_rf_0" name="resp_rf" value="0" required></label>
                                    <label for="resp_rf_1" class="form-label">Sim <input type="radio" class="form-check-input" id="resp_rf_1" name="resp_rf" value="1" required></label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#modal-form-company">Fechar</button>
                    <button type="submit" form="form-partner" class="btn btn-primary">Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>
