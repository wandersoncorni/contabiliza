/**
 * Scripts para o wizard de passos
 * @author Firstname Lastname <wandersoncorni@gmail.com>
 */
'use strict';

export function next() {
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