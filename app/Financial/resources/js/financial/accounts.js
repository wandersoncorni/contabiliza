'use strict';

import { getButtons, formatDate } from '../../../../../resources/js/helpers';

export function init() {
    const url = '/api/v1/accounts';
    let accounts = [];

    // Função para carregar empresas no select
    function loadCompanies() {
        if ($('#company_id option').length <= 1) {
            fetch('/api/v1/companies', {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                credentials: 'include'
            })
                .then(response => response.json())
                .then(json => {
                    const companies = json.map(company => `<option value="${company.id}">${company.nome}</option>`);
                    companies.unshift('<option selected>Selecione uma empresa</option>');
                    $('#company_id').html(companies.join(''));
                })
                .catch(error => {
                    console.error('Erro ao carregar empresas:', error);
                    Swal.fire('Erro', 'Não foi possível carregar as empresas.', 'error');
                });
        }
    }

    // Função para carregar DataTable
    function loadTable() {
        if ($.fn.dataTable.isDataTable('#tb-accounts')) {
            $('#tb-accounts').DataTable().destroy();
        }

        return new DataTable('#tb-accounts', {
            ajax: function (data, callback) {
                fetch(url, {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    credentials: 'include'
                })
                    .then(response => response.json())
                    .then(json => {
                        accounts = json;
                        callback({ data: json });
                    })
                    .catch(error => {
                        console.error('Erro ao carregar os dados:', error);
                        callback({ data: [] });
                    });
            },
            columns: [
                { data: 'bank_name' },
                { data: 'bank_code' },
                { data: 'agency' },
                { data: 'account_number' },
                { 
                    data: data => data.status === 'active' ? '<span class="text-success">Ativo</span>' : 
                                  data.status === 'pending' ? '<span class="text-warning">Pendente</span>' : 
                                  '<span class="text-danger">Inativo</span>'
                },
                { data: data => getButtons(data.id, url) }
            ],
            columnDefs: [
                { targets: [5], orderable: false },
                { targets: [5], searchable: false }
            ],
            order: [[0, 'asc']]
        });
    }

    // Inicializar tabela
    loadTable();

    // Carregar empresas ao abrir o modal
    $('#new-account').on('click', function () {
        $('#form-account')[0].reset();
        $('#form-account input[name="id"]').val('');
        $('#modal-form-account .modal-title').text('Nova Conta');
        loadCompanies();
        $('#modal-form-account').modal('show');
    });

    // Ações do DataTable
    $('#tb-accounts').on('click', '.dropdown-item', function (e) {
        e.preventDefault();
        const id = $(this).attr('href').split('/').pop();
        const action = $(this).data('action');

        if (action === 'show') {
            const account = accounts.find(a => a.id == id);
            Swal.fire({
                title: account.bank_name,
                html: `
                    <p><strong>Código do Banco:</strong> ${account.bank_code}</p>
                    <p><strong>Agência:</strong> ${account.agency}</p>
                    <p><strong>Número da Conta:</strong> ${account.account_number}</p>
                    <p><strong>Dígito:</strong> ${account.digit || '-'}</p>
                    <p><strong>Gerente:</strong> ${account.manager_name || '-'}</p>
                    <p><strong>Telefone:</strong> ${account.contact_phone || '-'}</p>
                    <p><strong>Tipo de Conta:</strong> ${account.account_type || '-'}</p>
                    <p><strong>Status:</strong> ${account.status === 'active' ? 'Ativo' : account.status === 'pending' ? 'Pendente' : 'Inativo'}</p>
                    <p><strong>Chave PIX:</strong> ${account.pix_key || '-'}</p>
                    <p><strong>Observações:</strong> ${account.notes || '-'}</p>
                `,
                icon: 'info',
                confirmButtonText: 'Fechar'
            });
        } else if (action === 'edit') {
            const account = accounts.find(a => a.id == id);
            $('#form-account input[name="id"]').val(account.id);
            $('#form-account select[name="company_id"]').val(account.company_id);
            $('#form-account input[name="bank_name"]').val(account.bank_name);
            $('#form-account input[name="bank_code"]').val(account.bank_code);
            $('#form-account input[name="agency"]').val(account.agency);
            $('#form-account input[name="account_number"]').val(account.account_number);
            $('#form-account input[name="digit"]').val(account.digit || '');
            $('#form-account input[name="manager_name"]').val(account.manager_name || '');
            $('#form-account input[name="contact_phone"]').val(account.contact_phone || '');
            $('#form-account select[name="account_type"]').val(account.account_type || '');
            $('#form-account select[name="status"]').val(account.status);
            $('#form-account input[name="pix_key"]').val(account.pix_key || '');
            $('#form-account textarea[name="notes"]').val(account.notes || '');
            $('#modal-form-account .modal-title').text('Editar Conta');
            loadCompanies();
            $('#modal-form-account').modal('show');
        } else if (action === 'delete') {
            Swal.fire({
                title: 'Exclusão de conta',
                text: 'Você não poderá reverter esta ação!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sim, excluir!',
                cancelButtonText: 'Cancelar'
            }).then(result => {
                if (result.isConfirmed) {
                    fetch(`${url}/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            'Accept': 'application/json'
                        },
                        credentials: 'include'
                    })
                        .then(response => response.json())
                        .then(json => {
                            if (response.ok) {
                                loadTable();
                                Swal.fire('Sucesso', json.message || 'Conta excluída com sucesso!', 'success');
                            } else {
                                Swal.fire('Erro', json.message || 'Erro ao excluir conta.', 'error');
                            }
                        })
                        .catch(error => {
                            console.error('Erro ao excluir conta:', error);
                            Swal.fire('Erro', 'Erro ao processar a requisição.', 'error');
                        });
                }
            });
        }
    });

    // Enviar formulário
    $('#form-account').on('submit', function (e) {
        e.preventDefault();
        const id = $('#form-account input[name="id"]').val();
        const formData = new FormData(this);
        const urlAction = id ? `${url}/${id}` : url;
        const method = id ? 'PUT' : 'POST';

        if (id) {
            formData.append('_method', 'PUT');
        }

        fetch(urlAction, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Accept': 'application/json'
            },
            body: formData,
            credentials: 'include'
        })
            .then(response => response.json())
            .then(json => {
                if (response.ok) {
                    $('#modal-form-account').modal('hide');
                    $('#form-account')[0].reset();
                    loadTable();
                    Swal.fire('Sucesso', json.message || 'Conta salva com sucesso!', 'success');
                } else {
                    Swal.fire('Erro', json.message || 'Erro ao salvar conta.', 'error');
                }
            })
            .catch(error => {
                console.error('Erro ao salvar conta:', error);
                Swal.fire('Erro', 'Erro ao processar a requisição.', 'error');
            });
    });
}