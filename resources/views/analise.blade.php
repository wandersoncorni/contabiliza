<ul class="nav nav-tabs" id="analiseTab" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="anlise-form-tab" data-bs-toggle="tab" data-bs-target="#analise-form" type="button" role="tab" aria-controls="analise-form" aria-selected="true">Elementos da análise</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="analise-config-tab" data-bs-toggle="tab" data-bs-target="#analise-config" type="button" role="tab" aria-controls="analise-config" aria-selected="false">Configurações avançadas</button>
    </li>
</ul>
<div class="tab-content p-2 bg-white" style="min-height: 75vh;" id="analiseTabContent">
    <div class="tab-pane show active" id="analise-form" role="tabpanel" aria-labelledby="form-tab">
        <form>
            <div class="row">
                <div class="col-6 mb-3">
                    <label for="name" class="form-label">Nome da análise *</label>
                    <input type="email" class="form-control" id="name" name="name">
                </div>
                <div class="col-3 mb-3">
                    <label for="from" class="form-label">De *</label>
                    <input type="text" class="form-control" id="from"  name="from">
                </div>
                <div class="col-3 mb-3">
                    <label for="to" class="form-label">Até *</label>
                    <input type="text" class="form-control" id="to"  name="to">
                </div>
                <div class="col-12 mb-3">
                    <label for="description" class="form-label">Descrição *</label>
                    <textarea name="description" id="description"  class="form-control"></textarea>
                </div>
                <div class="col-8 mb-3">
                    <input type="text" class="form-control" placeholder="Procurar por..." aria-label="Procurar por..." aria-describedby="search-peaple-to-add-input">
                </div>
                <div class="col-4 mb-3">
                    <button class="btn btn-outline-primary" type="button" data-bs-toggle="modal" data-bs-target="#importacaoModal">Importar dados de um CSV</button>
                </div>
                <div class="col-12 mb-3">
                    <table class="table table-striped table-hover" id="table-list">
                        <thead>
                            <tr>
                                <th  style="width: 1px;">
                                    <input type="checkbox" id="todos" />
                                </th>
                                <th>Nome</th>
                                <th style="width: 1px;">CPF</th>
                                <th style="width: 1px;">ID Lattes</th>
                                <th style="width: 1px;">Cv XML</th>
                                <th style="width: 1px;">De</th>
                                <th style="width: 1px;">Até</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </form>
    </div>
    <div class="tab-pane" id="analise-config" role="tabpanel" aria-labelledby="config-tab">
        <div class="row">
            <div class="col-lg-4 col-md-4" style="border-right: solid 1px #dfdfdf;">
                <h4>Publicações</h4>
                <div class="mb-3 row">
                    <label for="area_de_avaliacao" class="col-8 form-label">Área de avaliação</label>
                    <div class="col-4">
                        <select name="area_de_avaliacao" id="area_de_avaliacao" class="form-select col-8">
                            <option value="Nenhuma" selected>Nenhuma</option>
                            <option value="Biodiversidade">Biodiversidade</option>
                            <option value="Biotecnologia">Biotecnologia</option>
                            <option value="Ciencias Biologicas I">Ciências Biológicas I</option>
                            <option value="Ciencias Biologicas II">Ciências Biológicas II</option>
                            <option value="Ciencias Biolegicas III">Ciências Biológicas III</option>
                            <option value="Ensino">Ensino</option>
                            <option value="Farmacia">Farmácia</option>
                            <option value="Historia">História</option>
                            <option value="Interdisciplinar">Interdisciplinar</option>
                            <option value="Medicina I">Medicina I</option>
                            <option value="Medicina II">Medicina II</option>
                            <option value="Medicina Veterinaria">Medicina Veterinária</option>
                            <option value="Saude Coletiva">Saúde Coletiva</option>
                        </select>
                    </div>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="incluir_artigo_em_periodico" id="incluir_artigo_em_periodico" checked>
                    <label class="form-check-label" for="incluir_artigo_em_periodico">
                        Artigo em periódico
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="incluir_livro_publicado" id="incluir_livro_publicado" checked>
                    <label class="form-check-label" for="incluir_livro_publicado">
                        Livro publicado
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="incluir_capitulo_de_livro_publicado" id="incluir_capitulo_de_livro_publicado" checked>
                    <label class="form-check-label" for="incluir_capitulo_de_livro_publicado">
                        Capítulo de livro publicado
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="incluir_texto_em_jornal_de_noticia" id="incluir_texto_em_jornal_de_noticia" checked>
                    <label class="form-check-label" for="incluir_texto_em_jornal_de_noticia">
                        Texto em jornal de notiícia
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="incluir_trabalho_em_congresso" id="incluir_trabalho_em_congresso" checked>
                    <label class="form-check-label" for="incluir_trabalho_em_congresso">
                        Trabalho em congresso
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="incluir_artigo_aceito_para_publicacao" id="incluir_artigo_aceito_para_publicacao" checked>
                    <label class="form-check-label" for="incluir_artigo_aceito_para_publicacao">
                        Artigo aceito para publicação
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="incluir_outro_tipo_de_producao_bibliografica" id="incluir_outro_tipo_de_producao_bibliografica" checked>
                    <label class="form-check-label" for="incluir_outro_tipo_de_producao_bibliografica">
                        Outro tipo de producao bibliográfica
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="incluir_patentes" id="incluir_patentes" checked>
                    <label class="form-check-label" for="incluir_patentes">
                        Patentes
                    </label>
                </div>
            </div>
            <div class="col-lg-4 col-md-4" style="border-right: solid 1px #dfdfdf;">
                <h4>Orientações</h4>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="incluir_artigo_em_periodico" id="incluir_orientacao_em_andamento_pos_doutorado" checked>
                    <label class="form-check-label" for="incluir_orientacao_em_andamento_pos_doutorado">
                        Em andamento de pós doutorado
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="incluir_orientacao_em_andamento_doutorado" id="incluir_orientacao_em_andamento_doutorado" checked>
                    <label class="form-check-label" for="incluir_orientacao_em_andamento_doutorado">
                        Em andamento de doutorado
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="incluir_orientacao_em_andamento_mestrado" id="incluir_orientacao_em_andamento_mestrado" checked>
                    <label class="form-check-label" for="incluir_orientacao_em_andamento_mestrado">
                        Em andamento de mestrado
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="incluir_orientacao_em_andamento_tcc" id="incluir_orientacao_em_andamento_tcc" checked>
                    <label class="form-check-label" for="incluir_orientacao_em_andamento_tcc">
                        Em andamento de tcc
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="incluir_orientacao_em_andamento_iniciacao_cientifica" id="incluir_orientacao_em_andamento_iniciacao_cientifica" checked>
                    <label class="form-check-label" for="incluir_orientacao_em_andamento_iniciacao_cientifica">
                        Em andamento iniciação científica
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="incluir_orientacao_concluida_pos_doutorado" id="incluir_orientacao_concluida_pos_doutorado" checked>
                    <label class="form-check-label" for="incluir_orientacao_concluida_pos_doutorado">
                        Concluídas de pós doutorado
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="incluir_orientacao_concluida_doutorado" id="incluir_orientacao_concluida_doutorado" checked>
                    <label class="form-check-label" for="incluir_orientacao_concluida_doutorado">
                        Concluídas de doutorado
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="incluir_orientacao_concluida_mestrado" id="incluir_orientacao_concluida_mestrado" checked>
                    <label class="form-check-label" for="incluir_orientacao_concluida_mestrado">
                        Concluídas de mestrado
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="incluir_outras_orientacoes_concluidas" id="incluir_outras_orientacoes_concluidas" checked>
                    <label class="form-check-label" for="incluir_outras_orientacoes_concluidas">
                        Outras orientações concluídas
                    </label>
                </div>
            </div>
            <div class="col-lg-4 col-md-4">
                <h4>Grafo</h4>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="incluir_artigo_em_periodico_g" id="incluir_artigo_em_periodico_g" checked>
                    <label class="form-check-label" for="incluir_artigo_em_periodico_g">
                        Artigo em periódico
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="incluir_livro_publicado_g" id="incluir_livro_publicado_g" checked>
                    <label class="form-check-label" for="incluir_livro_publicado_g">
                        Livro publicado
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="incluir_capitulo_de_livro_publicado_g" id="incluir_capitulo_de_livro_publicado_g" checked>
                    <label class="form-check-label" for="incluir_capitulo_de_livro_publicado_g">
                        Capítulo de livro publicado
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="incluir_texto_em_jornal_de_noticia_g" id="incluir_texto_em_jornal_de_noticia_g" checked>
                    <label class="form-check-label" for="incluir_texto_em_jornal_de_noticia_g">
                        Texto em jornal de notícia
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="incluir_trabalho_em_congresso_g" id="incluir_trabalho_em_congresso_g" checked>
                    <label class="form-check-label" for="incluir_trabalho_em_congresso_g">
                        Trabalho em congresso
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="incluir_artigo_aceito_para_publicacao_g" id="incluir_artigo_aceito_para_publicacao_g" checked>
                    <label class="form-check-label" for="incluir_artigo_aceito_para_publicacao_g">
                        Artigo aceito para publicação
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="incluir_outro_tipo_de_producao_bibliografica_g" id="incluir_outro_tipo_de_producao_bibliografica_g" checked>
                    <label class="form-check-label" for="incluir_outro_tipo_de_producao_bibliografica_g">
                        Outro tipo de produção bibliográfica
                    </label>
                </div>
            </div>
        </div>
    </div>    
    <div class="mb-3 text-center">
        <div class="form-check me-3" style="display: inline-flex !important;}">
            <input class="form-check-input me-1" type="checkbox" name="upgradeable" id="upgradeable">
            <label class="form-check-label" for="upgradeable">Atualizável</label>
        </div>
        <button type="submit" class="btn btn-primary">Analisar</button>
    </div>
</div>
<x-modal id="importacaoModal" title="Importação" size="modal-xl" data-bs-backdrop="static" data-bs-keyboard="false">

</x-modal>