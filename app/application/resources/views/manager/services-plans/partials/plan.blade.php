<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card bg-gray-100 shadow mb-3">
            <div class="card-body">
                <form id="form-service-plan">
                    <input type="hidden" id="id" name="id" />
                    <div class="row">
                        <div class="col-12 mb-3">
                            <label for="nome" class="form-label">Nome</label>
                            <input type="text" class="form-control" id="nome" name="nome" required />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 mb-3">
                            <label for="nome" class="form-label">Descrição</label>
                            <textarea class="form-control" id="descricao" name="descricao"></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4 col-md-4 mb-3">
                            <label for="valor_mensal" class="form-label">Valor mesal</label>
                            <input type="text" class="form-control currency" id="valor_mensal" name="valor_mensal" required />
                        </div>
                        <div class="col-lg-4 col-md-4 mb-3">
                            <label for="valor_anual" class="form-label">Valor anual</label>
                            <input type="text" class="form-control currency" id="valor_anual" name="valor_anual" required />
                        </div>
                        <div class="col-lg-4 col-md-4 mb-3">
                            <label for="ativo" class="form-label">Estado</label>
                            <select class="form-select" id="ativo" name="ativo" required>
                                <option value="1" selected>Ativo</option>
                                <option value="0">Inativo</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-sm btn-primary d-flex float-end mb-3">Salvar</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <table id="tb-services-plans" class="table table-striped table-hover table-app">
                        <thead class="bg-gray-700 bg-gradient text-white">
                            <tr>
                                <th>Nome</th>
                                <th>Descrição</th>
                                <th width="1%">Valor mensal</th>
                                <th width="1%">Valor anual</th>
                                <th width="1%">Estado</th>
                                <th width="1%">Ações</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
