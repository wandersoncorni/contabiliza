/**
 * Scripts para o wizard de passos
 * @author Firstname Lastname <wandersoncorni@gmail.com>
 */
'use strict';

import { addInvalidFeedback } from '../helpers.js';

export function next() {
    // Valida o formulario
    
    if (!validateForm()) {
        Swal.fire({
            icon: 'warning',
            title: 'Atenção',
            text: 'Existe um ou mais campos inválidos.',
        });
        return;
    }
    //Valida se a empresa foi carregada após ser salva
    if ($('#form-company [name="id"]').val() == '') {
        Swal.fire({
            title: 'Erro',
            text: 'Ocorreu um erro ao tentar carregar os dados da empresa. Retorne a lista e selecione a empresa.',
            icon: 'error',
        });
        return;
    }

    const nextStep = $('.step-wizard-item.current-item').index() + 2;

    if (nextStep > 4) return;

    $('#btn-prev').prop({ disabled: false });
    if (nextStep == 4) {
        $('#btn-next').prop({ disabled: true });
    }
    move(nextStep);
}

export function prev() {
    const currentStep = $('.step-wizard-item.current-item').index();
    $('#btn-next').prop({ disabled: false });

    const prevStep = $('.step-wizard-item.current-item').index();

    if (prevStep <= 0) return;

    $('#btn-prev').prop({ disabled: false });
    if (prevStep == 1) {
        $('#btn-prev').prop({ disabled: true });
    }
    move(prevStep);
}

function move(step) {
    $('.step-wizard-item').removeClass('current-item');
    $('#nav-tabFormCompany .tab-pane').removeClass('show active');
    $(`.step-wizard-item:nth-child(${step})`).addClass('current-item');
    $(`#nav-tabFormCompany .tab-pane:nth-child(${step})`).addClass('show active');
}

function validateForm(){
    const form = $('#nav-tabFormCompany .tab-pane.active form');
    let isValidForm = true;
    let isValid = true;
    form.find('.is-invalid').removeClass('is-invalid');
    form.find('.invalid-feedback').remove();
    form.each(function () {
        isValid = $(this).get(0).checkValidity();        
        if (!isValid) {
            const formId = $(this).attr('id');
            isValidForm = false;

            $(`#${formId} :required`).each(function () {
                if ($(this).val() == '') {
                    addInvalidFeedback(this);
                }
            });
            
            if ((/^form-partner/).test(formId)) {
                $(this).find('.accordion').each(function () {
                    if ($(this).find('.is-invalid')) {
                        $(this).find('.accordion-button').click();
                        return;
                    }
                    $(this).find('.accordion').collapse('hide');
                });
            }
        }
    });

    return isValidForm;
}