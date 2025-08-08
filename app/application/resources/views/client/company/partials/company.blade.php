<div class="col-lg-12 col-md-12 bg-gray-100 rounded-lg shadow p-4 mb-3">
    <div class="row">    
        <input type="hidden" name="id" id="id" value="" />
        <div class="col-lg-12 col-md-12 mb-3">
            <label for="nome_fantasia">Nome Pretendido</label>
            <input type="text" name="nome_fantasia" id="nome_fantasia" required class="form-control" />
        </div>
        <div class="col-lg-12 col-md-12 mb-3">
            <label for="razao_social">Razão Social</label>
            <input type="text" name="razao_social" id="razao_social" required class="form-control" />
        </div>
        <div class="col-lg-6 col-md-6 mb-3">
            <label for="cnae">Código CNAE</label>
            <select name="cnae_id" id="cnae" class="form-select" required></select>
        </div>
        <div class="col-lg-6 col-md-6 mb-3">
            <label for="regime_tributario">Regime de tributário</label>
            <select name="regime_tributario_id" id="regime_tributario" class="form-select" required></select>
        </div>
        <div class="col-lg-6 col-md-6 mb-3">
            <label for="capital_social">Capital Social</label>
            <input type="text" name="capital_social" id="capital_social" class="form-control" required />
        </div>
        <div class="col-lg-6 col-md-6 mb-3">
            <label for="area_atividade">Área de atividade</label>
            <select name="area_atividade_id" id="area_atividade" class="form-select" required></select>
        </div>
        <div class="col-lg-6 col-md-6 mb-3">
            <label for="faixa_faturamento">Faixa de faturamento</label>
            <select name="faixa_faturamento_id" id="faixa_faturamento" class="form-select" required></select>
        </div>
        <div class="col-lg-6 col-md-6 mb-3">
            <label for="natureza_juridica">Natureza Jurídica</label>
            <select name="natureza_juridica_id" id="natureza_juridica" class="form-select" required></select>
        </div>
        <div class="col-lg-6 col-md-6 mb-3">
            <label for="total_funcionarios">Total de funcionários da folha de pagamento</label>
            <input type="number" name="total_funcionarios" id="total_funcionarios" class="form-control" required />
        </div>
    </div>
</div>
<div class="col-lg-12 col-md-12 bg-gray-100 rounded-lg shadow p-4 mb-3">
    <div class="row">
        <h5 class="mb-3">Endereço</h5>
        <div class="col-lg-2 col-md-2 mb-3">
            <label for="cep">CEP</label>
            <input type="text" name="cep" class="form-control" id="cep-company" data-address="company" required />
        </div>
        <div class="col-lg-4 col-md-4 mb-3">
            <label for="logradouro">Logradouro</label>
            <input type="text" name="logradouro" id="logradouro" class="form-control" data-address="company" required />
        </div>
        <div class="col-lg-2 col-md-3 mb-3">
            <label for="numero">Número</label>
            <input type="text" name="numero" id="numero" class="form-control" data-address="company" />
        </div>
        <div class="col-lg-4 col-md-3 mb-3">
            <label for="complemento">Complemento</label>
            <input type="text" name="complemento" id="complemento" class="form-control" data-address="company" />
        </div>
        <div class="col-lg-4 col-md-4 mb-3">
            <label for="bairro">Bairro</label>
            <input type="text" name="bairro" id="bairro" class="form-control" data-address="company" required />
        </div>
        <div class="col-lg-4 col-md-4 mb-3">
            <label for="localidade">Município</label>
            <input type="text" name="localidade" id="localidade" class="form-control" data-address="company" required />
        </div>
        <div class="col-lg-4 col-md-4 mb-3">
            <label for="uf">Estado</label>
            <select name="estado" id="uf" class="form-select uf" data-address="company" required></select>
        </div>
    </div>
</div>