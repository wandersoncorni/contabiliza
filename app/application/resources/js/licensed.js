/**
 * Script for the license page
 */
'use strict';
export function init() {
    $(document).ready(function () {
        const tb = new DataTable('#tb-licensed', {
            autoWidth: false,
            columns: [
                { data: 'name' },
                { data: (data) => data.active ? '<span class="text-success">Ativo</span>' : '<span class="text-danger">Inativo</span>' },
                {
                    data: (data) => new Intl.DateTimeFormat('pt-BR', {
                        day: '2-digit',
                        month: '2-digit',
                        year: 'numeric'
                    }).format(new Date(data.created_at))
                },
                {
                    data: (data) => {
                        return $('<div />', { class: 'd-flex' }).append([
                            $('<button />', { class: 'btn btn-xs btn-transparent me-2', type: 'buttom', title: 'Carregar dados do cliente', 'data-id': data.id, 'data-name': data.name }).append(
                                $('<i />', { class: 'heroicon heroicon-arrow-path-square' })
                            ),
                            $('<div />', { class: 'dropdown clearfix' }).append([
                                $('<a />', { class: 'btn btn-outline-gray-200 btn-xs dropdown-toggle text-tertiary', href: '#', role: 'button', 'data-bs-toggle': 'dropdown', 'aria-expanded': 'false' }).append([
                                    $('<i />', { class: 'heroicon heroicon-horizontal-elipsis' })
                                ]),
                                $('<ul />', { class: 'dropdown-menu' }).append(
                                    $('<li />').append([
                                        $('<a />', { class: 'dropdown-item d-flex text-primary', href: '#', 'data-id': data.id }).append([
                                            $('<i />', { class: 'heroicon heroicon-lock-closed me-2' }),
                                            $('<span />').html('Bloquear')
                                        ])
                                    ]),
                                    $('<li />').append([
                                        $('<a />', { class: 'dropdown-item d-flex text-tertiary', href: '#', 'data-id': data.id }).append([
                                            $('<i />', { class: 'heroicon heroicon-pencil me-2' }),
                                            $('<span />').html('Editar')
                                        ])
                                    ]),
                                    $('<li />').append([
                                        $('<a />', { class: 'dropdown-item d-flex text-danger', href: '#', 'data-id': data.id }).append([
                                            $('<i />', { class: 'heroicon heroicon-trash me-2' }),
                                            $('<span />').html('Excluir')
                                        ])
                                    ])
                                )
                            ])
                        ]).prop('outerHTML');
                    }
                }
            ],
            columnDefs: [
                {
                    targets: [1, 2, 3],
                    orderable: false
                }
            ],
            ajax: (data, callback, settings) => {
                fetch('/api/v1/licensed', {
                    method: 'GET',
                    credentials: 'include'
                })
                    .then(response => response.json())
                    .then(data => {
                        const dataTable = [];
                        data.forEach((item) => {
                            dataTable.push({
                                id: item.id,
                                name: item.name,
                                created_at: item.created_at,
                                active: item.active
                            });
                        });
                        callback({ data: dataTable });
                    });
            }
        });
    });
}