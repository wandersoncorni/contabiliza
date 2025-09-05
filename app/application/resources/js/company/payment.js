/**
 * Scripts para o modulo de pagamento
 */
'use strict';

import { planData } from './plan.js';

export function loadPayment() {
    if(!planData.pagamento) return;
    $('#form-payment [name="forma_pgto_id"]').val(planData.pagamento.forma_pgto_id);
    $('#form-payment [name="dia_cobranca"]').val(planData.pagamento.dia_cobranca);
}

export function savePayment(){
    const formData = new FormData($('#form-payment')[0]);

    if(!formData.get('forma_pgto_id') || !formData.get('dia_cobranca')) {
        Swal.fire({
            icon: 'error',
            title: 'Erro ao salvar dados de pagamento',
            text: 'Preencha todos os campos.',
        });
        return;
    }

    formData.append('plano_servico_contratado_id', planData.id);

    if($('#form-payment [name="forma_pgto_id"]').val()){
        formData.append('_method', 'PUT');
    }

    fetch('/api/v1/company-payment', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            'Accept': 'application/json',
        },
        body: formData
    }).then(async response => {
        const data = await response.json();
        if (response.ok) {
            planData.pagamento.forma_pgto_id = data.forma_pgto_id;
            planData.pagamento.dia_cobranca = data.dia_cobranca;
            $('#forma_pgto_id').val(planData.pagamento.forma_pgto_id);
            $('#dia_cobranca').val(planData.pagamento.dia_cobranca);
            Swal.fire({
                icon: 'success',
                title: 'Sucesso',
                text: 'Dados de pagamento salvo com sucesso.',
            });
            return;
        }
        Swal.fire({
            icon: 'error',
            title: 'Erro ao salvar dados de pagamento',
            text: data.error ?? '',
        });
    });
}

export function hasChanged() {
    if($('#form-payment [name="forma_pgto_id"]').val() != planData.pagamento.forma_pgto_id || 
       $('#form-payment [name="dia_cobranca"]').val() != planData.pagamento.dia_cobranca ||
       $('#contrato')[0].files.length > 0) return true;
    return false;
}