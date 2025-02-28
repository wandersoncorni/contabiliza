@push('stylesheet')
<link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" type="text/css">
@endpush
@push('script_src')
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" type="text/javascript"></script>
@endpush
<ul class="nav nav-tabs" id="myTab" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="permanente-tab" data-bs-toggle="tab" data-bs-target="#permanente" type="button" role="tab" aria-controls="permanente" aria-selected="true">Permanentes</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="temporario-tab" data-bs-toggle="tab" data-bs-target="#temporario" type="button" role="tab" aria-controls="temporario" aria-selected="false">Temporários</button>
    </li>
</ul>
<div class="tab-content p-2" style="height: 75vh;">
    <div class="tab-pane active" id="permanente" role="tabpanel" aria-labelledby="permanente-tab">
        <table class="table table-striped table-hover" id="tab-permanente">
            <thead>
                <tr>
                    <th>Análises</th>
                    <th style="width: 1px;">Situação</th>
                    <th style="width: 1px;">Ações</th>
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
    <div class="tab-pane" id="temporario" role="tabpanel" aria-labelledby="temporario-tab">
        <table class="table table-striped table-hover" id="tab-temporaria">
            <thead>
                <tr>
                    <th>Análises</th>
                    <th style="width: 1px;">Situação</th>
                    <th style="width: 1px;">Ações</th>
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