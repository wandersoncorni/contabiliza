$('#users-table').DataTable({
    ajax: function (data, callback, settings) {
            fetch('/api/v1/users', {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json'
                },
                credentials: 'include'
            })
              .then(response => response.json())
              .then(json => {
                callback({ data: json });
              })
              .catch(error => {
                console.error('Erro ao carregar os dados:', error);
              });
          },
    columns: [
        { data: (data) => $('<input />', { type: 'checkbox', class: 'form-check-input', id: `user-${data.id}`, value: data.id }).prop('outerHTML') },
        { data: (data)=>{
                return $('<div />',{class: 'd-flex'}).append([                    
                    $('<img />', { class: 'rounded-circle avatar bg-light me-3', src: data.person.photo ?? '/img/user.png' }),
                    $('<div />').append([                    
                        $('<h1 />', { class: 'h5 mb-0 font-size-14'}).text(data.person.name),
                        $('<p />', { class: 'text-muted font-size-12 mb-0'}).append(
                            $('<i />', { class: 'heroicon heroicon-envelope mt-1 me-1 float-start'}),
                            data.email
                        ),
                    ]),
                ]).prop('outerHTML');
            }
        },
        { data: 'person.role_name' },
        { data: (data) => data.active ? $('<span />', { class: 'text-success' }).text('Ativo').prop('outerHTML') : $('<span />', { class: 'text-danger' }).text('Inativo').prop('outerHTML') },
        { 
            data: (data)=> new Date(data.created_at).toLocaleDateString('pt-BR', {
                year: 'numeric',
                month: '2-digit',
                day: '2-digit'
            }) 
        },
        {
            data: (data) => $('<div />').append([
                $('<button />', { class: 'btn btn-link btn-transparent text-dark dropdown-toggle dropdown-toggle-split m-0 p-0', type: 'button', 'data-bs-toggle': 'dropdown', 'aria-expanded': false, 'aria-haspopup': true }).append(
                    $('<i />', { class: 'heroicon heroicon-horizontal-elipsis float-start' })                        
                ),
                $('<div />', { class: 'dropdown-menu dashboard-dropdown dropdown-menu-start mt-2 py-1' }).append(
                    $('<a />', { class: 'dropdown-item text-info', href: `/api/v1/users/${data.id}` }).append(
                        $('<i />', { class: 'heroicon heroicon-eye me-2' }),
                        'Ver'
                    ),
                    $('<a />', { class: 'dropdown-item text-primary', href: `/api/v1/users/${data.id}/edit` }).append(
                        $('<i />', { class: 'heroicon heroicon-pencil-square me-2' }),
                        'Editar'
                    ),
                    $('<a />', { class: 'dropdown-item text-danger', href: `/api/v1/users/${data.id}/delete` }).append(
                        $('<i />', { class: 'heroicon heroicon-trash me-2' }),
                        'Excluir'
                    )
                )
            ]).prop('innerHTML')
        },
    ],
    columnDefs: [
        { targets: [0,2,3,4,5],orderable: false },
        { targets: [0,4,5], searchable: false },
    ],
});
$('#users-table').on('click', '#check-all', function () {
    $('#users-table tbody input[type="checkbox"]').prop('checked', $(this).is(':checked'));
});
$('#search-users').on('keyup', function () {
    const value = $(this).val();
    if (value.length < 3) {
        $('#users-table').DataTable().column(1).search('').draw();
        return;
    }
    $('#users-table').DataTable().column(1).search(value).draw();
});
$('#filter-perfil').on('change', function () {
    const value = $(this).val();
    if (value == 'todos') {
        $('#users-table').DataTable().column(2).search('').draw();
        return;
    }
    $('#users-table').DataTable().column(2).search(value).draw();
});
$('#filter-status').on('change', function () {
    const value = $(this).val();
    if (value == 'todos') {
        $('#users-table').DataTable().column(3).search('').draw();
        return;
    }
    $('#users-table').DataTable().column(3).search(value).draw();
});
$('#new-user').on('click', function () {
    if(!$('#role_id option').length){
        fetch('/api/v1/roles', {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json'
            },
            credentials: 'include'
        })
        .then(response => response.json())
        .then(json => {
            const roles = json.map(role => `<option value="${role.id}">${role.name}</option>`);
            roles.unshift('<option selected >Selecione um perfil</option>');
            $('#role_id').html(roles.join(''));
        });
    }
    
    if(!$('#licensed_id option').length){
        fetch('/api/v1/licensed', {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json'
            },
            credentials: 'include'
        })
        .then(response => response.json())
        .then(json => {
            const licensed = json.map(licensed => `<option value="${licensed.id}">${licensed.name}</option>`);
            licensed.unshift('<option selected >Selecione um licenciado</option>');
            $('#licensed_id').html(licensed.join(''));
        });
    }
});

$('#clear-user-filters').on('click', function () { console.log(1)
    $('#search-users').val('').trigger('keyup');
    $('#filter-perfil').val('todos').trigger('change');
    $('#filter-status').val('todos').trigger('change');
});