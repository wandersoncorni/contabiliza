<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card bg-gray-100 shadow mb-3">
            <div class="card-body">
                <form id="form-config-plan">
                    <div class="row">
                        <input type="hidden" name="id" id="id">
                        <div class="col-lg-6 col-md-6 mb-3">
                            <label for="nome" class="form-label">Nome do Plano</label>
                            <select class="form-select" id="lista-planos" name="plano_servico_id" required>
                                <option value="" selected disabled>Selecione um plano</option>
                            </select>
                        </div>
                        <div class="col-lg-4 col-md-4 mb-3">
                            <label for="lista-categorias" class="form-label">Categoria</label>
                            <select class="form-select" id="lista-categorias" name="categoria_servico_id"  required>
                                <option value="" selected disabled>Selecione uma categoria</option>
                            </select>
                        </div>
                        <div class="col-lg-2 col-md-2 mb-3">
                            <label for="status" class="form-label">Estado</label>
                            <select class="form-select" id="status" name="status" required>
                                <option value="1" selected>Ativo</option>
                                <option value="0">Inativo</option>
                            </select>
                        </div>
                        <div class="col-lg-12 col-md-12 mb-3">
                            <label for="lista-servicos" class="form-label">Serviços</label>
                            <select class="form-select rounded-2" id="lista-servicos" name="servico_id" required multiple>
                            </select>
                        </div>
                        <div class="col-lg-12 col-md-12 mb-3">
                            <button type="submit" class="btn btn-primary ms-2 rounded-2 d-flex float-end" id="add-service">Salvar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
