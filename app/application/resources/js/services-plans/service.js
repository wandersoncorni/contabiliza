/**
 * Scripts para aba de categorias do modal de criacao e edicao de plano
 */
'use strict';

import { getButtons } from '../services-plans.js';
import { setServicesOptions } from './service-plan.js';
let servicesData = [];
export function init() {
    $('#form-service')[0].reset();
    loadServicesList();
    $('#form-service').on('submit', function (e) {
        e.preventDefault();
        const id = $('#form-service input[name="id"]').val();
        if (id == 0) {
            createService();
            return;
        }
        editService(servicesData.find(servico => servico.id == id));
    });
    $('#tb-services').on('click', 'button', function () {
        if ($(this).data('action') == 'edit') {
            const service = servicesData.find(cat =>cat.id == $(this).data('id'));
            $('#form-service input[name="id"]').val(service.id);
            $('#form-service input[name="nome"]').val(service.nome);
        }
        else if ($(this).data('action') == 'delete') {
            const service = servicesData.find(cat =>cat.id == $(this).data('id'));
            Swal.fire({
                title:`Exclusão de categoria ${service.nome}`,
                text: "Voce não poderá reverter essa ação!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sim, excluir!'
            }).then((result) => {
                if (result.isConfirmed) {
                    deleteService(service.id);
                }
            })
        }
    });
}
/**
 * Carrega a lista de categorias
 */
function loadServicesList() {
    if ($.fn.dataTable.isDataTable('#tb-services')) {
        $('#tb-services').DataTable().destroy();
    }
    $('#tb-services').DataTable({
        ajax: (data, callback) =>
            fetch('/api/v1/servicos')
                .then(async response => {
                    if (!response.ok) {
                        callback({ data: [] });
                        return;
                    }
                    servicesData = await response.json();
                    let list = '';
                    servicesData.forEach(ServiceWorker => {
                        list += `<tr>
                                <td>${ServiceWorker.nome}</td>
                                <td>${getButtons(ServiceWorker.id, '/servico')}</td>
                            </tr>`;
                    });
                    $('#tb-services tbody').html(list);
                }),
        columnDefs: [
            { "orderable": false, "targets": [1] } // Desabilita ordenação na coluna de ações
        ],
        order: [[0, "asc"]]
    });
}
/**
 * Cria um servico
 */
function createService() {
    sendRequest({ 
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            'Accept': 'application/json',
        },
        body: new FormData(document.querySelector('#form-service'))
    });
}
/**
 * Edita um servico
 */
function editService() {
    const formData = new FormData(document.querySelector('#form-service'));
    formData.append('_method', 'PUT');
    sendRequest({ 
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json',
        },
        body: formData
    });
}
/**
 * Exclui um servico
 */
function deleteService(id) {
    sendRequest({ 
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            'Accept': 'application/json',
        }
    }, `/api/v1/servico/${id}`);
}

function sendRequest(options, url = '/api/v1/servico') {
    fetch(url, options)
        .then(async response => {
            if (!response.ok) {
                return;
            }
            const data = await response.json();
            loadServicesList();
            setServicesOptions();
            $('#form-service')[0].reset();
        });
}