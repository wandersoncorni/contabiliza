<div class="row">
    <div class="col-12">
        <div class="card bg-gray-100 shadow mb-3 p-2">
            <form id="form-service">
                <div class="col-lg-12 col-md-12 mb-3">
                    <label for="services" class="form-label">Nome</label>
                    <input type="text" class="form-control rounded-2" id="nome" name="nome" />
                </div>
                <div class="col-lg-12 col-md-12 mb-3 text-end">
                    <button type="submit" class="btn btn-primary ms-2 rounded-2">Salvar</button>
                </div>
                <input type="hidden" id="id" name="id" />
            </form>
            <div class="col-lg-12 col-md-12">
                <table id="tb-services" class="table table-striped table-hover table-app">
                    <thead class="bg-gray-700 bg-gradient text-white">
                        <tr>
                            <th>Nome</th>
                            <th width="1%">Ações</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
