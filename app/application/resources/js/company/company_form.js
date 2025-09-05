/**
 * Scripts para o formulario de solicitação de nova empresa
 */
'use strict';

import { cepFormat, currencyFormat, getAddress, formatCurrencyValue, addInvalidFeedback, listStates } from '../helpers.js';
import { companiesList, loadCompaniesTable } from './company.js';
import 'select2';
import 'select2/dist/css/select2.min.css';
import 'select2-bootstrap-5-theme/dist/select2-bootstrap-5-theme.min.css';

let companyData = null;

export function init() {
    $(document).on('show.bs.modal', '#modal-form-company', function () {
        $('#form-company')[0].reset();
        $('#form-company').find('.is-invalid').removeClass('is-invalid');
        $('#form-company #id').val('');
        $('#cnae').val('').trigger('change');
        companyData = null;
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
    $('[name="cnae_id[]"]').select2({
        theme: "bootstrap-5",
        width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
        placeholder: $(this).data('placeholder'),
        closeOnSelect: false,
    });
}

export function setCompanyData(data) {
    companyData = data;
    Object.keys(companyData).forEach(campo => {
        const field = $(`#form-company [name="${campo}"]`);
        if (field.is('select')) {
            (async () => await setSelectValue(campo, companyData[campo]))();
            return;
        }

        if(campo == 'cnae_id') {
            (async () => await setSelectValue('cnae_id[]', companyData[campo]))();
            return;
        }

        if (campo == 'capital_social') {
            field.val(currencyFormat(companyData[campo]));
            return;
        }

        field.val(companyData[campo]);
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
                $(`[name="${select}"]`).val(value).trigger('change');
                resolve(true);
            }
            if (Date.now() - start > 30000) {
                clearInterval(interval);
            }
        }, 500);
    });
}
/**
 * Lista as CNAEs
 */
export async function listarCNAEs() {

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
export async function listarRegimesTributarios() {

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
export async function listarFaixasFaturamento() {

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
export async function listarNaturezasJuridicas() {
    if ($('#natureza_juridica option').length > 0) return;

    return fetch('/api/v1/naturezas-juridicas')
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
 * Lista as areas ou ramos de atividade
 */
export async function listarAreasAtividade() {
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
    $('.is-invalid').removeClass('is-invalid');
    $('.invalid-feedback').remove();
    // Valida o formulário
    if (!$('#form-company')[0].checkValidity()) {
        Swal.fire('Atenção', 'Verifique os erros no formulário', 'warning');
        $('#form-company [required=""]').each(function () {
            if ($(this).val() == '') {
                $(this).addClass('is-invalid').val($(this).val());
                addInvalidFeedback(this);
            }
        })
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
    //Se o ID não existir, cria um novo registro
    if ($('#form-company #id').val() == '') {
        formData = new FormData($('#form-company')[0]);
        config.body = formData;
    }
    //Senão, separa somente os campos alterados
    else if (companyData != null) {
        formData = new FormData();
        const form = new FormData($('#form-company')[0]);
        form.forEach((value, key) => {
            if (key == 'id') return;
            if (key == 'capital_social') {
                const formValue = value.replace(/[^\d,]/g, '').replace(',', '.');
                if (companyData[key] != formValue) {
                    formData.append(key, formValue);
                }
            }
            else if (companyData[key] == null) {
                if (value != '') {
                    formData.append(key, value);
                }
            }
            else if (companyData[key] != value) {
                formData.append(key, value);
            }
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
            companiesList.push(data);
            loadCompaniesTable();
            $('#form-company [name="id"]').val(data.id)
            Swal.fire({
                icon: 'success',
                title: 'Empresa salva com sucesso'
            });
            companyData = data;
            return;
        }
        if (data.error) {
            Swal.fire({
                icon: 'error',
                title: data.error ?? 'Erro ao salvar os dados da empresa.'
            });
            return;
        }
        if (typeof data.errors === 'object') {
            Object.keys(data.errors).forEach(field => {
                if (field == 'id') return;
                const el = $(`#form-company [name="${field}"]`);
                if (el.length) {
                    addInvalidFeedback(el.get(0), data.errors[field][0]);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Ocorreu um erro ao salvar a empresa'
                    });
                }
            });
            return;
        }
        $('#form-company div:first').prepend($('<div />', { class: 'alert alert-danger d-flex align-items-center' }).append(
            $('<i />', { class: 'heroicon heroicon-x-circle me-2' }),
            'Ocorreu um erro ao salvar a empresa'
        ));
    });
}

export function checkCompanyForm() {
    const formData = new FormData($('#form-company')[0]);
    const changed = hasChanged();
    if (changed) {
        Swal.fire({
            icon: 'warning',
            title: 'Atenção',
            text: 'Um ou mais campos da empresa foram alterados, salve os dados antes de prosseguir.',
        });
        return false;
    }
    if(companyData == null) {
        Swal.fire({
            icon: 'warning',
            title: 'Atenção',
            text: 'Informe os dados da empresa antes de prosseguir.',
        });
        return false;
    }
    return true;
}

export function hasChanged() {
    const formData = new FormData($('#form-company')[0]);
    let changed = false;
    for (const [key, value] of formData) {
        if (changed == true) return changed;
        if (key == 'id') continue;
        if (companyData == null){
            changed = value !== '';
            continue;
        }
        if(key == 'cnae_id[]') {
            changed = !(companyData['cnae_id']).includes(value);
            continue;
        }
        if (key == 'capital_social') {
            changed = currencyFormat(companyData[key]) !== value;
            continue;
        }
        if (companyData[key] == null) {
            changed = value !== '';
            continue;
        }
        changed = companyData[key].toString() !== value;
    };
    return changed;
}