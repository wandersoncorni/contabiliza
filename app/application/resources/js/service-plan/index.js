/**
 * Script principal para pagina de servicos
 * @dependencies services-plan.js (aba planos de serviços), 
 *               plan.js (aba planos), 
 *               services.js (aba serviços), 
 *               categories.js (aba categorias)
 * @Author Wanderson Corni <wandersoncorni@gmail.com>
 * 
 */

import * as servicePlan from './service-plan.js';
import * as plan from './plan.js';
import * as service from './service.js';
import * as category from './category.js';

const serviceListSelected = [];
export let plansData = [];
$(document).ready(function () {
    // Inicializa o DataTable
    loadPlansList();
    // Eventos para o DataTable de planos
    setTablesActions();
    // Iniclializa o modal de criacao e edicao de plano
    servicePlan.init();
    $('#modal-form-plan #nav-tab a').on('click', function () {
        if ($(this).attr('href') === '#nav-plan'){
            plan.init();
        }
        else if ($(this).attr('href') === '#nav-category'){
            category.init();
        }
        else if ($(this).attr('href') === '#nav-service'){
            service.init();
        }
    });
});
/**
 * Carrega a lista de planos
 */
export function loadPlansList() {
    if ($.fn.dataTable.isDataTable('#tb-plans')) {
        $('#tb-plans').DataTable().destroy();
    }
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
}
/**
 * Define os eventos para os botoes da lista de planos da pagina incial
 */
function setTablesActions() {
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
        servicePlan.loadPlanForm(plano, $(this).data('categoria_id'));
    });
}
/**
 * Retorna os botoes de acoes da tabela
 * @param {Int} id 
 * @param {String} url 
 * @returns 
 */
export function getButtons(id, url) {
    return $('<div />').append([
        $('<button />', { class: 'btn btn-xs d-plex me-2 btn-transparent text-info', 'data-id': id, 'data-action': 'edit' }).append(
            $('<i />', { class: 'heroicon heroicon-pencil-square' })
        ),
        $('<button />', { class: 'btn btn-xs d-plex btn-transparent text-danger', 'data-id': id, 'data-action': 'delete' }).append(
            $('<i />', { class: 'heroicon heroicon-trash' })
        )
    ]).prop('innerHTML')
}