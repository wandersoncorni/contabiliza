/**
 * Scripts para a aba de planos de servicos
 * @author Wanderson Corni <wandersoncorni@gmail.com>
 */
'use strict';

import { getButtons, loadPlansList } from './index.js';
import { loadOptionsPlansList } from './service-plan.js';

let plansData = [];
export function init() {
    loadPlanosServicosTable();
    formatCurrencyValue();
    // Carrega dados de um plano de servicos para edicao
    $('#app-content').on('click', '#tb-services-plans button', function () {
        if ($(this).data('action') == 'edit') {
            carregarFormPlanoServico(plansData.find(plano => plano.id == $(this).data('id')));
        }
        else if ($(this).data('action') == 'delete') {
            excluirPlanoServico(plansData.find(plano => plano.id == $(this).data('id')));
        }
    });
    $('#form-service-plan').on('submit', function (e) {
        e.preventDefault();
        const id = $('#form-service-plan input[name="id"]').val();
        if (id == 0) {
            salvarPlanoServico();
            return;
        }
        editarPlanoServico(plansData.find(plano => plano.id == id));
    });
    $('#colorPickerButton').on('click', function () {
        $('#colorPicker').click();
    });
    $('#colorPicker').change(function(){
        $('#form-service-plan input[name="cor"]').val($(this).val());
    });
    $('#form-service-plan input[name="cor"]').on('input', function () {
        $('#colorPicker').val($(this).val());
    })
}
// Carrega a tabela de planos de servicos
function loadPlanosServicosTable() {
    if ($.fn.dataTable.isDataTable('#tb-services-plans')) {
        $('#tb-services-plans').DataTable().destroy();
    }
    $('#tb-services-plans').DataTable({
        ajax: (data, callback) =>
            fetch('/api/v1/planos-servicos')
                .then(async response => {
                    if (!response.ok) {
                        callback({ data: [] });
                        return;
                    }
                    plansData = await response.json();
                    callback({ data: plansData });
                }),
        columns: [
            { data: 'nome' },
            { data: 'descricao' },
            { data: (data) => curencyFormat(data.valor_mensal) },
            { data: (data) => curencyFormat(data.valor_anual) },
            { data: (data) => data.ativo ? '<span class="text-success">Ativo</span>' : '<span class="text-danger">Inativo</span>' },
            { data: (data) => getButtons(data.id, '/plano-servico') }
        ],
        columnDefs: [
            { "orderable": false, "targets": [2, 3, 4] } // Desabilita ordenação na coluna de ações
        ],
        order: [[0, "asc"]]
    });
}
/**
 * Formata o valor para o padrao monetario brasileiro
 * @param {String} value
 * @returns
 */
function curencyFormat(value) {
    return new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(value);
}
/**
 * Carrega o form com os dados do plano
 * @param {object} data
 */
function carregarFormPlanoServico(data) {
    Object.keys(data).forEach(campo => {
        if (['valor_mensal', 'valor_anual'].includes(campo)) {
            $(`[name="${campo}"]`).val(data[campo]).trigger('input');
            return;
        }
        $(`[name="${campo}"]`).val(data[campo]);
    })
}
/**
 * Formata o valor do campo currency
 */
function formatCurrencyValue() {
    $('.currency').on('input', function () {
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
function clearCurrencyValue(value) {
    return (value).replace(/[^\d,]/g, '').replace('.', '').replace(',', '.');
}
/**
 * Salva o plano de servico
 */
function salvarPlanoServico() {
    const formData = new FormData(document.querySelector('#form-service-plan'));
    formData.set('valor_mensal', clearCurrencyValue(formData.get('valor_mensal')));
    formData.set('valor_anual', clearCurrencyValue(formData.get('valor_anual')));
    sendRequest({
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json',
        },
        credentials: 'include',
        body: formData
    });
}
/**
 * Edita um plano de servico
 * @param {object} data
 */
function editarPlanoServico() {
    const formData = new FormData(document.querySelector('#form-service-plan'));
    formData.set('valor_mensal', clearCurrencyValue(formData.get('valor_mensal')));
    formData.set('valor_anual', clearCurrencyValue(formData.get('valor_anual')));
    formData.append('_method', 'PUT');
    sendRequest({
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            'Accept': 'application/json',
        },
        body: formData,
    }, `/api/v1/plano-servico`);
}
/**
 * Edita um plano de servico
 * @param {object} data
 */
function excluirPlanoServico(data) {
    Swal.fire({
        title: 'Exclusão de plano de servico',
        text: "Voce não poderá reverter esta ação!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sim, excluir!'
    }).then((result) => {
        if (result.isConfirmed) {
            sendRequest({
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Accept': 'application/json',
                },
                credentials: 'include'
            }, `/api/v1/plano-servico/${data.id}`);
        }
    })
}
/**
 * Envia uma requisicao conforme os parametros
 * @param {Object} params
 */
function sendRequest(params, url = '/api/v1/plano-servico') {
    fetch(url, params)
        .then(async response => {
            const data = await response.json();
            if (response.ok) {
                loadPlansList();
                loadPlanosServicosTable();
                loadOptionsPlansList();
                $('#form-service-plan')[0].reset();
            } else {
                Swal.fire(`Erro ao enviar a requisição:`, data.message, 'error');
            }
        })
        .catch(error => console.error(`Erro ao enviar a requisição:`, error));
}
