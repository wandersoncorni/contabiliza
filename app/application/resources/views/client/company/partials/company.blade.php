<div class="col-lg-12 col-md-12 bg-gray-100 rounded-lg shadow p-4 mb-3">
    <div class="row">
        <div class="col-lg-12 col-md-12 mb-3">
            <label for="nome" class="required">Nome Pretendido</label>
            <input type="text" name="company[nome]" id="nome" required class="form-control">
        </div>
        <div class="col-lg-12 col-md-12 mb-3">
            <label for="razao_social" class="required">Razão Social</label>
            <input type="text" name="company[razao_social]" id="razao_social" required class="form-control">
        </div>
        <div class="col-lg-6 col-md-6 mb-3">
            <label for="cnae">Código CNAE</label>
            <select name="company[cnae]" id="cnae" class="form-control form-select" required >
                <option value="">Selecione o CNAE</option>
                <option value="A">A - Agricultura, pecuária, produção florestal, pesca e aqüicultura</option>
                <option value="B">B - Indústrias extrativas</option>
                <option value="C">C - Indústrias de transformação</option>
                <option value="D">D - Eletricidade e gás</option>
                <option value="E">E - Água, esgoto, atividades de gestão de resíduos e descontaminação</option>
                <option value="F">F - Construção</option>
                <option value="G">G - Comércio; reparação de veículos automotores e motocicletas</option>
                <option value="H">H - Transporte, armazenagem e correio</option>
                <option value="I">I - Alojamento e alimentação</option>
                <option value="J">J - Informação e comunicação</option>
                <option value="K">K - Atividades financeiras, de seguros e serviços relacionados</option>
                <option value="L">L - Atividades imobiliárias</option>
                <option value="M">M - Atividades profissionais, científicas e técnicas</option>
                <option value="N">N - Atividades administrativas e serviços complementares</option>
                <option value="O">O - Administração pública, defesa e seguridade social</option>
                <option value="P">P - Educação</option>
                <option value="Q">Q - Saúde humana e serviços sociais</option>
                <option value="R">R - Artes, cultura, esporte e recreação</option>
                <option value="S">S - Outras atividades de serviços</option>
                <option value="T">T - Serviços domésticos</option>
                <option value="U">U - Organismos internacionais e outras instituições extraterritoriais</option>
            </select>
        </div>
        <div class="col-lg-6 col-md-6 mb-3">
            <label for="capital_social">Capital Social</label>
            <input type="text" name="company[capital_social]" id="capital_social" class="form-control" required />
        </div>
    </div>
</div>
<div class="col-lg-12 col-md-12 bg-gray-100 rounded-lg shadow p-4 mb-3">
    <div class="row">
        <h5 class="mb-3">Endereço</h5>
        <div class="col-lg-2 col-md-2 mb-3">
            <label for="cep">CEP</label>
            <input type="text" name="company[cep]" class="form-control cep" data-address="company" required />
        </div>
        <div class="col-lg-4 col-md-4 mb-3">
            <label for="logradouro">Logradouro</label>
            <input type="text" name="company[logradouro]" class="form-control" data-address="company" required />
        </div>
        <div class="col-lg-1 col-md-2 mb-3">
            <label for="numero">Número</label>
            <input type="text" name="company[numero]" class="form-control" data-address="company" />
        </div>
        <div class="col-lg-5 col-md-4 mb-3">
            <label for="complemento">Complemento</label>
            <input type="text" name="company[complemento]" class="form-control" data-address="company" />
        </div>
        <div class="col-lg-4 col-md-4 mb-3">
            <label for="bairro">Bairro</label>
            <input type="text" name="company[bairro]" class="form-control" data-address="company" required />
        </div>
        <div class="col-lg-4 col-md-4 mb-3">
            <label for="localidade">Município</label>
            <input type="text" name="company[localidade]" class="form-control" data-address="company" required />
        </div>
        <div class="col-lg-4 col-md-4 mb-3">
            <label for="uf">Estado</label>
            <select name="company[uf]" class="form-control form-select uf" data-address="company"  required ></select>
        </div>
    </div>
</div>
<input type="hidden" name="company_id" id="company_id">
