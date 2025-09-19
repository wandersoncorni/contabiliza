/**
 * Scripts para pagina de empresas
 */
'use strict';
import { 
    init as companyFormInit, 
    saveCompany, 
    setCompanyData, 
    checkCompanyForm, 
    hasChanged as companyHasChanged, 
    listarRegimesTributarios, 
    listarCNAEs, 
    listarFaixasFaturamento,
    listarAreasAtividade,
    listarNaturezasJuridicas } from './company_form.js';
import { init as partnerInit, savePartner, checkPartnersForm, listPartners, hasChanged as partnerHasChanged } from './partner.js';
import { init as planInit, savePlan, loadPlans, checkPlanForm, hasChanged as planHasChanged } from './plan.js';
import { savePayment, loadPayment, hasChanged as paymentHasChanged } from './payment.js';
import * as stepWizard from './step-wizard.js';
import { currencyFormat } from '../helpers.js';

export let companiesList = [];

$(function () {
    // Carrega as tabelas
    loadCompaniesTable();
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
    // Avança os passos
    $('#btn-next').on('click', function () {
        const activeTabId = $('#nav-tabFormCompany .tab-pane.active').prop('id');
        if (activeTabId == 'nav-company') {
            if (!checkCompanyForm()) return;
            listPartners();
        }
        else if (activeTabId == 'nav-partners') {
            if (!checkPartnersForm()) return;
            loadPlans();
        }
        else if (activeTabId == 'nav-plano') {
            if (!checkPlanForm()) return;
            loadPayment();
        }
        stepWizard.next();
    });
    // Volta os passos
    $('#btn-prev').on('click', function () {
        stepWizard.prev();
    });
    // Preenche o form para edição
    $(document).on('click', '#tb-companies tbody tr td:last-child div button', function () {
        const action = $(this).data('action');
        if (action == 'edit') {
            $('#modal-form-company').modal('show');
            const companyData = companiesList.find(c => c.id == $(this).data('idCompany'));
            setCompanyData(companyData)
            return;
        }
        if (action == 'delete') {
            Swal.fire({
                title: 'Deseja realmente excluir essa empresa?',
                text: "Essa empresa e todos os seus dados serao excluídos permanentemente!",
                icon: 'warning',
                showDenyButton: true,
                confirmButtonText: 'Sim',
                denyButtonText: 'Não'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/api/v1/company/${$(this).data('idCompany')}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            'Accept': 'application/json',
                        }
                    }).then(async response => {
                        const data = await response.json();
                        if (response.ok) {
                            loadCompaniesTable();
                            Swal.fire({
                                icon: 'success',
                                title: 'Empresa excluida com sucesso',
                            });
                            return;
                        }
                        Swal.fire({
                            icon: 'error',
                            title: 'Erro ao excluir empresa',
                            text: data.error ?? 'Erro desconhecido',
                        });
                    });
                }
            });
        }
    });
    // Salva os dados dos forms do wizard
    $('#btn-save').on('click', function () {
        const activeNav = $('#nav-tabFormCompany .tab-pane.active').attr('id');
        if (activeNav == 'nav-company') {
            saveCompany();
        }
        if (activeNav == 'nav-partners') {
            savePartner();
            return;
        }
        if (activeNav == 'nav-plano') {
            savePlan();
            return;
        }
        if (activeNav == 'nav-cobranca') {
            savePayment();
            return;
        }
    });
    // Ações do botal fechar do modal
    $('#btn-close').on('click', function () {
        const close = () => {
            $('#modal-form-company').modal('hide');
            resetForms();
        }

        const modalAlert = (msg) => {
            Swal.fire({
                icon: 'warning',
                title: 'Atenção',
                text: msg,
                showDenyButton: true,
                confirmButtonText: 'Sim',
                denyButtonText: 'Não'
            }).then((result) => {
                if (result.isConfirmed) close();
            })
        }

        const activeNav = $('#nav-tabFormCompany .tab-pane.active').attr('id');
        const msg = (form = 'de um ou mais formulários') => `Os dados ${form} foram alterados, se fechar fechar perderá as alterações. Deseja prosseguir?`
        if (activeNav == 'nav-company' && companyHasChanged()) {
            modalAlert(msg('da empresa'));
            return;
        }
        if (activeNav == 'nav-partners' && partnerHasChanged()) {
            modalAlert(msg('de um ou mais sócios'));
            return;
        }
        if (activeNav == 'nav-plano' && planHasChanged()) {
            modalAlert(msg('do plano'));
            return;
        }
        if (activeNav == 'nav-cobranca' && paymentHasChanged()) {
            modalAlert(msg('da cobrança'));
            return;
        }
        close();
    });

    $(document).on('click', '.company-info', function () {
        $('#modalCompanyInfo').modal('show');
        const companyData = companiesList.find(c => c.id == $(this).data('id'));
        setInfoCompany(companyData);
    });
});
// Insere os dados no modal de infomações da empresa
function setInfoCompany(data) {
    Object.keys(data).map((key) => {
        let val = data[key];
        if (key == 'regime_tributario_id') {
            (() => {
                listarRegimesTributarios().then(() => {
                    $(`#modalCompanyInfo #regime_tributario`).html(
                        $(`#modal-form-company #regime_tributario option[value="${val}"]`).text()
                    );
                });
            })();
            return
        }
        else if(key == 'regime_bens') {
            (()=>{
                listarCNAEs().then(() => {
                    $(`#modalCompanyInfo #cnae`).append(
                        () => {
                            const list = $('<ul />',{class:'list-group list-group-flush'});
                            val.map( id => {
                                list.append($('<li />', {class:'list-group-item', text: $(`#modal-form-company #cnae option[value="${id}"]`).text()}));
                            });
                            return list;
                        }
                       
                    );
                })
            })();
        }
        else if (key == 'area_atividade_id') {
            (() => {
                listarAreasAtividade().then(() => {
                    $(`#modalCompanyInfo #area_atividade`).html(
                        $(`#modal-form-company #area_atividade option[value="${val}"]`).text()
                    );
                });
            })();
        }
        else if (key == 'faixa_faturamento_id') {
            (() => {
                listarFaixasFaturamento().then(() => {
                    $(`#modalCompanyInfo #faixa_faturamento`).html(
                        $(`#modal-form-company #faixa_faturamento option[value="${val}"]`).text()
                    );
                });
            })();
            return
        }
        else if (key == 'natureza_juridica_id') {
            (() => {
                listarNaturezasJuridicas().then(() => {
                    $(`#modalCompanyInfo #natureza_juridica`).html(
                        $(`#modal-form-company #natureza_juridica option[value="${val}"]`).text()
                    );
                });
            })();
        }
        else if(key == 'capital_social') val = currencyFormat(val);
        
        $(`#modalCompanyInfo #${key}`).html(val ?? '&nbsp;');
    });
}
// Carrega a lista de empresas do cliente
export function loadCompaniesTable() {
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
                companiesList = await response.json();
                return callback({ data: companiesList });
            });
        },
        searching: false,
        order: [],
        columns: [
            { data: 'cnpj' },
            {
                data: (data) => {
                    return $(`<a />`, { href: "#", class: 'text-info fw-bolder d-flex align-middle company-info', 'data-id': data.id, title: 'Informações da empresa' }).append([
                        $(`<span />`, { class: 'link', text: data.nome_fantasia }),
                        $(`<i />`, { class: 'heroicon heroicon-information-circle ms-2' }),
                    ]).prop('outerHTML');
                }
            },
            {
                data: (data) => {
                    let types = ['danger', 'success', 'warning', 'primary', 'info'];
                    let labels = ['Rejeitado', 'Aprovado', 'Pendente', 'Cancelado', 'Elaboração'];

                    return $('<span />', { class: `badge badge-08 bg-${types[data.status]}` }).append(labels[data.status]).prop('outerHTML');
                }
            },
            {
                data: (data) => {
                    let types = ['danger', 'success', 'warning', 'primary', 'info'];
                    let labels = ['Nula', 'Ativa', 'Suspensa', 'Baixada', 'Em processo de inscrição'];

                    return $('<span />', { class: `badge badge-08 bg-${types[data.status]}` }).append(labels[data.situacao]).prop('outerHTML');
                }
            },
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
            { targets: [1], orderable: true },
            { targets: [2], orderable: false },
            { targets: [0], type: 'string', orderable: false }
        ]
    });
}

function resetForms() {
    $('.is-invalid').removeClass('is-invalid');
    $('.invalid-feedback').remove();
    $('.step-wizard-list li').removeClass('current-item').eq(0).addClass('current-item');
    $('#nav-tabFormCompany .tab-pane').removeClass('active show').eq(0).addClass('active show');
    $('#nav-tabFormCompany form').trigger('reset');
    $('#partners-container form').remove();
    $('#btn-prev').prop('disabled', true);
    $('#btn-next').prop('disabled', false);
}