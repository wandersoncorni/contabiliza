/**
 * Script para gerenciar o plano serviço.
 */
'use strict';

import { currencyFormat, parseCurrencyToFloat, addInvalidFeedback, removeInvalidFeedback } from '../helpers.js';

let plansData = null;
// Dados do plano de serviço. Dados de pagamento é dependente
export let planData = null;

export function init() {
    //Monta o plano de serviço
    $('#plano_id').on('change', function () {
        buildPlan($(this).val());
    });
}
//Carrega os dados do plano de serviço, se existir
async function loadPlan() {
    $('#table-plan tbody tr td.data').html('<div class="skeleton"></div>');
    try {
        const empresa_id = $('#form-company [name="id"]').val();
        if (empresa_id == '') return;
        const request = await fetch(`/api/v1/company/billing/${empresa_id}`);
        const response = await request.json(); 
         
        if (response.id) {
            setPlanData(response);
            planData = response;
        }
        else{
            setPlanData({
                plano: {
                    valor: '',
                    pro_labore_obs: '',
                    valor_unitario_pro_labore: '',
                    total_socios: '',
                    valor_unitario_prolabore: '',
                    total_valor_prolabore: '',
                    folha_pagamento_obs: '',
                    valor_unitario_folha_pagamento: '',
                    total_folha_pagamento: '',
                    valor_folha_pagamento: '',
                    faixa_faturamento_obs: '',
                    valor_faixa_faturamento: ''
                }
            });
        }
        $('.skeleton').removeClass('skeleton');
    } catch (error) {
        console.error('Erro ao carregar os planos de serviço:', error);
    }
}
//Carrega os dados do plano de serviço na tabela
export function setPlanData(data) {
    $('#form-plan [name="id"]').val(data.id ?? '');
    $('#plano_id').val(`${data.plano.id}.${data.plano.valor_plano_servico_id}`);//Id do plano de serviço + id do valor do plano de serviço
    //Plano
    $('#table-plan tbody tr:nth-child(1) td:nth-child(3)').text(currencyFormat(data.plano.valor));
    $('#table-plan tbody tr:nth-child(1) td:nth-child(4)').text('-');
    $('#table-plan tbody tr:nth-child(1) td:nth-child(5)').text(currencyFormat(data.plano.valor));
    //Prolabore
    $('#table-plan tbody tr:nth-child(2) td:nth-child(2)').text(data.plano.pro_labore_obs);
    $('#table-plan tbody tr:nth-child(2) td:nth-child(3)').text(currencyFormat(data.plano.valor_unitario_pro_labore));
    $('#table-plan tbody tr:nth-child(2) td:nth-child(4)').text(data.plano.total_socios);
    $('#table-plan tbody tr:nth-child(2) td:nth-child(5)').text(currencyFormat(data.plano.total_valor_prolabore));
    //Folha de pagamento
    $('#table-plan tbody tr:nth-child(3) td:nth-child(2)').text(data.plano.folha_pagamento_obs);
    $('#table-plan tbody tr:nth-child(3) td:nth-child(3)').text(currencyFormat(data.plano.valor_unitario_folha_pagamento));
    $('#table-plan tbody tr:nth-child(3) td:nth-child(4)').text(data.plano.total_folha_pagamento);
    $('#table-plan tbody tr:nth-child(3) td:nth-child(5)').text(currencyFormat(data.plano.valor_folha_pagamento));
    //Faixa de faturamento
    $('#table-plan tbody tr:nth-child(4) td:nth-child(2)').text(data.plano.faixa_faturamento_obs);
    $('#table-plan tbody tr:nth-child(4) td:nth-child(3)').text(currencyFormat(data.plano.valor_faixa_faturamento));
    $('#table-plan tbody tr:nth-child(4) td:nth-child(4)').text('-');
    $('#table-plan tbody tr:nth-child(4) td:nth-child(5)').text(currencyFormat(data.plano.valor_faixa_faturamento));

    let planoAlterado = false;
    if(data.id){
        if($('#partners-container form').length != data.plano.total_socios){
            planoAlterado = true;
        }
        if($('#total_funcionarios').val() != data.plano.total_folha_pagamento){
            planoAlterado = true;
            $('#table-plan tbody tr:nth-child(3) td:nth-child(4)').html(`<span class="text-danger">${$('#total_funcionarios').val()}</span>`);
        }

        if(planoAlterado){
            sum();
            Swal.fire({
                icon: 'warning',
                title: 'Atenção',
                text: 'O plano de serviço foi alterado, salve as alterações.',
            });
        }
    }
    
    sum();
}
// Carregar os dados dos planos para lista do select
export async function loadPlans() {
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
                    <li>** Valor para optantes do regime de tributação "<b>${data.faixa_faturamento.regime_tributario.descricao}</b>"</li>
                    </ul>`;
        $('.obs').html(text);
        sum();
    } catch (error) {
        console.error('Erro ao carregar os planos de serviço:', error);
    }
}
/**
 * Soma os valores da tabela
 * Deve aguardar o carregamento das faixas de faturamento
 */
function sum() {
    if (!plansData) return;
    // Calcula o valor da coluna preço vezes quantidade e seta o valor na coluna total
    const plano = plansData.find(planoServico => planoServico.id == $('#plano_id').val().split('.')[0]).plano;
    const valoresServicos = plano.filter(item => item.servico.valor != null);

    if(valoresServicos.length == 0){
        const valorProLabore = valoresServicos.find(item => item.servico.nome == 'Pró-labore dos sócios')?.servico.valor.valor ?? 0;
        const valorFolhaPagamento = valoresServicos.find(item => item.servico.nome == 'Folha de pagamento')?.servico.valor.valor ?? 0;
        const totalProLabore = parseInt($('#table-plan tbody tr:nth-child(2) td:nth-child(4)').text()) * valorProLabore;
        const totalFolhaPagamento = parseInt($('#table-plan tbody tr:nth-child(3) td:nth-child(4)').text()) * valorFolhaPagamento;
        $('#table-plan tbody tr:nth-child(2) td:nth-child(3)').text(currencyFormat(valorProLabore));
        $('#table-plan tbody tr:nth-child(2) td:nth-child(5)').text(currencyFormat(totalProLabore));
        $('#table-plan tbody tr:nth-child(3) td:nth-child(3)').text(currencyFormat(valorFolhaPagamento));
        $('#table-plan tbody tr:nth-child(3) td:nth-child(5)').text(currencyFormat(totalFolhaPagamento));
    }

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

    if (!pval) return;
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
}

export function savePlan() {
    removeInvalidFeedback('#form-plan');
    const id = $('#form-plan [name="id"]').val();//Id do plano salvo
    const pid = $('#form-plan [name="plano_id"]').val();//Id do plano de serviço + id do valor
    const eid = $('#form-company [name="id"]').val();//Id da empresa
    // Verfica se o plano de serviço foi selecionado
    if (pid == '') {
        addInvalidFeedback($('#form-plan [name="plano_id"]'));
        return;
    }
    // Verfica se a empresa foi selecionada
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
    const request = new Request('/api/v1/company-billing', {
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
        if (response.ok) {
            Swal.fire({
                icon: 'success',
                title: 'Sucesso',
                text: 'Plano de serviço salvo com sucesso.'
            });
            planData = data;
            setPlanData(data);
            return ;
        }
        Swal.fire({
            icon: 'error',
            title: 'Erro ao salvar o plano de serviço',
            text: data.plano_id[0] ?? '',
        });
    });
}

export function checkPlanForm(){
    if(!$('#form-plan [name="plano_id"]').val()){
        Swal.fire({
            icon: 'error',
            title: 'Erro ao salvar o plano de serviço',
            text: 'Selecione um plano de serviço e salve a escolha.',
        })
        return false;
    }
    // Se a variavel planData for nula, significa que o plano nao foi salvo
    if(planData == null || $('#form-plan [name="id"]').val() == ''){
        Swal.fire({
            icon: 'error',
            title: 'Erro ao salvar o plano de serviço',
            text: 'Salve os dados do plano escolhido.',
        })
        return false;
    }
    // Verifica se o form foi alterado
    if(hasChanged()){
        Swal.fire({
            icon: 'warning',
            title: 'Atenção',
            text: 'O plano de serviço foi alterado, salve as alterações.',
        })
        return false;
    };
    return true;
}

export function hasChanged(){
    if(`${planData.plano.id}.${planData.plano.valor_plano_servico_id}` != $('#form-plan [name="plano_id"]').val()){
        return true;
    }
    return false;
}