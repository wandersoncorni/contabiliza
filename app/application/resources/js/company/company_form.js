/**
 * Scripts para o formulario de solicitação de nova empresa
 */
'use strict';

import { cepFormat, getAddress, formatCurrencyValue, removeInvalidFeedback, addInvalidFeedback, listStates } from '../helpers.js';
import { newCompaniesList, loadNewCompaniesTable } from './company.js';

export function init() {
    $(document).on('show.bs.modal', '#modal-form-company', function () {
        $('#form-company')[0].reset();
        $('#form-company').find('.is-invalid').removeClass('is-invalid');
        $('#form-company #id').val('');
        $('#form-company [data-changed="true"]').removeAttr('data-changed');
        listarCNAEs();
        listarRegimesTributarios()
        listarFaixasFaturamento();
        listarNaturezasJuridicas();
        listarAreasAtividade();
        listStates('[name="estado"]');
    });
    // Formata o campo de capital social
    $('#capital_social').on('input', function () { formatCurrencyValue(this); });
    $(document).on('input', '#cep-company', function () {
        cepFormat(this);
        getAddress(this);
    });
    //Seleciona as faixas de faturamento de acordo com o regime tributário
    $('#regime_tributario').on('change', function () {
        const val = $(this).val();
        if (!val) {
            $('#faixa_faturamento').prop('disabled', true);
            return;
        }

        $('#faixa_faturamento option')
            .addClass('hidden')
            .each(function () {
                if ($(this).attr('data-regime-tributario') == val) {
                    $(this).removeClass('hidden');
                }
            });
        $('#faixa_faturamento').prop('disabled', false);
    });

    $('#form-company').on('input', 'input', function () {
        if ($('#form-company #id').val() != '') {
            $(this).attr('data-changed', 'true');
        }
    });
    $('#form-company').on('change', 'select', function () {
        if ($('#form-company #id').val() != '') {
            $(this).attr('data-changed', 'true');
        }
    });
}
/**
 * Lista as CNAEs
 */
async function listarCNAEs() {

    if ($('#cnae option').length > 0) return;

    const response = await fetch('/api/v1/cnaes');
    const lista = await response.json();
    $('#cnae').prop({ disabled: true }).addClass('skeleton');
    $('#cnae').html('<option value="">Selecione um CNAE</option>');
    lista.forEach((item) => {
        $('#cnae').append($('<option />', {
            value: item.id,
            text: item.descricao
        }));
    });
    $('#cnae').prop({ disabled: false }).removeClass('skeleton');
}
/**
 * Lista os regimes tributários
 */
async function listarRegimesTributarios() {

    if ($('#regime_tributario option').length > 0) return;

    const response = await fetch('/api/v1/regimes-tributarios');
    const lista = await response.json();
    $('#regime_tributario').prop({ disabled: true }).addClass('skeleton');
    $('#regime_tributario').html('<option value="">Selecione um regime tributário</option>');
    lista.forEach((item) => {
        $('#regime_tributario').append($('<option />', {
            value: item.id,
            text: item.descricao
        }));
    });
    $('#regime_tributario').prop({ disabled: false }).removeClass('skeleton');
}
/**
 * Lista as faixas de faturamento
 */
async function listarFaixasFaturamento() {

    if ($('#faixa_faturamento option').length > 0) return;

    const select = $('#faixa_faturamento');

    select.prop({ disabled: true }).addClass('skeleton');

    const response = await fetch('/api/v1/faixas-faturamento')
    const data = await response.json();

    select.html('<option value="">Selecione uma faixa de faturamento</option>');
    data.forEach((faixa, id) => {
        select.append($('<option />', {
            class: 'hidden',
            value: faixa.id,
            text: faixa.descricao,
            'data-regime-tributario': faixa.regime_tributario_id
        }));
    });

    select.removeClass('skeleton');
}
/**
 * Lista as naturezas jurídicas
 */
async function listarNaturezasJuridicas() {
    if ($('#natureza_juridica option').length > 0) return;

    fetch('/api/v1/naturezas-juridicas')
        .then(async response => {
            if (!response.ok) {
                return;
            }
            const data = await response.json();
            const select = $('#natureza_juridica');
            select.empty();
            select.append($('<option />', {
                value: '',
                text: 'Selecione a natureza jurídica'
            }));
            data.forEach(natjur => {
                select.append($('<option />', {
                    value: natjur.id,
                    text: natjur.descricao
                }));
            });
        });
}
/**
 * 
 * @returns Lista as areas ou ramos de atividade
 */
async function listarAreasAtividade() {
    if ($('#area_atividade option').length > 0) return;
    $('#area_atividade').prop({ disabled: true }).addClass('skeleton');
    try {
        const response = await fetch('/api/v1/areas-atividade');
        const lista = await response.json();
        const select = $('#area_atividade');
        select.empty();
        select.append($('<option />', {
            value: '',
            text: 'Selecione uma area de atividade'
        }));
        lista.forEach((item) => {
            select.append($('<option />', {
                value: item.id,
                text: item.descricao
            }));
        });
        $('#area_atividade').prop({ disabled: false }).removeClass('skeleton');
    } catch (error) {
        console.error(error);
    }
}
//Salva o formulário de empresa
export function saveCompany() {
    $('#form-company .alert').remove();
    const form = $('#form-company');
    if ($('#form-company .is-invalid').length) {
        return;
    }
    
    //Envia o formulario completo se o ID for vazio, indicando que é um novo registro
    let formData = null;
    let config = {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            'accept': 'application/json'
        },
    };
    if ($('#form-company #id').val() == '') {
        formData = new FormData($('#form-company')[0]);
        config.body = formData;
    }
    // Se o ID já existir, atualiza o registro
    else if ($('#form-company [data-changed="true"]').length) {
        formData = new FormData();
        $('#form-company [data-changed="true"]').each(function () {
            formData.append($(this).attr('name'), $(this).val());
        });
        formData.append('id', $('#form-company #id').val());
        formData.append('_method', 'PUT');
        config.body = formData;
    }
    else {
        return;
    }
    fetch('/api/v1/company', config).then(async response => {
        const data = await response.json();
        if (response.ok) {            
            $('#form-company [data-changed="true"]').removeAttr('data-changed');
            newCompaniesList.push(data);
            loadNewCompaniesTable();
            $('#form-company [name="id"]').val(data.id)
            $('#form-company div:first').prepend(
                $('<div />', { class: 'alert alert-success d-flex align-items-center' }).append([
                    $('<i />', { class: 'heroicon heroicon-check-circle me-2' }),
                    $('<span />', { text: 'Empresa salva com sucesso!' })                
            ]));
            return;
        }   
        if (data.error) {
            $('#form-company div:first').prepend($('<div />', { class: 'alert alert-danger d-flex align-items-center'}).append(
                $('<i />', { class: 'heroicon heroicon-x-circle me-2' }),
                data.error
            ));
            return;
        }
        if(typeof data.errors === 'object') {
            Object.keys(data.errors).forEach(field => {
                if(field == 'id') return;
                const el = $(`#form-company [name="${field}"]`);
                if (el.length) {
                    addInvalidFeedback(el.get(0), data.errors[field][0]);
                } else {
                    $('#form-company').prepend($('<div />', {
                        class: 'alert alert-danger',
                        text: 'Ocorreu um erro ao salvar a empresa'
                    }));
                }
            });
            return;
        }
        $('#form-company div:first').prepend($('<div />', { class: 'alert alert-danger d-flex align-items-center'}).append(
                $('<i />', { class: 'heroicon heroicon-x-circle me-2' }),
                'Ocorreu um erro ao salvar a empresa'
            ));
    });
}