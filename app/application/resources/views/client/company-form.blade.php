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
                        <nav>
                            <div class="nav nav-tabs mb-4" id="nav-tab" role="tablist">
                                <a class="nav-item nav-link active" id="nav-empresa-tab" data-bs-toggle="tab" href="#nav-empresa" role="tab" aria-controls="nav-empresa" aria-selected="true">Dados da Empresa</a>
                                <a class="nav-item nav-link" id="nav-partners-tab" data-bs-toggle="tab" href="#nav-partners" role="tab" aria-controls="nav-partners" aria-selected="true">Sócios</a>
                                <a class="nav-item nav-link" id="nav-plano-tab" data-bs-toggle="tab" href="#nav-plano" role="tab" aria-controls="nav-plano" aria-selected="false">Plano de serviço</a>
                                <a class="nav-item nav-link" id="nav-cobranca-tab" data-bs-toggle="tab" href="#nav-cobranca" role="tab" aria-controls="nav-cobranca" aria-selected="false">Dados da Cobrança</a>
                                <a class="nav-item nav-link" id="nav-billings-tab" data-bs-toggle="tab" href="#nav-billings" role="tab" aria-controls="nav-billings" aria-selected="false">Faturas</a>
                            </div>
                        </nav>
                        <form>
                            <div class="tab-content" id="nav-tabContent">
                                <div class="tab-pane fade show active" id="nav-empresa" role="tabpanel" aria-labelledby="nav-empresa-tab">
                                    <div class="col-lg-12 col-md-12 bg-gray-100 rounded-lg shadow p-4 mb-3">
                                        <div class="row">
                                            <div class="col-lg-12 col-md-12 mb-3">
                                                <label for="nome">Nome Pretendido</label>
                                                <input type="text" name="nome" id="nome" required class="form-control">
                                            </div>
                                            <div class="col-lg-12 col-md-12 mb-3">
                                                <label for="razao_social">Razão Social</label>
                                                <input type="text" name="razao_social" id="razao_social" required class="form-control">
                                            </div>
                                            <div class="col-lg-6 col-md-6 mb-3">
                                                <label for="cnae">Código CNAE</label>
                                                <input type="text" name="cnae" id="cnae" class="form-control" placeholder="Digite ou busque o código CNAE">
                                            </div>
                                            <div class="col-lg-6 col-md-6 mb-3">
                                                <label for="capital_social">Capital Social</label>
                                                <input type="number" name="capital_social" id="capital_social" step="0.01" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 bg-gray-100 rounded-lg shadow p-4 mb-3">
                                        <div class="row">
                                            <h5 class="mb-3">Endereço</h5>
                                            <div class="col-lg-2 col-md-2 mb-3">
                                                <label for="cep">CEP</label>
                                                <input type="text" name="cep" id="cep" class="form-control">
                                            </div>
                                            <div class="col-lg-4 col-md-4 mb-3">
                                                <label for="logradouro">Logradouro</label>
                                                <input type="text" name="logradouro" id="logradouro" class="form-control">
                                            </div>
                                            <div class="col-lg-1 col-md-2 mb-3">
                                                <label for="numero">Número</label>
                                                <input type="text" name="numero" id="numero" class="form-control">
                                            </div>
                                            <div class="col-lg-5 col-md-4 mb-3">
                                                <label for="complemento">Complemento</label>
                                                <input type="text" name="complemento" id="complemento" class="form-control">
                                            </div>
                                            <div class="col-lg-4 col-md-4 mb-3">
                                                <label for="bairro">Bairro</label>
                                                <input type="text" name="bairro" id="bairro" class="form-control">
                                            </div>
                                            <div class="col-lg-4 col-md-4 mb-3">
                                                <label for="municipio">Município</label>
                                                <input type="text" name="municipio" id="municipio" class="form-control">
                                            </div>
                                            <div class="col-lg-4 col-md-4 mb-3">
                                                <label for="estado">Estado</label>
                                                <select name="estado" id="estado" class="form-control">
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="nav-partners" role="tabpanel" aria-labelledby="nav-partners-tab">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 bg-gray-100 rounded-lg shadow p-4 mb-3">
                                            <div class="row">
                                                <div class="col-12 mb-3">
                                                    <div class="float-end">
                                                        <button type="button" class="btn btn-primary d-flex" id="add-partner" data-bs-toggle="modal" data-bs-target="#modal-form-partner">
                                                            <i class="heroicon heroicon-plus-circle me-2"></i> Adicionar
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="table-responsive">
                                                        <table class="table table-striped table-hover" id="tb-partners">
                                                            <thead class="bg-gray-700 bg-gradient text-white">
                                                                <tr>
                                                                    <th scope="col">Nome</th>
                                                                    <th scope="col">E-mail</th>
                                                                    <th scope="col">Ações</th>
                                                                </tr>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="nav-plano" role="tabpanel" aria-labelledby="nav-plano-tab">
                                    <div class="col-lg-12 col-md-12 bg-gray-100 rounded-lg shadow p-4 mb-3">
                                        <div class="row">
                                            <div class="col-lg-6 col-md-6 mb-3">
                                                <label for="plano_id">Plano</label>
                                                <select name="plano_id" id="plano_id" required class="form-control">
                                                    <option value="">Selecione um plano</option>
                                                </select>
                                            </div>
                                            <div class="col-lg-6 col-md-6 mb-3">
                                                <label for="plano_faixa_id">Faixa do Plano</label>
                                                <select name="plano_faixa_id" id="plano_faixa_id" class="form-control">
                                                    <option value="">Selecione uma faixa</option>
                                                    <!-- Carregar dinamicamente via JavaScript ou Controller -->
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="nav-cobranca" role="tabpanel" aria-labelledby="nav-cobranca-tab">
                                    <div class="col-lg-12 col-md-12 bg-gray-100 rounded-lg shadow p-4 mb-3">
                                        <div class="row">
                                            <div class="col-lg-6 col-md-6 mb-3">
                                                <label for="forma_pgto_id">Forma de Pagamento</label>
                                                <select name="forma_pgto_id" id="forma_pgto_id" required class="form-control">
                                                    <option value="">Selecione</option>
                                                </select>
                                            </div>
                                            <div class="col-lg-6 col-md-6 mb-3">
                                                <label for="dia_cobranca">Dia da Cobrança</label>
                                                <input type="number" name="dia_cobranca" id="dia_cobranca" min="1" max="31" class="form-control">
                                            </div>
                                            <div class="col-lg-6 col-md-6 mb-3">
                                                <label for="recorrencia">Recorrência</label>
                                                <select name="recorrencia" id="recorrencia" class="form-control">
                                                    <option value="mensal">Mensal</option>
                                                    <option value="anual">Anual</option>
                                                </select>
                                            </div>
                                            <div class="col-lg-6 col-md-6 mb-3">
                                                <label for="contrato">Contrato</label>
                                                <input type="file" name="contrato" id="contrato" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="nav-billings" role="tabpanel" aria-labelledby="nav-billings-tab">
                                    <div class="col-lg-12 col-md-12 bg-gray-100 rounded-lg shadow p-4 mb-3">
                                        <div class="row">
                                            <div class="col-lg-12 col-md-12 mb-3">
                                                <div class="table-responsive">
                                                    <table class="table table-striped table-hover" id="tb-billings"s>
                                                        <thead class="bg-gray-700 bg-gradient text-white">
                                                            <tr>
                                                                <th>Descrição</th>
                                                                <th>Valor</th>
                                                                <th>Vencimento</th>
                                                                <th>Status</th>
                                                                <th>Ações</th>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                <button type="submit" form="form-company" class="btn btn-primary">Salvar</button>
            </div>
        </div>
    </div>
</div>

<!-- Script para integração com CEP (opcional) -->
<script>
    document.getElementById('cep').addEventListener('blur', function() {
        let cep = this.value.replace(/\D/g, '');
        if (cep.length === 8) {
            fetch(`https://viacep.com.br/ws/${cep}/json/`)
                .then(response => response.json())
                .then(data => {
                    if (!data.erro) {
                        document.getElementById('logradouro').value = data.logradouro;
                        document.getElementById('bairro').value = data.bairro;
                        document.getElementById('municipio').value = data.localidade;
                        document.getElementById('estado').value = data.uf;
                    }
                });
        }
    });

</script>
