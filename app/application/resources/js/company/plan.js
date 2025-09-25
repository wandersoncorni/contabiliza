/**
 * Script para gerenciar o plano serviço.
 */
'use strict';

import { currencyFormat, parseCurrencyToFloat, addInvalidFeedback, removeInvalidFeedback } from '../helpers.js';

let plansData = [];
// Dados do plano de serviço. Dados de pagamento é dependente
export let planData = null;

export function init(){
    $('#btn-next').on('click', function () {
        if ($('#nav-tabFormCompany .tab-pane.active').prop('id') == 'nav-partners' && planData) setPlanData(planData);
    });

    $('[name="plano_id"]').on('change', function () {
        setPlanData({
            id: $('#form-plan [name="id"]').val(),
            plano: { id: $(this).val() }
        });
    });
}

//Carrega os dados do plano de serviço, se existir
async function loadPlan() {
    setPlanData();
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
/**
 * Carrega os dados do plano de serviço na tabela
 * @param {object} data - Dados do plano de serviço que foi salvo, se existir
 */
export function setPlanData(data = {}) {
    const planoContratadoId = data.id ?? $('#form-plan [name="id"]').val();// Define o id do plano salvo se existir
    const planoId = data?.plano?.id ?? $('#form-plan [name="plano_id"]').val();//Id do plano de serviço + id do valor
    $('#plano_id').val(planoId);
    if(!planoId) return;
    const plano = plansData.find(p => p.id == planoId);
    const valorPlano = plano?.plano_servico_faixas_faturamento.find(d => d.faixa_faturamento_id == $('#form-company [name="faixa_faturamento_id"]').val() && d.regime_tributario_id == $('#form-company [name="regime_tributario_id"]').val()).valor;
  
    // Prolabore
    const prolabore = plano?.servicos.find(s => s.servico.nome == 'Pró-labore dos sócios');
    const proLaboreObs = prolabore?.observacao;
    const valorPlanoProLabore = prolabore?.valor;
    const totalSocios = $('#partners-container [name="pro_labore"][value="1"]:checked').length;
    const valorTotalProLabore = (()=>{
        const condicaoValor = prolabore.condicoes ?? [];
        if(condicaoValor[0] == 'gt' && totalSocios > condicaoValor[1]) {
            return (totalSocios - condicaoValor[1]) * valorPlanoProLabore;
        } 
        return 0;
    })();
    // Folha de pagamento
    const folhaPagamento =  plano?.servicos.find(s => s.servico.nome == 'Folha de pagamento');
    const obsFolhaPagamento = folhaPagamento?.observacao;
    const valorPlanoFolhaPagamento = folhaPagamento?.valor;
    const totalFolhaPagamento = $('#total_funcionarios').val();
    const valorTotalFolhaPagamento = (()=>{
        const condicaoValor = folhaPagamento.condicoes ?? [];
        if(condicaoValor[0] == 'gt' && totalFolhaPagamento > condicaoValor[1]) {
            return (totalFolhaPagamento - condicaoValor[1]) * valorPlanoFolhaPagamento;
        }
        return 0;
    })();

    const info = `Base do valor do plano de assinatura:
    <ul>
        <li> Faixa de faturamento: <b>${($('#form-company [name="faixa_faturamento_id"] option:selected').text())}</b></li>
        <li> Regime tributário: <b>${$('#form-company [name="regime_tributario_id"] option:selected').text()}</b></li>
    </ul>`;
    
    $('#form-plan [name="id"]').val(planoContratadoId);
    $('#plano_id').val(planoId);//Id do plano de serviço + id do valor do plano de serviço
    //Plano
    $('#table-plan tbody tr:nth-child(1) td:nth-child(3)').text(currencyFormat(valorPlano));
    $('#table-plan tbody tr:nth-child(1) td:nth-child(4)').text('-');
    $('#table-plan tbody tr:nth-child(1) td:nth-child(5)').text(currencyFormat(valorPlano));
    //Prolabore
    $('#table-plan tbody tr:nth-child(2) td:nth-child(2)').text(proLaboreObs);
    $('#table-plan tbody tr:nth-child(2) td:nth-child(3)').text(currencyFormat(valorPlanoProLabore));
    $('#table-plan tbody tr:nth-child(2) td:nth-child(4)').text(totalSocios);
    $('#table-plan tbody tr:nth-child(2) td:nth-child(5)').text(currencyFormat(valorTotalProLabore));
    //Folha de pagamento
    $('#table-plan tbody tr:nth-child(3) td:nth-child(2)').text(obsFolhaPagamento);
    $('#table-plan tbody tr:nth-child(3) td:nth-child(3)').text(currencyFormat(valorPlanoFolhaPagamento));
    $('#table-plan tbody tr:nth-child(3) td:nth-child(4)').text(totalFolhaPagamento);
    $('#table-plan tbody tr:nth-child(3) td:nth-child(5)').text(currencyFormat(valorTotalFolhaPagamento));

    $('#plan-obs').html(
        $('<div />',{class: 'alert alert-info'}).html(info)
    );
    //Soma os valores   
    sum();
}
/**
 * Carregar os dados dos planos para lista do select 
 */
export async function loadPlans() {
    if(plansData.length) return;
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
            options.push(`<option value="${plan.id}">${plan.nome}</option>`);
        });
        plansData = data;
        $('#plano_id').removeClass('skeleton').html(options.join(''));
        loadPlan();
    } catch (error) {
        console.error('Erro ao carregar os planos de serviço:', error);
    }
}
/**
 * Soma os valores da tabela
 * Deve aguardar o carregamento das faixas de faturamento
 */
function sum() {
    let totalBill = 0;
    $('#table-plan tbody tr td:nth-child(5)').each(function () {
        totalBill += parseCurrencyToFloat($(this).text()) || 0;
    });
    $('#table-plan tfoot tr:nth-child(1) td:nth-child(3)').text(currencyFormat(totalBill));
    const parentSkeleton = $('div.skeleton').parent();
    parentSkeleton.text('-');
}
/**
 * Salva o plano de serviço
 * @returns void
 */
export function savePlan() {
    removeInvalidFeedback('#form-plan');
    const id = $('#form-plan [name="id"]').val();//Id do plano salvo
    const pid = $('#form-plan [name="plano_id"]').val();//Id do plano de serviço
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
/**
 * Valida o formulario
 * @returns boolean
 */
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
/**
 * Verifica de o formulario foi alterado
 * @returns boolean
 */
export function hasChanged(){
    if(planData.plano.id != $('#form-plan [name="plano_id"]').val()){
        return true;
    }

    if(planData.plano.total_socios != $('#form-plan [name="id"]').length){
        return true;
    }

    if(planData.plano.total_folha_pagamento != $('#form-company [name="total_funcionarios"]').val()){
        return true;
    }

    if(planData.plano.faixa_faturamento_id != $('#form-company [name="faixa_faturamento_id"]').val()){
        return true;
    }

    if(planData.plano.regime_tributario_id != $('#form-company [name="regime_tributario_id"]').val()){
        return true;
    }

    return false;
}