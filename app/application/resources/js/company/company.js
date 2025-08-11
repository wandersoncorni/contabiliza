/**
 * Scripts para pagina de empresas
 */
'use strict';
import { init as companyFormInit, saveCompany } from './company_form.js';
import { init as partnerInit, savePartner } from './partner.js';
import { init as planInit } from './plan.js';
import * as stepWizard from './step-wizard.js';
import { currencyFormat } from '../helpers.js';

export let newCompaniesList = [];

$(document).ready(function () {
    // Carrega as tabelas
    loadCompaniesTable();
    loadNewCompaniesTable();

    companyFormInit();
    partnerInit();
    planInit();

    //Inicializa os modulos e eventos
    let live = null;
    $('#modal-form-company').on('show.bs.modal', function () {
        live = setInterval(function () {
            fetch('api/v1/live');
        }, 640000);

        resetForms();
    }).on('hide.bs.modal', function () {
        clearInterval(live);
    });

    $(document).on('click', '#btn-next', function () {
        stepWizard.next();
    });

    $(document).on('click', '#btn-prev', function () {
        stepWizard.prev();
    });
    // Preenche o form para edição
    $(document).on('click', '#tb-new-companies tbody tr td:last-child div button', function () {
        if ($(this).data('action') == 'edit') {
            $('#modal-form-company').modal('show');
            const companyData = newCompaniesList.find(c => c.id == $(this).data('idCompany'));
            Object.keys(companyData).forEach(campo => {
                const field = $(`#form-company [name="${campo}"]`);
                if (field.is('select')) {
                    (async () => await setSelectValue(campo, companyData[campo]))();
                    return;
                }

                if (campo == 'capital_social') {
                    field.val(currencyFormat(companyData[campo]));
                    return;
                }

                field.val(companyData[campo]);
                field.removeAttr('data-changed');
            });
            return;
        }
    });

    $('#btn-save').click(function () {
        const activeNav = $('#nav-tabFormCompany .tab-pane.active').attr('id');
        if (activeNav == 'nav-company') {
            saveCompany();
        }
        if (activeNav == 'nav-partners') {
            savePartner();
            return;
        }
    });
});
// Carrega a lista de empresas do cliente
function loadCompaniesTable() {
    if ($('.dataTable').length) $('#tb-companies').DataTable().destroy();
    //return new DataTable('#tb-companies', {
    $('#tb-companies').DataTable({
        ajax: function (data, callback) {
            fetch('/api/v1/companies', {
                method: 'GET',
                credentials: 'include'
            }).then(async response => {
                if (!response.ok) {
                    callback({ data: [] });
                    return;
                }
                const data = await response.json();
                return callback({ data: data });
            });
        },
        searching: false,
        order: [],
        columns: [
            { data: 'cnpj' },
            { data: 'nome' },
            { data: () => { return '<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-form-company">Criar</button>' } }
        ],
        columnDefs: [
            { targets: [1], orderable: true },
            { targets: [2], orderable: false },
            { targets: [0], type: 'string', orderable: false }
        ]
    });
}
// Carrega a lista de solicitações de criação de empresas
export function loadNewCompaniesTable() {
    $('#tb-new-companies').DataTable().destroy();
    $('#tb-new-companies').DataTable({
        ajax: function (data, callback) {
            fetch('/api/v1/companies/requests', {
                method: 'GET',
            }).then(async response => {
                if (!response.ok) {
                    callback({ data: [] });
                    return;
                }
                const data = await response.json();
                newCompaniesList = data;
                return callback({ data: data });
            });
        },
        columns: [
            { data: 'nome_fantasia' },
            { data: 'status_label' },
            { data: 'situacao_label' },
            {
                data: (data) => {
                    return $('<div />').append([
                        $('<button />', { type: 'button', class: 'btn btn-xs btn-warning d-inline-flex align-items-center me-4', 'data-id-company': data.id, 'data-action': 'edit' }).append(
                            $('<i/>', { class: 'heroicon heroicon-pencil' })
                        ),
                        $('<button />', { type: 'button', class: 'btn btn-xs btn-danger d-inline-flex align-items-center', 'data-id-company': data.id, 'data-action': 'delete' }).append(
                            $('<i/>', { class: 'heroicon heroicon-trash' })
                        )
                    ]).prop('outerHTML');
                }
            }
        ],
        columnDefs: [
            { targets: [0, 1], orderable: true, searchable: true },
            { targets: [2], orderable: false, searchable: false },
        ]
    });
}
//Insere os dados no select
const interals = [];
async function setSelectValue(select, value) {
    return new Promise((resolve) => {
        const start = Date.now();
        const interval = setInterval(() => {
            if ($(`[name="${select}"] option`).length) {
                clearInterval(interval);
                $(`[name="${select}"]`).val(value).trigger('change').removeAttr('data-changed');
                resolve(true);
            }
            if (Date.now() - start > 30000) {
                clearInterval(interval);
            }
        }, 500);
    });
}

function resetForms() {
    $('.is-invalid').removeClass('is-invalid');
    $('.invalid-feedback').remove();
    $('.step-wizard-list li').removeClass('current-item').eq(0).addClass('current-item');
    $('#nav-tabFormCompany .tab-pane').removeClass('active show').eq(0).addClass('active show');
}
