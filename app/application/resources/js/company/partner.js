/**
 * Scripts para a tab de socios
 * Dependencies: helpers.js e partner_form.js
 */
'use strict';

import { formatPercentage, removeInvalidFeedback, addInvalidFeedback, removeFromArray, isValidCPF } from '../helpers.js';
import { createPartnerForm } from './partner_form.js';

let partnersData = [];
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
                text: 'O cadastro de empresas deve ter pelo menos um sócio.',
                icon: 'warning',
            });
            return;
        }
        const sid = $(this).parents('.accordion-body').first().find('[name="id"]').val()
        if (sid) {
            Swal.fire({
                title: 'Atenção',
                text: 'Deseja realmente excluir esse sócio?',
                icon: 'warning',
                showDenyButton: true,
                confirmButtonText: 'Sim',
                denyButtonText: 'Não'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/api/v1/partner/${sid}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    }).then(async response => {
                        const data = await response.json();
                        if (response.ok) {
                            $(this).closest('.accordion').remove();
                            partnersData = removeFromArray(partnersData, sid)
                            progressUpdate();
                            return;
                        }
                        Swal.fire({
                            icon: 'error',
                            title: 'Erro ao excluir sócio',
                            text: data.error ?? 'Erro desconhecido',
                        });
                    });
                }
            });
            return;
        }

        $(this).closest('.accordion').remove();
        progressUpdate();
    });
    //Busca de sócio pela API ao clicar no botão de busca
    $('#partners-container').on('input', '[name="cpf"]', function () {
        const val = $(this).val().replace(/[^0-9]/g, '');
        const form = $(this).parents('form');
        const formId = form.attr('id');

        if (val.length < 11) return;
        searchPartner($(this));
        $('.skeleton').removeClass('skeleton');
        if (!$(`${formId} [name="estado_civil_id"]`).val() == 2) {
            $(`${formId}[name="regimes_bens_id"]`).prop('disabled', true);
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
    $('#partners-container form').remove();
    createPartnerForm();
    progressUpdate();

    fetch(`/api/v1/partners/${$('#form-company [name="id"]').val()}`, {
        headers: {
            'Content-Type': 'application/json'
        },
    }).then(async response => {
        const data = await response.json();

        $('.skeleton').removeClass('skeleton').prop('disabled', false);
        $('#add-partner').prop('disabled', false);

        if (!response.ok || !data) {
            return;
        }
        // Se nenhuma empresa cadastrada abre o formulário
        if (data.length == 0) {
            if ($('.accordion').length) {
                const accordion = $('.accordion:first .accordion-button');
                accordion.click();
            }
            return;
        }
        // Insere os dados no formulário
        data.forEach((socio, index) => {
            const formId = `#form-partner-${index + 1}`;
            if ($(formId).length == 0) createPartnerForm();
            $(`${formId} .accordion .accordion-header .accordion-button label`).text(socio.nome);
            const form = $(formId);
            fillForm(formId, socio);
        });
        partnersData = data;
        progressUpdate();
    }).catch(error => {
        console.error('Erro ao carregar sócios:', error);
    });
}
/**
 * Insere os dados no formulário
 * @param {*} data 
 * @param {*} form
 */
function fillForm(form, data) {
    Object.keys(data).forEach(key => {
        if (key == 'regime_bens_id') {
            const disabled = $(`${form} [name="estado_civil_id"]`).val() != 2;
            $(`${form} [name="regime_bens_id"]`).prop('disabled', disabled).val('');
        }
        if(key == 'pro_labore') {
            $(`${form} [name="pro_labore"][value="${data.pro_labore}"]`).prop('checked', true);
        }
        $(`${form} [name="${key}"]`).val(data[key]);
        if (key == 'participacao') $(`${form} [name="${key}"]`).focus().blur();
    });
}
/**
 * Salva os dados dos forms do wizard
 */
export function savePartner() {
    $('.alert').remove();
    for (const form of $('[id^="form-partner"]')) {
        const formId = $(form).attr('id');
        let isValid = false;
        removeInvalidFeedback(`[id="${formId}"]`);
        // Valida o formulario
        if ($(`#${formId} [name="estado_civil_id"]`).val() == 2) {
            $(`#${formId} [name="regime_bens_id"]`).prop('required', true);
        }

        if ($(`#${formId}`)[0].checkValidity() == false) {
            $(`#${formId} [required=""]`).each(function () {
                if ($(`#${formId} [name="${$(this).attr('name')}"]`).val() == '') {
                    addInvalidFeedback(`[name="${$(this).attr('name')}"]`);
                }
            });
            Swal.fire({
                title: 'Atenção',
                text: 'Verifique os erros no formulário!',
                icon: 'warning',
            });
            continue;
        }

        // Só envia o form se for editado ou se for novo
        const changedFields = formHasChanged(formId);
        if ($(`#${formId} [name="id"]`).val() != '' && !changedFields.length) {
            continue;
        }

        // Configura o formulário
        let formData = null;
        if (changedFields.length == 0) {
            formData = new FormData($(`#${formId}`)[0]);
            formData.append('empresa_id', $(`#form-company [name="id"]`).val());
        }
        // Cria um form só com os campos alterados
        else {
            formData = new FormData();
            formData.append('id', $(`#${formId} [name="id"]`).val());
            formData.append('_method', 'PUT');
            for (const field of changedFields) {
                formData.append(field, $(`#${formId} [name="${field}"]`).val());
            }
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
                Swal.fire({
                    title: 'Sucesso',
                    text: 'Sócio salvo com sucesso!',
                    icon: 'success',
                })
                fillForm(`#${formId}`, data);
                const index = partnersData.findIndex(partner => partner.id == data.id);
                if (index != -1) partnersData[index] = data;
                else partnersData.push(data);
                progressUpdate();
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
            Swal.fire({
                title: 'Erro ao salvar sócio',
                text: data.error ?? 'Verifique os erros no formulário!',
                icon: 'error',
            });
        }).catch(error => {
            console.error(error);
        });
    }
}
/**
 * Verifica se os formulários dos sócios foram preenchidos ou alterados antes de prosseguir
 * para o próximo passo
 */
export function checkPartnersForm() {
    let isValid = true;
    const forms = $('[id^="form-partner"]');
    const naoSalvos = $('[id^="form-partner"] [name="id"][value=""]').length;
    if (naoSalvos) {
        const plural = naoSalvos > 1 ? 's' : '';
        Swal.fire({
            icon: 'warning',
            title: 'Atenção',
            text: `Existe${naoSalvos > 1 ? 'm' : ''} ${naoSalvos} formulário${plural} não salvo${plural}!`,
        });
        return false;
    }

    for (const form of forms) {
        if (formHasChanged($(form).attr('id')).length) {
            Swal.fire({
                icon: 'warning',
                title: 'Atenção',
                text: 'Um ou mais formulários foram alterados, salve os dados antes de prosseguir.',
            })
            return;
        }
    }
    let totalParticipacao = 0;
    $('[id^="form-partner"] [name="participacao"]').each(function () {
        totalParticipacao += parseFloat($(this).val().replace('[^\d\.]', ''));
    });
    if (totalParticipacao != 100) {
        isValid = false;
        Swal.fire({
            icon: 'warning',
            title: 'Atenção',
            text: 'A soma das participações dos sócios deve ser igual a 100%.',
        })
    }
    return isValid;
}
/**
 * Verifica se algum formulário nao foi modificado
 * @param {stringd} formId 
 * @returns array
 */
function formHasChanged(formId) {
    // Retorna se avariavel nao foi preenchida e o id do form não foi preenchido
    if (partnersData.length == 0 || $(`#${formId} [name="id"]`).val() == '') return [];

    const formData = new FormData($(`#${formId}`)[0]);
    const partnerData = partnersData.find(partner => partner.id == $(`#${formId} [name="id"]`).val());
    const fields = [];//Ids dos campos que foram alterados
    for (const [key, value] of formData) {
        if (key == 'id') continue;

        if (partnerData[key] == null || partnerData[key] == undefined) {
            if (value != '') {
                fields.push(key);
            }
        }
        else if (key == 'participacao') {
            if (parseFloat(partnerData[key]) != parseFloat(value.replace('[^\d\.]', ''))) {
                fields.push(key);
            }
        }
        else if (partnerData[key] != value) {
            fields.push(key);
        }
    }
    return fields;
}

export function hasChanged() {
    const forms = $('[id^="form-partner"]');
    for (const form of forms) {
        if (formHasChanged($(form).attr('id')).length) return true;
    }
    return false;
}
/**
 * Executa a busca do sócio pela API
 * @param {object} input O objeto jQuery do formulário
 */
function searchPartner(input) {

    const formId = input.parents('form').attr('id');
    let isFilled = false;

    $(`#${formId} [type="text"]`).each(function () {
        if ( !['cpf', 'participacao'].includes($(this).prop('name')) && $(this).val() != '') isFilled = true;
    });
    
    if (isFilled) return;

    input.removeClass('is-invalid');
    input.next('.invalid-feedback').remove();
    if (isValidCPF(input.val()) == false) {
        input.addClass('is-invalid');
        addInvalidFeedback(`#${formId} [name="cpf"]`, 'CPF inválido');
        return;
    }
    fetch(`/api/v1/partner-search?term=${encodeURIComponent(input.val())}`).then(async response => {
        const data = await response.json();
        if (!response.ok || !data) {
            return null;
        }
        data.id = ''; // Zera o id para criar um novo registro
        fillForm(`#${formId}`, data);
    });
}