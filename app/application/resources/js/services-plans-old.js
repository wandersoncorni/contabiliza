/**
 * Scripts para gerenciar os planos de serviço
 */
'use strict';
$(document).ready(function () {
    const serviceListSelected = [];
    let plansData = [];
    $('#tb-categories, #tb-services').DataTable({
        columnDefs: [
            { "orderable": false, "targets": [3] } // Desabilita ordenação na coluna de ações
        ],
        order: [[0, "asc"]]
    });
    // Inicializa o DataTable
    $('#tb-plans').DataTable({
        ajax: function (data, callback) {
            fetch('/api/v1/planos-servicos', {
                method: 'GET',
                headers: { 'Content-Type': 'application/json' },
                credentials: 'include'
            }).then(async response => {
                const resp = { data: [] };
                if (response.ok) {
                    const data = await response.json();
                    const list = [];
                    plansData = data;
                    data.forEach(plan => {
                        const pid = list.length;
                        if (!list.find(plano => plano.id == plan.id)) {
                            list.push({ id: plan.id, nome: plan.nome, categorias: [], servicos: [] });
                        }
                        plan.categorias_servicos.forEach(cs => {
                            if (!list[pid].categorias.find(cat => cat.id == cs.categoria.id)) {
                                list[pid].categorias.push({ id: cs.categoria.id, nome: cs.categoria.nome });
                            }
                            if (!list[pid].servicos.find(serv => serv.id == cs.servico.id)) {
                                list[pid].servicos.push({ id: cs.servico.id, nome: cs.servico.nome, categoria_id: cs.categoria.id });
                            }
                        });
                    })
                    resp.data = list;
                }
                callback(resp);
            })
        },
        columns: [
            { "data": "nome" },
            {
                "data": (data) => {
                    const list = $('<ul />', { class: 'list-group' });
                    data.categorias.forEach(cat => {
                        list.append(
                            $('<li />', { class: 'list-group-item' }).html(cat.nome).append([
                                $('<button />', { type: 'button', class: 'btn btn-xs btn-transparent text-info ms-2', 'data-plano_id': data.id, 'data-categoria_id': cat.id }).html(
                                    $('<i />', { class: 'heroicon heroicon-pencil-square' })
                                ),
                                $('<button />', { type: 'button', class: 'btn btn-xs btn-transparent text-danger ms-2', 'data-plano_id': data.id, 'data-categoria_id': cat.id, 'data-action': 'delete_category' }).html(
                                    $('<i />', { class: 'heroicon heroicon-trash' })
                                )
                            ])
                        );
                    });
                    return list.prop('outerHTML');
                }
            },
            {
                "data": (data) => {
                    const list = $('<ul />', { class: 'list-group' });
                    data.servicos.forEach(srv => {
                        list.append(
                            $('<li />', { class: 'list-group-item' }).html(srv.nome).append([
                                $('<button />', { type: 'button', class: 'btn btn-xs btn-transparent text-info ms-2', 'data-plano_id': data.id, 'data-categoria_id': srv.categoria_id, 'data-servico_id': srv.id }).html(
                                    $('<i />', { class: 'heroicon heroicon-pencil-square' })
                                ),
                                $('<button />', { type: 'button', class: 'btn btn-xs btn-transparent text-danger ms-2', 'data-plano_id': data.id, 'data-categoria_id': srv.categoria_id, 'data-servico_id': srv.id, 'data-action': 'delete_service' }).html(
                                    $('<i />', { class: 'heroicon heroicon-trash' })
                                )
                            ])
                        );
                    });
                    return list.prop('outerHTML');
                }
            },
            {
                "data": (data) => {
                    return $('<button />', { type: 'button', class: 'btn btn-xs btn-transparent text-danger', 'data-plano_id': data.id, 'data-action': 'delete_plan' }).html(
                        $('<i />', { class: 'heroicon heroicon-trash' })
                    ).prop('outerHTML');
                }
            }
        ],
        columnDefs: [
            { "orderable": false, "targets": [3] } // Desabilita ordenação na coluna de ações
        ],
        order: [[0, "asc"]]
    });
    // Eventos para o DataTable de planos
    $('#app-content #tb-plans').on('click', 'button', function (e) {
        e.preventDefault();
        let target = 'plano';
        let url = 'api/v1/plano-servico/' + $(this).data('plano_id');
        if ($(this).data('action') == 'delete_category') {
            target = 'categoria';
            url = 'api/v1/categoria-plano/' + $(this).data('plano_id') + '/' + $(this).data('categoria_id')
        } else if ($(this).data('action') == 'delete_service') {
            target = 'serviço';
            url = 'api/v1/servico-plano/' + $(this).data('plano_id') + '/' + $(this).data('categoria_id') + '/' + $(this).data('servico_id');
        }
        if (['delete_plan', 'delete_category', 'delete_service'].includes($(this).data('action'))) {
            Swal.fire({
                title: `Exclusão de ${target}`,
                text: "Voce não poderá reverter isso!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sim, excluir!'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(url, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json',
                        },
                        credentials: 'include'
                    })
                        .then(async response => {
                            const data = await response.json();

                            if (response.ok) {
                                const plansTable = $('#tb-plans').DataTable();
                                plansTable.ajax.reload();
                            } else {
                                Swal.fire(`Erro ao excluir ${target}:`, data.message, 'error');
                            }
                        })
                        .catch(error => console.error(`Erro ao excluir ${target}:`, error));
                }
            })
            return;
        }
        const plano = (plansData.find(plan => plan.id == $(this).data('plano_id')));
        loadPlanForm(plano, $(this).data('categoria_id'));
    });

    $('#app-content #modal-form-plan').on('show.bs.modal', function (e) {
        if ($('#lista-categorias option').length <= 1) {
            fetch('/api/v1/categorias-servicos')
                .then(response => response.json())
                .then(data => {
                    let categorias = '';
                    data.forEach(categoria => {
                        categorias += `<option value="${categoria.id}">${categoria.nome}</option>`;
                    });
                    $('#lista-categorias').append(categorias);
                })
        }
        if (!$('#lista-servicos option').length) {
            fetch('/api/v1/servicos')
                .then(response => response.json())
                .then(data => {
                    let servicos = '';
                    data.forEach(servico => {
                        servicos += `<option class="bg-white" value="${servico.id}">${servico.nome}</option>`;
                    });
                    $('#lista-servicos').html(servicos).prop('size', $('#lista-servicos option').length);
                })
        }
        if ($('#lista-planos option').length <= 1) {
            loadPlansList();
        }
        $('#form-plan')[0].reset();
        optionReset();
    });
    // Eventos para o select de categorias
    $('#lista-servicos').click(function (e) {
        e.target.innerHTML = e.target.innerHTML.replace('✔', '')
        if (serviceListSelected.includes(e.target.value)) {
            serviceListSelected.splice(serviceListSelected.indexOf(e.target.value), 1);
            e.target.classList.remove('bg-black');
            e.target.classList.remove('text-white');
        }
        else {
            serviceListSelected.push(e.target.value);
            e.target.innerHTML = `&#x2714; ${e.target.innerHTML}`;
            e.target.classList.add('bg-black');
            e.target.classList.add('text-white');
        }
        $('#lista-servicos').val(serviceListSelected)
    });
    // Carrega dados da aba
    $('#app-content #nav-tab a').click(function () {
        const navtab = $(this).prop('id');
        if (navtab == 'nav-plan-tab') {
            loadPlanosServicosTable();
        }
    });
    // Salva um plano de servicos
    $('#form-service-plan').submit(function (e) {
        e.preventDefault();
        if($('[name="id"]').val() == 0){            
            salvarPlanoServico();
            return;
        }
        editarPlanoServico(plansData.find(plano => plano.id == $(this).data('id')))
    });
    // Edita um plano de servicos
    $('#app-content').on('click', '#tb-services-plans button', function(){
        carregarFormPlanoServico(plansData.find(plano => plano.id == $(this).data('id')));
    });
});

function getButtons(id, url) {
    return $('<div />').append([
        $('<button />', { class: 'btn btn-xs d-plex me-2 btn-transparent text-info', 'data-id': id }).append(
            $('<i />', { class: 'heroicon heroicon-pencil-square' })
        ),
        $('<button />', { class: 'btn btn-xs d-plex btn-transparent text-danger', 'data-id': id }).append(
            $('<i />', { class: 'heroicon heroicon-trash' })
        )
    ]).prop('innerHTML')
}

function loadPlanForm(plano, categoria_id) {
    let leep = 0;
    $('#modal-form-plan').modal('show');
    const loader = setInterval(() => {
        if ($('#modal-form-plan [name="plano_servico_id"]').length > 0) {
            clearInterval(loader);
            $('#modal-form-plan [name="plano_servico_id"]').val(plano.id);
            $('#modal-form-plan [name="categoria_servico_id"]').val(categoria_id);
            const servicos = [];
            plano.categorias_servicos.forEach(cs => {
                if (cs.categoria.id != categoria_id) return;
                servicos.push(cs.servico.id);
            });

            $('#modal-form-plan [name="servico_id"]').val(servicos);
            setOptionSelected();
        }
    }, 500);
}

function optionReset() {
    $('#form-plan [name="servico_id"] option').each(function () {
        $(this).prop('selected', false);
        $(this).text($(this).text().replace('✔', ''));
        $(this).removeClass('bg-black');
        $(this).removeClass('text-white');
    });
}

function setOptionSelected() {
    $('#form-plan [name="servico_id"] option:selected').each(function () {
        $(this).html('&#x2714;' + $(this).text());
        $(this).addClass('bg-black');
        $(this).addClass('text-white');
    });
}
// Carrega a lista do select para planos de servicos
function loadPlansList() {
    fetch('/api/v1/planos-servicos')
        .then(response => response.json())
        .then(data => {
            let planos = '';
            data.forEach(plano => {
                planos += `<option value="${plano.id}">${plano.nome}</option>`;
            });
            $('#lista-planos').append(planos);
        })
}
// Carrega a tabela de planos de servicos
function loadPlanosServicosTable() {
    if ($.fn.dataTable.isDataTable('#tb-services-plans')) {
        $('#tb-services-plans').DataTable().ajax.reload();
        return;
    }
    $('#tb-services-plans').DataTable({
        ajax: (data, callback) =>
            fetch('/api/v1/planos-servicos')
                .then(async response => {
                    if (!response.ok) {
                        callback({ data: [] });
                        return;
                    }
                    const data = await response.json();
                    let planos = '';
                    data.forEach(plano => {
                        planos += `<tr>
                        <td>${plano.nome}</td>
                        <td>${plano.descricao}</td>
                        <td>${curencyFormat(plano.valor_mensal)}</td>
                        <td>${curencyFormat(plano.valor_anual)}</td>
                        <td>${plano.ativo ? '<span class="text-success">Ativo</span>' : '<span class="text-danger">Inativo</span>'}</td>
                        <td>${getButtons(plano.id, '/plano-servico')}</td>
                    </tr>`;
                    });
                    $('#tb-services-plans tbody').html(planos);
                }),
        columnDefs: [
            { "orderable": false, "targets": [2, 3, 4] } // Desabilita ordenação na coluna de ações
        ],
        order: [[0, "asc"]]
    });
    formatCurrencyValue();
}

function curencyFormat(value) {
    return new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(value);
}
/**
 * Formata o valor do campo currency
 */
function formatCurrencyValue() {
    $('.currency').on('input', function () {
        let valor = $(this).val();
        valor = valor.replace(/\D/g, '');
        valor = (Number(valor) / 100).toFixed(2);
        $(this).val(new Intl.NumberFormat('pt-BR', {
            style: 'currency',
            currency: 'BRL'
        }).format(valor));
    });
}
/**
 * Sanitiza o valor dos campos com a classe "currency"
 * @param {string} field 
 * @returns 
 */
function clearCurrencyValue(field) {
    return ($(`#${field}`).val())
        .replace(/[^\d,]/g, '')
        .replace(/\./g, '')
        .replace(',', '.');
}
/**
 * Salva um plano
 * @param {object} form 
 */
function salvarPlanoServico() {
    const formData = new FormData(document.querySelector('#form-service-plan'));
    formData.set('valor_mensal', clearCurrencyValue('valor_mensal'));
    formData.set('valor_anual', clearCurrencyValue('valor_anual'));

    fetch('/api/v1/plano-servico', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json',
        },
        credentials: 'include',
        body: formData
    })
        .then(async response => {
            const data = await response.json();

            if (response.ok) {
                const plansTable = $('#tb-services-plans').DataTable();
                plansTable.ajax.reload();
                loadPlanosServicosTable();
                loadPlansList();
            } else {
                Swal.fire(`Erro ao salvar o plano:`, data.message, 'error');
            }
        })
        .catch(error => console.error(`Erro ao salvar o plano:`, error));
}
/**
 * Carrega o form com os dados do plano
 * @param {object} data 
 */
function carregarFormPlanoServico(data){
    Object.keys(data).forEach(campo => {
        if(['valor_mensal','valor_anual'].includes(campo)){
            $(`[name="${campo}"]`).val(data[campo]).trigger('input');
            return;
        }
        $(`[name="${campo}"]`).val(data[campo]);
    })
}
/**
 * Exclui um plano
 * @param {object} data 
 */
function editarPlanoServico(data = []){
    const formData = new FormData(document.querySelector('#form-service-plan'));
    const dadosPlano = data.find(el => el.id = formData.get('id'))
    formData.forEach((value, field ) => {console.log(value, $(`[name="${field}"]`).val())
        if(value == $(`[name="${field}"]`).val()){
            formData.delete(field);
        }
    })
    console.log(formData)
    // formData.set('valor_mensal', clearCurrencyValue('valor_mensal'));
    // formData.set('valor_anual', clearCurrencyValue('valor_anual'));


}