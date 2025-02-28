@push('stylesheet')
<link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" type="text/css">
@endpush
@push('script_src')
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" type="text/javascript"></script>
@endpush
<div class="row config">
    <div class="col-lg-2 col-sm-3 me-0 pe-0">
        <div class="nav flex-column nav-tabs h-100 border-0" id="vert-tabs-tab" role="tablist" aria-orientation="vertical">
            <a class="nav-link active" id="aplicacao-tab" data-bs-toggle="pill" href="#aplicacao" role="tab" aria-controls="aplicacao" aria-selected="false">Aplicação</a>
            <a class="nav-link" id="config-analises-tab" data-bs-toggle="pill" href="#config-analises" role="tab" aria-controls="config-analises" aria-selected="false">Análises</a>
            <a class="nav-link" id="usuarios-tab" data-bs-toggle="pill" href="#usuarios" role="tab" aria-controls="usuarios" aria-selected="true">Usuários</a>
            <a class="nav-link" id="config-logs-tab" data-bs-toggle="pill" href="#config-logs" role="tab" aria-controls="config-logs" aria-selected="false">Logs do sistema</a>
        </div>
    </div>
    <div class="col-lg-10 col-sm-9 bg-white border">
        <div class="tab-content p-1" id="vert-tabs-tabContent">
            <div class="tab-pane text-left p-2 fade show active" id="aplicacao" role="tabpanel" aria-labelledby="aplicacao-tab">
                <form method="POST" action="#">
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" name="qualis" id="qualis">
                        <label class="form-check-label" for="qualis">Habilitar o módulo qualis</label>
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" name="qualis_points" id="qualis_points">
                        <label class="form-check-label" for="qualis_points">Mostrar pontuação qualis</label>
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" name="external_search" id="external_search">
                        <label class="form-check-label" for="external_search">Buscar nomes na API externa</label>
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" name="cnpq_service" id="cnpq_service">
                        <label class="form-check-label" for="cnpq_service">Coletar curriculos via o serviço do Cnpq(extrator lattes)</label>
                    </div>
                    <div class="form-check mb-3">
                        <label class="form-check-label" for="service_collector">Coletar curriculos via o serviço da Fiocruz (Blf)</label>
                        <select class="form-select" name="service_collector" id="service_collector" style="width: 250px;">
                            <option value="cnpq" label="Extrator Lattes" selected=""></option>
                            <option value="blf" label="Blf Fiocruz"></option>
                            <option value="elattes" label="Api e-lattes"></option>														
                        </select>
                    </div>
                </form>
            </div>
            <div class="tab-pane fade" id="config-analises" role="tabpanel" aria-labelledby="config-analises-tab">
                Mauris tincidunt mi at erat gravida, eget tristique urna bibendum. Mauris pharetra purus ut ligula tempor, et vulputate metus facilisis. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Maecenas sollicitudin, nisi a luctus interdum, nisl ligula placerat mi, quis posuere purus ligula eu lectus. Donec nunc tellus, elementum sit amet ultricies at, posuere nec nunc. Nunc euismod pellentesque diam.
            </div>
            <div class="tab-pane fade" id="usuarios" role="tabpanel" aria-labelledby="usuarios-tab">
              <table class="table table-striped table-hover" id="users-table">
                <thead>
                    <tr>
                        <th>Usuários</th>
                        <th style="width: 1px;">Ações</th>
                    </tr>
                </thead>
                <tbody>
                @for($i = 0; $i < 10; $i++)
                        <tr>
                            @for($a = 0; $a < 2; $a++)
                                <td class="placeholder-glow">
                                    <span class="placeholder bg-secondary col-12"></span>
                                </td>
                            @endfor
                        </tr>
                    @endfor
                </tbody>
              </table>
            </div>
            <div class="tab-pane fade" id="config-logs" role="tabpanel" aria-labelledby="config-logs-tab">
              <table class="table table-striped table-hover" id="logs-table">
                <thead>
                  <tr>
                      <th>Usuário/Ação</th>
                      <th style="width: 1px;">Origem</th>
                      <th style="width: 1px;">Data/Hora</th>
                  </tr>
                </thead>
                <tbody>
                @for($i = 0; $i < 10; $i++)
                        <tr>
                            @for($a = 0; $a < 3; $a++)
                                <td class="placeholder-glow">
                                    <span class="placeholder bg-secondary col-12"></span>
                                </td>
                            @endfor
                        </tr>
                    @endfor
                </tbody>
              </table>            
            </div>
        </div>
    </div>
</div>
<x-modal id="exclusaoModal" title="Confirmação de exclusão">
    <h5 class="text-danger">
        <x-icon type="exclamation-triangle-fill me-2" />
        Confirme a exclusão do usuário.
    </h5>
    @push('modal-footer-exclusaoModal')
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Fechar</button>
        <button type="button" class="btn btn-danger"  data-bs-dismiss="modal" id="btn-delete">Excluir</button>
    @endpush
    <input type="hidden" value="" id="uid"/>
</x-modal>
