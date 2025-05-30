/**
 * Scripts para pagina de consultores
 */
'use strict';
export function init() {
    const tb = loadTable();
}

function loadTable() {
    const url = '/api/v1/services-plans';
    return new DataTable('#tb-plans', {
        ajax: function (data, callback) {
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
            { data: 'name' },
            { data: 'active' },
            { data: 'created_at' },
            { data: (data) => '' },
        ],
        columnDefs: [
            { targets: [1, 2, 3], orderable: false },
            { targets: [0], searchable: false },
        ],
    });
}