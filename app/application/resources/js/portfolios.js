/**
 * Scripts para pagina de portifólios do modulo de gerenciamento
 */
'use strict';

export function init() {
    loadTable();
}
function loadTable(){
    return new DataTable('#tb-portfolios',{        
        ajax: (data, callback) => fetch('/api/v1/portfolios',{
            method: 'GET',
            credentials: 'include'
        }).then(response => response.json())
        .then(data => {
            return callback({data:data});
        })
        .catch(error => {
            console.error('Erro ao carregar os dados:', error);
        }),
        columns: [
            { data: 'name' },
            { data: 'status' },
            { data: 'created_at' },
            { data: 'actions' }
        ],
        columnDefs: [
            { targets: [1,2,3],orderable: false },
            { targets: [0,2], searchable: false },
        ]
    });
}