/**
 * Scripts para pagina de consultores
 */
'use strict';
import * as users from '../../../application/resources/js/users.js';
export function init() {
    const tb = loadTable();
    users.loadFilters(0, null,1);
}

function loadTable() {
    const url = '/api/v1/consultants';
    return new DataTable('#tb-consultants', {
        ajax: function (data, callback, settings) {
            fetch(url, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json'
                },
                credentials: 'include'
            })
                .then(response => response.json())
                .then(json => { callback({ data: json });})
                .catch(error => {
                    console.error('Erro ao carregar os dados:', error);
                });
        },
        columns: [
            { data: (data) => users.getUserData(data) },
            { data: (data) => users.getActive(data) },
            { data: (data) => users.formatDate(data.created_at) },
            { data: (data) => users.getButtons(data.id, url) },
        ],
        columnDefs: [
            { targets: [1, 2, 3], orderable: false },
            { targets: [0], searchable: false },
        ],
    });
}