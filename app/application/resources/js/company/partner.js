/**
 * Scripts para a tab de socios
 * Dependencies: helpers.js e partner_form.js
 */
'use strict';

import { formatPercentage, removeInvalidFeedback, addInvalidFeedback } from '../helpers.js';
import { createPartnerForm } from './partner_form.js';

export function init() {
    // Cria o formulário de sócio
    createPartnerForm();
    formatPercentage('.percentage');

    $(document).on('click', '#add-partner', function () {
        createPartnerForm();
    });

    $(document).on('input', '.participacao', function () {
        progressUpdate();
    });
    $(document).on('click', '.remove-partner', function () {
        if ($('.accordion').length == 1) {
            Swal.fire({
                title: 'Atenção',
                text: 'O cadastro de empresas deve ter pelo menos um sốcio.',
                icon: 'warning',
            });
            return;
        }
        $(this).closest('.accordion').remove();
        progressUpdate();
    });
    $(document).on('click', '#btn-next', function () {
        if ( $('#nav-tabFormCompany .tab-pane.active').next('.tab-pane').prop('id') == 'nav-partners' && $('#form-company [name="id"]').val()) {
            listPartners();
        }
    });

}
/**
 * @function progressUpdate
 * @description Updates the progress bar based on the input values of the specified field.
 */
function progressUpdate() {
    let total = 0;
    $('.participacao').each(function () {
        let textVal = $(this).val() ?? 0;
        let val = textVal.replace(/[^0-9.]/g, '');
        total += parseFloat(val);
        if (total > 100) total = 100;
    });

    $('.progress-bar').css('width', total + '%')
        .attr({ 'aria-valuenow': total })
        .removeClass(['bg-info', 'bg-success'])
        .addClass(`bg-${total == 100 ? 'success' : 'info'}`);
    $('.progress-info span').text(total + '%');
}
/**
 * Carrega a lista de sócios da empresa
 */
export function listPartners() {
    if ($('.accordion').length) {
        const accordion = $('.accordion:first .accordion-button');
        accordion.click();
        $(`.accordion:first .accordion-body input[type="text"], 
            .accordion:first .accordion-body select, 
            .accordion:first .accordion-body [type="email"]`).each(function () {
            $(this).addClass('skeleton').prop('disabled', true);
        });
        fetch(`/api/v1/partners/${$('#form-company [name="id"]').val()}`, {
            headers: {
                'Content-Type': 'application/json'
            },
        }).then(async response => {
            const data = await response.json();

            $('.skeleton').removeClass('skeleton').prop('disabled', false);
            $('#add-partner').prop('disabled', false);

            if (!response.ok || !data || data.length == 0) {
                return;
            }
            data[0].socios.forEach((socio, index) => {
                const formId = `#form-partner-${index + 1}`;
                if($(formId).length == 0) createPartnerForm();
                $(`${formId} .accordion .accordion-header .accordion-button label`).text(socio.nome);
                const form = $(formId);
                fillForm(form, socio);
            });

            progressUpdate();
        }).catch(error => {
            console.error('Erro ao carregar sócios:', error);
        });
    }
}
/**
 * Insere os dados no formulário
 * @param {*} data 
 * @param {*} form
 */
function fillForm(form, data) {
    Object.keys(data).forEach(key => {
        if (['pro_labore', 'resp_rf'].includes(key)) {
            form.find(`[name="${key}"][value="${data[key]}"]`).prop('checked', true);
            return;
        }
        form.find(`[name="${key}"]`).val(data[key]);
        if(key == 'participacao') form.find(`[name="${key}"]`).focus();
    });
}

export function savePartner() {
    let participacao = 0;
    //Configura o formulário
    $('[id^="form-partner"]').each(function () {
        const formId = $(this).attr('id');
        removeInvalidFeedback(`#${formId}`);
        $(`#${formId} :required`).each(function () {
            if ($(this).val() == '') {
                addInvalidFeedback(this);
            }
        });
        if ($(`#${formId} [name="estado_civil"]`).val() == 2 && $(`#${formId} [name="regime_bens"]`).val() == '') {
            addInvalidFeedback($(`#${formId} [name="regime_bens"]`), 'Regime de bens é obrigatório para casados.');
        }
        //Soma as participações
        participacao += parseFloat($(`#${formId} [name="participacao"]`).val().replace(/[^0-9.]/g, '')) ?? 0;

        if ($(`#${formId} .is-invalid`).length > 0 && $(`#${formId} .accordion-button`).hasClass('collapsed')) {
            $(`#${formId}  .accordion-button`).click();
        }

    });

    if ($(`[id^="form-partner"] .is-invalid`).length > 0) {
        Swal.fire({
            icon: 'warning',
            title: 'Atenção',
            text: 'Existe um ou mais campos inválidos.',
        });
        return;
    }
    // Verifica se a soma das participações é igual a 100%
    if (participacao != 100) {
        Swal.fire({
            icon: 'warning',
            title: 'Atenção',
            text: 'A soma das participações deve ser igual a 100%',
        });
        return;
    }

    if($('#form-company [name="id"]').val() == '') {
        Swal.fire({
            icon: 'warning',
            title: 'Atenção',
            text: 'Os dados da empresa devem ser salvos antes de salvar os sócios.',
        });
        return;
    }

    $('[id^="form-partner"]').each(function () {
        const formId = $(this).attr('id');
        let formData = null;
        $(`#${formId} .alert`).remove();
        // Envia os dados via POST
        if($(`#${formId} [name="id"]`).val() == ''){
            formData = new FormData($(`#${formId}`)[0]);
            $(`#${formId} .alert`).remove();
            formData.append('company_id', $('#form-company [name="id"]').val());
        }
        // Envia os dados via PUT
        else if ($(`#${formId} [data-changed="true"]`).length) {
            formData = new FormData();
            formData.append('id', $(`#${formId} [name="id"]`).val());
            formData.append('_method', 'PUT');
            $(`#${formId} [data-changed="true"]`).each(function () {
                formData.append($(this).attr('name'), $(this).val());
            });
        }

        if (formData == null) {
            return;
        }

        fetch('/api/v1/partner', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Accept': 'application/json',
            },
            body: formData
        }).then(async (response) => {
            const data = await response.json();
            if (response.ok) {
                $(`#${formId} .label-name`).text(data.nome);
                $(`#${formId} .accordion-body div:first`).prepend(
                    $('<div />', { class: 'alert alert-success d-flex', role: 'alert' }).append(
                        $('<i />', { class: 'heroicon heroicon-check-circle me-2' }),
                        'Sócio salvo com sucesso!'
                    )
                );
                fillForm($(`#${formId}`), data);
                $(`#${formId} [data-changed="true"]`).removeAttr('data-changed');
                return;
            }

            if (data.errors) {
                for (const [key, value] of Object.entries(data.errors)) {
                    addInvalidFeedback($(`#${formId} [name="${key}"]`), value);
                }
            }
            else if (data.error) {
                if ($(`#${formId} .accordion-button`).hasClass('collapsed')) {
                    $(`#${formId} .accordion-button`).click();
                }
                $(`#${formId} .accordion-body div:first`).prepend(
                    $('<div />', { class: 'alert alert-danger d-flex', role: 'alert' }).append(
                        $('<i />', { class: 'heroicon heroicon-exclamation-triangle mt-1 me-2' }),
                        data.error
                    )
                );
            }
        }).catch(error => {
            console.error(error);
        });
    });
}