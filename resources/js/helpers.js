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
export function currencyFormat(value) {
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
            $(`[data-address="${seletor}"]`).siblings('.invalid-feedback').remove();
            $(`[data-address="${seletor}"].is-invalid`).removeClass('is-invalid');
            const data = await response.json();
            if (data.erro) {
                addInvalidFeedback('[name="cep"]', 'CEP inválido!');
                $(`[data-address="${seletor}"]:not([name="cep"])`).val('');
                return;
            }
            $(`[data-address="${seletor}"]`).each(function () {
                if ($(this).prop('name').includes('estado')) {
                    $(this).children('option').each(function () {
                        if ($(this).text() === data.estado) {
                            $(this).prop('selected', true);
                        }
                    });
                    return;
                }
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
    $(document).on('input', field, function () {
        let val = $(this).val();
        val = sanitizeInput(val);
        if (val.length > 5) {
            val = val.substring(0, 5);
        }
        if (val > 100) {
            val = val / 10;
        }
        $(this).val(val + (val !== '' ? '%' : ''));
    });

    $(document).on('focus', field, function () {
        let val = $(this).val();
        $(this).val(val.replace('%', ''));
    });

    $(document).on('blur', field, function () {
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

export function addInvalidFeedback(field, message = 'Campo obrigatório!') {
    $(field).addClass('is-invalid');
    $(field).after('<div class="invalid-feedback">' + message + '</div>');
}
/**
 * Remove a classe is-invalid e o feedback de erro
 * @param {*} form O seletor do formulário, se não for passado, remove de todos. Deve ser acrescentado de # (ex: #form-company)
 */
export function removeInvalidFeedback(form = '') {
    $(`${form} .is-invalid`).removeClass('is-invalid');
    $(`${form} .invalid-feedback`).remove();
}
// aplica a máscara no CPF
export function cpfFormat(field) {
    var value = $(field).val().replace(/\D/g, ''); // remove tudo que não for número

    if (value.length > 11) value = value.substring(0, 11); // limita a 11 dígitos

    // aplica a máscara
    if (value.length > 9) {
        value = value.replace(/(\d{3})(\d{3})(\d{3})(\d{1,2})/, "$1.$2.$3-$4");
    } else if (value.length > 6) {
        value = value.replace(/(\d{3})(\d{3})(\d{1,3})/, "$1.$2.$3");
    } else if (value.length > 3) {
        value = value.replace(/(\d{3})(\d{1,3})/, "$1.$2");
    }

    $(field).val(value);
}
// aplica a máscara no telefone
export function foneFormat(field) { 
    var value = $(field).val().replace(/\D/g, ''); // remove tudo que não for número

    if (value.length > 11) value = value.substring(0, 11); // limita a 11 dígitos

    if (value.length == 11) {
        // celular com 9 dígitos
        value = value.replace(/^(\d{2})(\d{5})(\d{4})$/, '($1) $2-$3');
    } else if (value.length >= 6) {
        // fixo com 8 dígitos
        value = value.replace(/^(\d{2})(\d{4})(\d{0,4})$/, '($1) $2-$3');
    } else if (value.length >= 3) {
        value = value.replace(/^(\d{2})(\d{0,5})$/, '($1) $2');
    } else if (value.length > 0) {
        value = value.replace(/^(\d{0,2})$/, '($1)');
    }

    $(field).val(value);
}
/**
 * Converte o valor de uma string no formato de moeda para float
 * @param {string} valor 
 * @returns 
 */
export function parseCurrencyToFloat(valor) {
    if (typeof valor !== 'string') return 0;

    return parseFloat(
        valor
            .replace(/\s/g, '')      // remove espaços
            .replace('R$', '')       // remove símbolo R$
            .replace(/\./g, '')      // remove pontos
            .replace(',', '.')       // troca vírgula por ponto
    );
}
// Lista de estados brasileiros
let statesList = [];
export async function listStates(nameField) {
    $(nameField).empty().addClass('skeleton');
    if (statesList.length == 0) {
        const request = await fetch('/api/v1/auxiliares/listar-estados');
        statesList = await request.json();
    }
    $(nameField).html('<option value="">Selecione um estado</option>').removeClass('skeleton');
    Object.keys(statesList).forEach(state => {
        $(nameField).append($('<option />', { value: statesList[state].sigla, text: statesList[state].descricao }));
    });
}
/**
 * Remove um item do array
 * @param {array} arr 
 * @param {string} id 
 * @returns
 */
export const removeFromArray = (arr, id) => {
    const idx = arr.findIndex(item => item && item.id == id); console.log(idx)
    if (idx === -1) return arr;
    arr.splice(idx, 1);
    return arr;
}
/**
 * Valida um CPF
 * @param {string} cpf 
 * @returns boolean
 */
export function isValidCPF(cpf) {
    cpf = (cpf || '').replace(/\D/g, '');
    if (cpf.length !== 11) return false;

    // rejeita sequências iguais (ex: 11111111111)
    if (/^(\d)\1{10}$/.test(cpf)) return false;

    // primeiro dígito verificador
    let sum = 0;
    for (let i = 0; i < 9; i++) {
        sum += parseInt(cpf.charAt(i)) * (10 - i);
    }
    let rest = sum % 11;
    let dig1 = (rest < 2) ? 0 : 11 - rest;
    if (dig1 !== parseInt(cpf.charAt(9))) return false;

    // segundo dígito verificador
    sum = 0;
    for (let i = 0; i < 10; i++) {
        sum += parseInt(cpf.charAt(i)) * (11 - i);
    }
    rest = sum % 11;
    let dig2 = (rest < 2) ? 0 : 11 - rest;
    if (dig2 !== parseInt(cpf.charAt(10))) return false;

    return true;
}
/**
 * 
 * @param {numeric} id O id do registro
 * @param {*} url 
 * @returns 
 */
export function getButtons(id, url){
    return $('<div />').append([
                    $('<button />', { class: 'btn btn-link btn-transparent text-dark dropdown-toggle dropdown-toggle-split m-0 p-0', type: 'button', 'data-bs-toggle': 'dropdown', 'aria-expanded': false, 'aria-haspopup': true }).append(
                        $('<i />', { class: 'heroicon heroicon-horizontal-elipsis float-start' })
                    ),
                    $('<div />', { class: 'dropdown-menu dashboard-dropdown dropdown-menu-start mt-2 py-1' }).append(
                        $('<a />', { class: 'dropdown-item text-info', href: `${url}/${id}`, 'data-action': 'show' }).append(
                            $('<i />', { class: 'heroicon heroicon-eye me-2' }),
                            'Ver'
                        ),
                        $('<a />', { class: 'dropdown-item text-primary', href: `${url}/${id}`, 'data-action': 'edit' }).append(
                            $('<i />', { class: 'heroicon heroicon-pencil-square me-2' }),
                            'Editar'
                        ),
                        $('<a />', { class: 'dropdown-item text-danger', href: `${url}/${id}`, 'data-action': 'delete' }).append(
                            $('<i />', { class: 'heroicon heroicon-trash me-2' }),
                            'Excluir'
                        )
                    )
                ]).prop('innerHTML')
}
/**
 * Formata uma data para o padrão pt-BR
 * @param {string} date 
 * @returns 
 */
export function formatDate(date) {
    return new Date(date).toLocaleDateString('pt-BR', {
        year: 'numeric',
        month: '2-digit',
        day: '2-digit'
    });
}