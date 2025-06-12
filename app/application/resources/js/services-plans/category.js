/**
 * Scripts para aba de categorias do modal de criacao e edicao de plano
 */
'use strict';
import { getButtons } from './index.js';

let categoriesData = [];
import { setCategoriesOptions } from './service-plan.js';
export function init() {
    $('#form-category')[0].reset();    
    $('#tb-categories').on('click', 'button', function () {
        if ($(this).data('action') == 'edit') {
            const category = categoriesData.find(cat =>cat.id == $(this).data('id'));
            $('#form-category input[name="id"]').val(category.id);
            $('#form-category input[name="nome"]').val(category.nome);
        }
        else if ($(this).data('action') == 'delete') {
            const category = categoriesData.find(cat =>cat.id == $(this).data('id'));
            Swal.fire({
                title:`Exclusão de categoria ${category.nome}`,
                text: "Voce não poderá reverter essa ação!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sim, excluir!'
            }).then((result) => {
                if (result.isConfirmed) {
                    deleteCategory(category.id);
                }
            })
        }
    });
    loadCategoriesList();
    
    $('#form-category').submit(function(e){
        e.preventDefault();
        if($('#form-category input[name="id"]').val() > 0){
            editCategory();
            return;
        }
        createCategory();
    });
}
/**
 * Carrega a lista de categorias
 */
function loadCategoriesList() {
    if ($.fn.dataTable.isDataTable('#tb-categories')) {
        $('#tb-categories').DataTable().destroy();
    }
    $('#tb-categories').DataTable({
        ajax: (data, callback) =>
            fetch('/api/v1/categorias-servicos')
                .then(async response => {
                    if (!response.ok) {
                        callback({ data: [] });
                        return;
                    }
                    categoriesData = await response.json();
                    callback({ data: categoriesData });
                }),
        columns: [
            { data: 'nome' },
            { data: (data) => getButtons(data.id, '/category') }
        ],
        columnDefs: [
            { "orderable": false, "targets": [1] } // Desabilita ordenação na coluna de ações
        ],
        order: [[0, "asc"]]
    });
}
/**
 * Salva uma nova categoria
 */
function createCategory() {
    const formData = new FormData(document.getElementById('form-category'));
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
 * Edita uma categoria
 */
function editCategory() {
    const formData = new FormData(document.getElementById('form-category'));
    if(formData.get('nome') == categoriesData.find(cat =>cat.id == formData.get('id')).nome){
        $('#form-category')[0].reset();
        return;
    }
    formData.append('_method', 'PUT');
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
 * 
 */
function deleteCategory(id) {
    sendRequest({
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json',
        },
        credentials: 'include'
    }, `/api/v1/categoria-servico/${id}`);
}

function sendRequest(options, url = '/api/v1/categoria-servico') {
    fetch(url, options)
        .then(async response => {
            if (!response.ok) {
                return;
            }
            const data = await response.json();
            loadCategoriesList();
            setCategoriesOptions();
            $('#form-category')[0].reset();
        });
}