<style>
    #tb-accounts tbody tr td:last-child {
        vertical-align: middle;
    }
    .icon {
        width: 24px;
        height: 24px;
    }
    .icon-xs {
        width: 16px;
        height: 16px;
    }
</style>
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
                <div class="d-block mb-4 mb-md-0">
                    <h2 class="h4 d-flex">
                        <i class="heroicon heroicon-banknotes me-2" style="width: 24px; height: 24px;"></i> Contas
                    </h2>
                </div>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <button class="btn btn-sm btn-primary d-inline-flex align-items-center me-2" data-bs-toggle="modal" data-bs-target="#modal-form-account" id="new-account">
                        <i class="heroicon heroicon-plus-circle me-2"></i> Novo
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card border-0 shadow">
                <div class="card-body">
                    <div class="row">
                        <div class="table-responsive">
                            <table id="tb-accounts" class="table table-striped table-hover table-app">
                                <thead class="bg-gray-700 bg-gradient text-white">
                                    <tr>
                                        <th>Nome do Banco</th>
                                        <th>Código do Banco</th>
                                        <th>Agência</th>
                                        <th>Número da Conta</th>
                                        <th>Status</th>
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
    <div class="modal fade" id="modal-form-account" tabindex="-1" role="dialog" aria-labelledby="modal-form-account" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header modal-header-dark">
                    <h5 class="modal-title">Nova Conta</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="form-account" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="id">
                        <div class="mb-3">
                            <label for="company_id" class="form-label">Empresa</label>
                            <select class="form-control" id="company_id" name="company_id" required>
                                <option selected>Selecione uma empresa</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="bank_name" class="form-label">Nome do Banco</label>
                            <input type="text" class="form-control" id="bank_name" name="bank_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="bank_code" class="form-label">Código do Banco</label>
                            <input type="text" class="form-control" id="bank_code" name="bank_code" required>
                        </div>
                        <div class="mb-3">
                            <label for="agency" class="form-label">Agência</label>
                            <input type="text" class="form-control" id="agency" name="agency" required>
                        </div>
                        <div class="mb-3">
                            <label for="account_number" class="form-label">Número da Conta</label>
                            <input type="text" class="form-control" id="account_number" name="account_number" required>
                        </div>
                        <div class="mb-3">
                            <label for="digit" class="form-label">Dígito</label>
                            <input type="text" class="form-control" id="digit" name="digit">
                        </div>
                        <div class="mb-3">
                            <label for="manager_name" class="form-label">Nome do Gerente</label>
                            <input type="text" class="form-control" id="manager_name" name="manager_name">
                        </div>
                        <div class="mb-3">
                            <label for="contact_phone" class="form-label">Telefone de Contato</label>
                            <input type="text" class="form-control" id="contact_phone" name="contact_phone">
                        </div>
                        <div class="mb-3">
                            <label for="account_type" class="form-label">Tipo de Conta</label>
                            <select class="form-control" id="account_type" name="account_type">
                                <option value="">Selecione</option>
                                <option value="Corrente">Corrente</option>
                                <option value="Poupança">Poupança</option>
                                <option value="Salário">Salário</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-control" id="status" name="status" required>
                                <option value="active">Ativo</option>
                                <option value="pending">Pendente</option>
                                <option value="inactive">Inativo</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="pix_key" class="form-label">Chave PIX</label>
                            <input type="text" class="form-control" id="pix_key" name="pix_key">
                        </div>
                        <div class="mb-3">
                            <label for="notes" class="form-label">Observações</label>
                            <textarea class="form-control" id="notes" name="notes" rows="4"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    <button type="submit" form="form-account" class="btn btn-primary">Salvar</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="{{ asset('js/financial/accounts.js') }}"></script>