/**
 * Classe para armazenar funcoes utilitarias
 */
'use strict';
/**
 * Formata o valor do campo monetario
 * @param {string} field O seletor do campo
 */
export function formatCurrencyValue(field) {
    $(field).on('input', function () {
        let valor = $(this).val();
        valor = valor.replace(/\D/g, '');
        valor = (Number(valor) / 100).toFixed(2);
        $(this).val(new Intl.NumberFormat('pt-BR', {
            style: 'currency',
            currency: 'BRL'
        }).format(valor));
    });
}
/**
 * Sanitiza o valor dos campos com a classe "currency"
 * @param {string} field
 * @returns
 */
export function clearCurrencyValue(value) {
    return (value).replace(/[^\d,]/g, '').replace('.', '').replace(',', '.');
}
/**
 * Formata o valor para o padrao monetario brasileiro
 * @param {String} value
 * @returns
 */
export function curencyFormat(value) {
    return new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(value);
}
/**
 * Formata o cep
 * @param {*} field 
 */
export function cepFormat(field) {
    // Remove tudo que não for número
    let value = $(field).val().replace(/\D/g, '');

    // Limita a 8 dígitos
    if (value.length > 8) {
        value = value.substring(0, 8);
    }

    // Aplica o formato 00000-000
    if (value.length > 5) {
        value = value.substring(0, 5) + '-' + value.substring(5);
    }

    $(field).val(value);
}
/**
 * Busca o endereço pelo cep
 */
export function getAddress(field) {
    if ($(field).val().length == 9) {
        const seletor = $(field).data('address');
        fetch('https://viacep.com.br/ws/' + $(field).val() + '/json/', {
            method: 'GET',
            dataType: 'json'
        }).then(async response => {
            if (!response.ok) {
                return;
            }
            const data = await response.json();
            $(`[data-address="${seletor}"]`).each(function () {
                Object.keys(data).forEach(d => {
                    if ($(this).prop('name').includes(d)) {
                        $(this).val(data[d]);
                    }
                });
            })
        });
    }
}

export function formatPercentage(field) {
    $(field).on('input', function() {
        let val = $(this).val();
        val = sanitizeInput(val);
        if(val.length > 5){
            val = val.substring(0, 5);
        }
        if(val > 100) {
            val = val/10;
        }
        $(this).val(val + (val !== '' ? '%' : ''));
    });

    $(field).on('focus', function() {
        let val = $(this).val();
        $(this).val(val.replace('%', ''));
    });

    $(field).on('blur', function() {
        let val = sanitizeInput($(this).val());
        val = clampToPercentage(val);
        if (val !== '') {
            $(this).val(val + '%');
        } else {
            $(this).val('');
        }
    });
}

function sanitizeInput(val) {
    // Permitir só números e um único ponto
    val = val.replace(/[^0-9.]/g, '');
    let partes = val.split('.');
    if (partes.length > 2) {
        val = partes[0] + '.' + partes[1];
    }
    return val;
}

function clampToPercentage(val) {
    let num = parseFloat(val);
    if (isNaN(num)) return '';
    if (num < 0) num = 0;
    if (num > 100) num = 100;
    return num.toString();
}

export function addInvalidFeedback(field, message='Campo obrigatório!') {
    $(field).addClass('is-invalid');
    $(field).after('<div class="invalid-feedback">' + message + '</div>');
}

export function removeInvalidFeedback() {
    $('.is-invalid').removeClass('is-invalid');
    $('.invalid-feedback').remove();
}