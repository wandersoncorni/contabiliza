/**
 * Scripts para o wizard de passos
 * @author Firstname Lastname <wandersoncorni@gmail.com>
 */
'use strict';

export function next() {
    // Valida o formulario
    // const form = $('.tab-pane.active form');
    // if(!form.get(0).reportValidity()) return;
    const currentStep = $('.step-wizard-item.current-item').index();
    const nextStep = $('.step-wizard-item.current-item').next('.step-wizard-item');
    const nextTab = $('#nav-tabCompany .tab-pane.active').next('.tab-pane');
    // Verifica se existe o proximo passo e retorna se não houver
    if(nextStep.length == 0) {
        $('#btn-next').addClass('disabled');
        $('#btn-save-company').removeClass('disabled');
        return;
    }
    // Passa para o proximo tab
    $('#nav-tabCompany .tab-pane.active').removeClass('show active');
    nextTab.addClass('show active');
    // Passa para o proximo passo
    $('.step-wizard-list .current-item').removeClass('current-item');
    nextStep.addClass('current-item');
    $('#btn-prev').removeClass('disabled');
}

export function prev() {    
    const prev = $('.step-wizard-item.current-item').prev('.step-wizard-item');
    const prevTab = $('#nav-tabCompany .tab-pane.active').prev('.tab-pane');
    // sempre desabilita o botão de salvar
    $('#btn-save-company').addClass('disabled');
    if(prev.length == 0) {
        $('#btn-prev').addClass('disabled');        
        return;
    }    
    // Volta ao tab anterior
    $('#nav-tabCompany .tab-pane.active').removeClass('show active');
    prevTab.addClass('show active');
    // Volta ao passo anterior
    $('.step-wizard-list .current-item').removeClass('current-item');
    prev.addClass('current-item');
    $('#btn-next').removeClass('disabled');
}