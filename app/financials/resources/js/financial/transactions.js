'use strict';

import { getButtons, formatDate } from '../../../../../resources/js/helpers';

export function init() {
    const url = '/api/v1/transactions';
    let transactions = [];
    let installments = [];

    // Função para formatar valores monetários
    function formatCurrency(value) {
        return new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(value);
    }

    // Função para converter string monetária para número
    function parseCurrency(value) {
        return parseFloat(value.replace(/[^\d,]/g, '').replace(',', '.'));
    }

    // Carregar selects
    function loadSelects() {
        // Carregar empresas
        if ($('#company_id option').length <= 1) {
            fetch('/api/v1/companies', {
                method: 'GET',
                headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
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

        // Carregar contas
        if ($('#account_id option').length <= 1) {
            fetch('/api/v1/accounts', {
                method: 'GET',
                headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
                credentials: 'include'
            })
                .then(response => response.json())
                .then(json => {
                    const accounts = json.map(account => `<option value="${account.id}">${account.bank_name} (${account.account_number})</option>`);
                    accounts.unshift('<option selected>Selecione uma conta</option>');
                    $('#account_id').html(accounts.join(''));
                })
                .catch(error => {
                    console.error('Erro ao carregar contas:', error);
                    Swal.fire('Erro', 'Não foi possível carregar as contas.', 'error');
                });
        }

        // Carregar planos de contas
        if ($('#chart_of_account_id option').length <= 1) {
            fetch('/api/v1/chart_of_accounts', {
                method: 'GET',
                headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
                credentials: 'include'
            })
                .then(response => response.json())
                .then(json => {
                    const charts = json.map(chart => `<option value="${chart.id}">${chart.name}</option>`);
                    charts.unshift('<option selected>Selecione um plano</option>');
                    $('#chart_of_account_id').html(charts.join(''));
                })
                .catch(error => {
                    console.error('Erro ao carregar planos de contas:', error);
                    Swal.fire('Erro', 'Não foi possível carregar os planos de contas.', 'error');
                });
        }

        // Carregar entidades
        if ($('#entity_id option').length <= 1) {
            fetch('/api/v1/entities', {
                method: 'GET',
                headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
                credentials: 'include'
            })
                .then(response => response.json())
                .then(json => {
                    const entities = json.map(entity => `<option value="${entity.id}">${entity.name}</option>`);
                    entities.unshift('<option selected>Selecione uma entidade</option>');
                    $('#entity_id').html(entities.join(''));
                })
                .catch(error => {
                    console.error('Erro ao carregar entidades:', error);
                    Swal.fire('Erro', 'Não foi possível carregar as entidades.', 'error');
                });
        }

        // Carregar condições de pagamento
        if ($('#payment_condition_id option').length <= 1) {
            fetch('/api/v1/payment_conditions', {
                method: 'GET',
                headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
                credentials: 'include'
            })
                .then(response => response.json())
                .then(json => {
                    const conditions = json.map(condition => `<option value="${condition.id}">${condition.name}</option>`);
                    conditions.unshift('<option selected>Selecione uma condição</option>');
                    $('#payment_condition_id').html(conditions.join(''));
                })
                .catch(error => {
                    console.error('Erro ao carregar condições de pagamento:', error);
                    Swal.fire('Erro', 'Não foi possível carregar as condições de pagamento.', 'error');
                });
        }
    }

    // Carregar DataTable de lançamentos
    function loadTable() {
        if ($.fn.dataTable.isDataTable('#tb-transactions')) {
            $('#tb-transactions').DataTable().destroy();
        }

        return new DataTable('#tb-transactions', {
            ajax: function (data, callback) {
                fetch(url, {
                    method: 'GET',
                    headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
                    credentials: 'include'
                })
                    .then(response => response.json())
                    .then(json => {
                        transactions = json;
                        callback({ data: json });
                    })
                    .catch(error => {
                        console.error('Erro ao carregar os dados:', error);
                        callback({ data: [] });
                    });
            },
            columns: [
                { data: 'date', render: data => formatDate(data) },
                { data: 'description' },
                { data: 'chart_of_account.name', defaultContent: '-' },
                { 
                    data: data => `
                        <div class="d-flex">
                            <svg class="icon icon-xs ${data.amount < 0 ? 'text-danger' : 'text-success'} me-2" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="${data.amount < 0 ? 'M12 18.75a.75.75 0 01-.75-.75V6.41l-2.22 2.22a.75.75 0 01-1.06-1.06l3.5-3.5a.75.75 0 011.06 0l3.5 3.5a.75.75 0 01-1.06 1.06l-2.22-2.22V18a.75.75 0 01-.75.75z' : 'M12 5.25a.75.75 0 01.75.75v5.59l2.22-2.22a.75.75 0 111.06 1.06l-3.5 3.5a.75.75 0 01-1.06 0l-3.5-3.5a.75.75 0 111.06-1.06l2.22 2.22V6a.75.75 0 01.75-.75z'}" clip-rule="evenodd" />
                            </svg>
                            ${formatCurrency(Math.abs(data.amount))}
                        </div>`
                },
                { 
                    data: data => data.status === 'success' ? '<span class="text-success">Confirmado</span>' : 
                                  data.status === 'pending' ? '<span class="text-warning">Pendente</span>' : 
                                  '<span class="text-danger">Cancelado</span>'
                },
                { data: data => getButtons(data.id, url) }
            ],
            columnDefs: [
                { targets: [5], orderable: false },
                { targets: [5], searchable: false }
            ],
            order: [[0, 'desc']]
        });
    }

    // Carregar parcelas no modal
    function loadInstallments(transactionId = null) {
        const tbody = $('#tb-installments tbody');
        tbody.empty();
        installments = [];

        if (transactionId) {
            fetch(`/api/v1/transactions/${transactionId}/installments`, {
                method: 'GET',
                headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
                credentials: 'include'
            })
                .then(response => response.json())
                .then(json => {
                    installments = json;
                    json.forEach(installment => addInstallmentRow(installment));
                })
                .catch(error => {
                    console.error('Erro ao carregar parcelas:', error);
                    Swal.fire('Erro', 'Não foi possível carregar as parcelas.', 'error');
                });
        }
    }

    // Adicionar linha de parcela
    function addInstallmentRow(installment = null) {
        const tbody = $('#tb-installments tbody');
        const rowId = installment ? installment.id : `new-${installments.length + 1}`;
        const row = `
            <tr data-id="${rowId}">
                <td><input type="number" class="form-control number" value="${installment ? installment.number : ''}" min="1"></td>
                <td><input type="date" class="form-control due_date" value="${installment ? installment.due_date : ''}"></td>
                <td><input type="text" class="form-control currency amount" value="${installment ? formatCurrency(installment.amount) : ''}"></td>
                <td>
                    <select class="form-control status">
                        <option value="pending" ${installment && installment.status === 'pending' ? 'selected' : ''}>Pendente</option>
                        <option value="paid" ${installment && installment.status === 'paid' ? 'selected' : ''}>Pago</option>
                        <option value="overdue" ${installment && installment.status === 'overdue' ? 'selected' : ''}>Vencido</option>
                    </select>
                </td>
                <td><button class="btn btn-xs btn-danger remove-installment">Remover</button></td>
            </tr>
        `;
        tbody.append(row);

        // Aplicar máscara de moeda
        $('.currency').on('input', function () {
            let value = $(this).val();
            value = value.replace(/\D/g, '');
            value = (Number(value) / 100).toFixed(2);
            $(this).val(formatCurrency(value));
        });
    }

    // Inicializar tabela
    loadTable();

    // Carregar selects ao abrir o modal
    $('#new-transaction').on('click', function () {
        $('#form-transaction')[0].reset();
        $('#form-transaction input[name="id"]').val('');
        $('#modal-form-transaction .modal-title').text('Novo Lançamento');
        loadSelects();
        loadInstallments();
        $('#modal-form-transaction').modal('show');
    });

    // Adicionar parcela
    $('#add-installment').on('click', function () {
        addInstallmentRow();
    });

    // Remover parcela
    $('#tb-installments').on('click', '.remove-installment', function () {
        $(this).closest('tr').remove();
    });

    // Ações do DataTable
    $('#tb-transactions').on('click', '.dropdown-item', function (e) {
        e.preventDefault();
        const id = $(this).attr('href').split('/').pop();
        const action = $(this).data('action');

        if (action === 'show') {
            const transaction = transactions.find(t => t.id == id);
            Swal.fire({
                title: transaction.description,
                html: `
                    <p><strong>Data:</strong> ${formatDate(transaction.date)}</p>
                    <p><strong>Empresa:</strong> ${transaction.company.nome || '-'}</p>
                    <p><strong>Conta:</strong> ${transaction.account ? `${transaction.account.bank_name} (${transaction.account.account_number})` : '-'}</p>
                    <p><strong>Plano de Contas:</strong> ${transaction.chart_of_account ? transaction.chart_of_account.name : '-'}</p>
                    <p><strong>Entidade:</strong> ${transaction.entity ? transaction.entity.name : '-'}</p>
                    <p><strong>Condição de Pagamento:</strong> ${transaction.payment_condition ? transaction.payment_condition.name : '-'}</p>
                    <p><strong>Valor:</strong> ${formatCurrency(Math.abs(transaction.amount))}</p>
                    <p><strong>Tipo:</strong> ${transaction.type === 'entrada' ? 'Entrada' : transaction.type === 'saida' ? 'Saída' : 'Imposto'}</p>
                    <p><strong>Status:</strong> ${transaction.status === 'success' ? 'Confirmado' : transaction.status === 'pending' ? 'Pendente' : 'Cancelado'}</p>
                `,
                icon: 'info',
                confirmButtonText: 'Fechar'
            });
        } else if (action === 'edit') {
            const transaction = transactions.find(t => t.id == id);
            $('#form-transaction input[name="id"]').val(transaction.id);
            $('#form-transaction select[name="company_id"]').val(transaction.company_id);
            $('#form-transaction select[name="account_id"]').val(transaction.account_id || '');
            $('#form-transaction select[name="chart_of_account_id"]').val(transaction.chart_of_account_id || '');
            $('#form-transaction select[name="entity_id"]').val(transaction.entity_id || '');
            $('#form-transaction select[name="payment_condition_id"]').val(transaction.payment_condition_id || '');
            $('#form-transaction input[name="date"]').val(transaction.date);
            $('#form-transaction input[name="description"]').val(transaction.description);
            $('#form-transaction input[name="amount"]').val(formatCurrency(transaction.amount));
            $('#form-transaction select[name="type"]').val(transaction.type);
            $('#form-transaction select[name="status"]').val(transaction.status);
            $('#modal-form-transaction .modal-title').text('Editar Lançamento');
            loadSelects();
            loadInstallments(transaction.id);
            $('#modal-form-transaction').modal('show');
        } else if (action === 'delete') {
            Swal.fire({
                title: 'Exclusão de lançamento',
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
                                Swal.fire('Sucesso', json.message || 'Lançamento excluído com sucesso!', 'success');
                            } else {
                                Swal.fire('Erro', json.message || 'Erro ao excluir lançamento.', 'error');
                            }
                        })
                        .catch(error => {
                            console.error('Erro ao excluir lançamento:', error);
                            Swal.fire('Erro', 'Erro ao processar a requisição.', 'error');
                        });
                }
            });
        }
    });

    // Enviar formulário
    $('#form-transaction').on('submit', function (e) {
        e.preventDefault();
        const id = $('#form-transaction input[name="id"]').val();
        const formData = new FormData(this);
        formData.set('amount', parseCurrency(formData.get('amount')));
        const urlAction = id ? `${url}/${id}` : url;
        const method = id ? 'PUT' : 'POST';

        if (id) {
            formData.append('_method', 'PUT');
        }

        // Coletar parcelas
        const installmentsData = [];
        $('#tb-installments tbody tr').each(function () {
            const row = $(this);
            installmentsData.push({
                id: row.data('id').startsWith('new-') ? null : row.data('id'),
                number: row.find('.number').val(),
                due_date: row.find('.due_date').val(),
                amount: parseCurrency(row.find('.amount').val()),
                status: row.find('.status').val()
            });
        });
        formData.append('installments', JSON.stringify(installmentsData));

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
                    $('#modal-form-transaction').modal('hide');
                    $('#form-transaction')[0].reset();
                    loadTable();
                    Swal.fire('Sucesso', json.message || 'Lançamento salvo com sucesso!', 'success');
                } else {
                    Swal.fire('Erro', json.message || 'Erro ao salvar lançamento.', 'error');
                }
            })
            .catch(error => {
                console.error('Erro ao salvar lançamento:', error);
                Swal.fire('Erro', 'Erro ao processar a requisição.', 'error');
            });
    });

    // Formatar campo de valor
    $('.currency').on('input', function () {
        let value = $(this).val();
        value = value.replace(/\D/g, '');
        value = (Number(value) / 100).toFixed(2);
        $(this).val(formatCurrency(value));
    });
}