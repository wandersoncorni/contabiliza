/**
 * Scripts para pagina de empresas
 */
$(document).ready(function () {
    const tb = new DataTable('#tb-companies',{
        ajax: (data, callback) => fetch('/api/v1/companies',{
            method: 'GET',
            credentials: 'include'
        }).then(response => response.json())
        .then(response => {
            return callback({data: response});
        }),
        columns: [
            { data: 'name' },
            { data: 'actions' }
        ],
        columnDefs: [
            { targets: [0],orderable: true, searchable: true },
            { targets: [1],orderable: false, searchable: false },
        ]
    });

    $('#new-company').click(function () {
        newCompany();
    });

    $('#add-partner').click(function () {
    });

    $('#cpf').on('input', function() {
        var value = $(this).val().replace(/\D/g, ''); // remove tudo que não for número

        if (value.length > 11) value = value.substring(0, 11); // limita a 11 dígitos

        // aplica a máscara
        if (value.length > 9) {
            value = value.replace(/(\d{3})(\d{3})(\d{3})(\d{1,2})/, "$1.$2.$3-$4");
        } else if (value.length > 6) {
            value = value.replace(/(\d{3})(\d{3})(\d{1,3})/, "$1.$2.$3");
        } else if (value.length > 3) {
            value = value.replace(/(\d{3})(\d{1,3})/, "$1.$2");
        }

        $(this).val(value);
    });

    $('#telefone').on('input', function() {
        var value = $(this).val().replace(/\D/g, ''); // remove tudo que não for número

        if (value.length > 11) value = value.substring(0, 11); // limita a 11 dígitos

        if (value.length >= 10) {
            // celular com 9 dígitos
            value = value.replace(/^(\d{2})(\d{5})(\d{4})$/, '($1) $2-$3');
        } else if (value.length >= 6) {
            // fixo com 8 dígitos
            value = value.replace(/^(\d{2})(\d{4})(\d{0,4})$/, '($1) $2-$3');
        } else if (value.length >= 3) {
            value = value.replace(/^(\d{2})(\d{0,5})$/, '($1) $2');
        } else if (value.length > 0) {
            value = value.replace(/^(\d{0,2})$/, '($1');
        }

        $(this).val(value);
    });
});

function newCompany() {
    if ($.fn.dataTable.isDataTable('#tb-partners, #tb-billings')) {
        $('#tb-partners, #tb-billings').DataTable().clear().draw();
    }
    else{
        const tbPartner = new DataTable('#tb-partners', {
            columns: [
                { data: 'name' },
                { data: 'email' },
                { data: 'actions' }
            ],
            columnDefs: [
                { targets: [0, 1],orderable: true, searchable: true },
                { targets: [2],orderable: false, searchable: false },
            ]
        });

        const tbBillings = new DataTable('#tb-billings', {
            columns: [
                { data: 'descricao' },
                { data: 'valor' },
                { data: 'vencimento' },
                { data: 'status' },
                { data: 'actions' }
            ],
            columnDefs: [
                { targets: [0, 1],orderable: true, searchable: true },
                { targets: [4],orderable: false, searchable: false },
            ]
        });
    }
}