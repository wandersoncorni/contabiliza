/**
 * Scripts para pagina de consultores
 */
'use strict';
import * as users from './users.js';
export function init() { 
    const tb = loadClientsTable(); 
    users.loadFilters(0, null,1);
}

function loadClientsTable() {
    const url = '/api/v1/clients';
    return new DataTable('#tb-clients', {
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