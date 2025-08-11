/**
 * Script para gerenciar o plano serviço.
 */
'use strict';

import { currencyFormat, parseCurrencyToFloat, addInvalidFeedback, removeInvalidFeedback } from '../helpers.js';

let plansData = null;

export function init() {
    // carrega a lista de opções de planos de serviço    
    $('#modal-form-company .modal-footer #btn-next').on('click', function () {
        const activeTabId = $('#nav-tabFormCompany .tab-pane.active').next('.tab-pane').prop('id');
        if (activeTabId == 'nav-plano') {
            if (plansData == null) {
                // Carrega os planos do seletor
                loadPlans();
            }
            else if ($('#plano_id').val()) {
                buildPlan($('#plano_id').val());
            }

            $('#btn-save').click(function () {
                savePlan();
            })
        };
    })
    //Monta o plano de serviço
    $(document).on('change', '#plano_id', function () {
        buildPlan($(this).val());
    });
}

async function loadPlan() {
    $('#table-plan tbody tr td.data').html('<div class="skeleton"></div>');
    try {
        const empresa_id = $('#form-company [name="id"]').val();
        if (empresa_id == '') return;
        const request = await fetch(`/api/v1/company-billing/${empresa_id}`);
        const response = await request.json();
        if (response.id) {
            setPlanData(response);
        }
        $('.skeleton').removeClass('skeleton');
    } catch (error) {
        console.error('Erro ao carregar os planos de serviço:', error);
    }
}

function setPlanData(data) {
    $('#plano_id').val(data.plano_id);
}
// Carregar os dados dos planos para lista do select
async function loadPlans() {
    try {
        const areaAtividadeId = $('[name="area_atividade_id"]').val();
        const response = await fetch(`/api/v1/service-plans/${areaAtividadeId}`, {
            method: 'GET',
            headers: {
                'accept': 'application/json'
            }
        });

        if (!response.ok) {
            throw new Error('Erro ao carregar os planos de serviço');
        }

        const data = await response.json();
        const options = ['<option value="">Selecione um plano</option>'];
        data.forEach(plan => {
            plan.valor_plano_servico.forEach(val => {
                options.push(`<option value="${plan.id}.${val.id}">${plan.nome} - ${val.rotulo}</option>`);
            });
        });
        plansData = data;
        $('#plano_id').removeClass('skeleton').html(options.join(''));
        loadPlan();
    } catch (error) {
        console.error('Erro ao carregar os planos de serviço:', error);
    }
}
//Semaforo para carregar as faixas de faturamento
let waitForLoadAdicionalFaixasFaturamento;
const loadAdicionalFaixasFaturamentoResolved = new Promise(resolve => {
    waitForLoadAdicionalFaixasFaturamento = resolve;
});

async function loadAdicionalFaixasFaturamento() {
    try {
        const pid = $('#plano_id').val().split('.')[0];
        const ffid = $('[name="faixa_faturamento_id"]').val();
        const response = await fetch(`/api/v1/faixas-faturamento/${pid}/${ffid}`);
        const data = await response.json();

        $('#table-plan tbody tr:nth-child(4) td:nth-child(2)').text(data.faixa_faturamento.descricao + '**');
        $('#table-plan tbody tr:nth-child(4) td:nth-child(3)').text(currencyFormat(data.valor));
        $('#table-plan tbody tr:nth-child(4) td:nth-child(5)').text(currencyFormat(data.valor));

        const regime = $('#regime_tributario option:checked').text();
        const text = ` Obs: <ul class="list-unstyled">
                    <li>*  Adicional cobrado conforme a faixa de faturamento.</li>
                    <li>** Valor para optantes do regime de tributação "<b>${data.faixa_faturamento.regime_tributario}</b>"</li>
                    </ul>`;
        $('.obs').html(text);

        waitForLoadAdicionalFaixasFaturamento();
    } catch (error) {
        console.error('Erro ao carregar os planos de serviço:', error);
    }
}
/**
 * Soma os valores da tabela
 * Deve aguardar o carregamento das faixas de faturamento
 */
async function sum() {
    await loadAdicionalFaixasFaturamentoResolved;
    let totalBill = 0;
    $('#table-plan tbody tr td:nth-child(5)').each(function () {
        totalBill += parseCurrencyToFloat($(this).text()) || 0;
    });
    $('#table-plan tfoot tr:nth-child(1) td:nth-child(3)').text(currencyFormat(totalBill));
    const parentSkeleton = $('div.skeleton').parent();
    parentSkeleton.text('-');
}

function buildPlan(pval) {
    $('#table-plan tbody tr td.data').html('<div class="skeleton"></div>');

    if (pval == '') return;
    /*
     * pid - id do plano.
     * vid - id do valor do plano.
     */
    const [pid, vid] = (pval).split('.');
    const planData = plansData.find(planoServico => planoServico.id == pid);//Extrai o plano de serviço
    const valData = planData.valor_plano_servico.find(planoServicoValor => planoServicoValor.id == vid);//Extrai o valor do plano de serviço

    $('#table-plan tbody tr:nth-child(1) td:nth-child(3)').text(currencyFormat(valData.valor));
    $('#table-plan tbody tr:nth-child(1) td:nth-child(5)').text(currencyFormat(valData.valor));

    $('#table-plan tbody tr:nth-child(2) td:nth-child(4)').text($('#partners-container [name="pro_labore"][value="1"]:checked').length);

    $('#table-plan tbody tr:nth-child(3) td:nth-child(4)').text($('#total_funcionarios').val());

    planData.plano.forEach((item) => {
        if (item.servico.valor != null) {
            const condition = item.servico.valor.condicoes;
            const serviceVal = item.servico.valor.valor;
            if (item.servico.nome == 'Pró-labore dos sócios') {
                const totalPartner = $('#partners-container .accordion [name="pro_labore"][value="1"]:checked').length;
                let totalProLabore = 0;
                if (condition[0] == 'gt' && totalPartner > condition[1]) {
                    totalProLabore = parseInt((totalPartner - condition[1]) * serviceVal);
                }
                $('#table-plan tbody tr:nth-child(2) td:nth-child(2)').text(item.observacao);
                $('#table-plan tbody tr:nth-child(2) td:nth-child(3)').text(currencyFormat(serviceVal));
                $('#table-plan tbody tr:nth-child(2) td:nth-child(4)').text(totalPartner);
                $('#table-plan tbody tr:nth-child(2) td:nth-child(5)').text(currencyFormat(totalProLabore));
            }
            else if (item.servico.nome == 'Folha de pagamento') {
                const totalFunc = $('#total_funcionarios').val();
                let totalFolha = 0;
                if (condition[0] == 'gt' && totalFunc > condition[1]) {
                    totalFolha = parseInt((totalFunc - condition[1]) * serviceVal);
                }
                $('#table-plan tbody tr:nth-child(3) td:nth-child(2)').text(item.observacao);
                $('#table-plan tbody tr:nth-child(3) td:nth-child(3)').text(currencyFormat(serviceVal));
                $('#table-plan tbody tr:nth-child(3) td:nth-child(4)').text(totalFunc);
                $('#table-plan tbody tr:nth-child(3) td:nth-child(5)').text(currencyFormat(totalFolha));
            }
            else if (item.servico.nome == 'Faixa de faturamento') {
                loadAdicionalFaixasFaturamento();
            }
        }
    });
    //Soma os valores da tabela
    sum();
}

function savePlan() {
    removeInvalidFeedback('#form-plan');
    const id = $('#form-plan [name="id"]').val();//Id do plano salvo
    const pid = $('#form-plan [name="plano_id"]').val();//Id do plano de serviço + id do valor
    const eid = $('#form-company [name="id"]').val();//Id da empresa

    if (pid == '') {
        addInvalidFeedback($('#form-plan [name="plano_id"]'));
        return;
    }
    if (eid == '') {
        Swal.fire({
            icon: 'error',
            title: 'Erro ao salvar o plano de serviço',
            text: 'Recarregue os dados da empresa novamente.',
        });
        return;
    }

    const formData = new FormData();
    formData.append('plano_id', pid);
    formData.append('empresa_id', eid);
    formData.append('id', id);
    if (id != '') formData.append('_method', 'PUT');
    const request = new Request('/api/v1/company/billing', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            'Accept': 'application/json',
        },
        body: formData
    });
    const response = fetch(request);
    response.then(async (response) => {
        const data = await response.json();
        if (data.ok) {
            $('#form-plan div:first').append(
                $('<div />', { class: 'alert alert-success' }).append(
                    $('<i />', { class: 'heroicon heroicon-check-circle me-2' }),
                    'Plano de serviço salvo com sucesso.'
                )
            )
            return;
        }
    });
}

function fillTablePlan() {
    $('#table-plan tbody tr td.data').html('<div class="skeleton"></div>');
    $('#table-plan tbody tr td.data').html('<div class="skeleton"></div>');
    $('#table-plan tbody tr td.data').html('<div class="skeleton"></div>');
    $('#table-plan tbody tr td.data').html('<div class="skeleton"></div>');
    $('#table-plan tbody tr td.data').html('<div class="skeleton"></div>');
}