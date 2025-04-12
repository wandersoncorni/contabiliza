"use strict";
let perfil = 'admin';
$(function () {
    const perfis = ['admin', 'clientepj', 'clientepf', 'consultor'];
    const dataSet = [];
    configTable(perfil);
    $('#tab-users .nav-item').click(function () {
        perfil = perfis[($(this).children('button').prop('id')).replace(/[^\d]/g, '')];
        configTable(perfil);
    });

    const tbVinculo = $(`#tb-vinculo`).DataTable({
        rowId: 'id',
        autoWidth: false,
        columns: [
            { data: 'nome_cliente' },
            { data: 'obs' },
            {
                data: () => $('<div />', { class: 'd-inline-flex' }).append(
                    $('<buttom />', { class: 'btn btn-danger align-items-center d-inline-block me-2 excluir', type: 'buttom' })
                        .append($('<svg />', { class: 'icon icon-lg' })
                            .append($('<use />', { 'xlink:href': '/vendors/coreui/icons/svg/free.svg#cil-delete' })))
                ).prop('outerHTML')
            }
        ],
        language: {
            url: 'https://cdn.datatables.net/plug-ins/2.1.2/i18n/pt-BR.json',
        },
    });

    $('body').on('click', 'buttom.editar', function () {
        const uid = $(this).parents('tr:first').prop('id');
        $('.alert').remove();
        $('#form-usuario')[0].reset();
        tbVinculo.clear();
        $.getJSON(`/user/${uid}`, function (res) {
            const mid = '#modal-user';
            $(`${mid} [name="atributos[nome_social]"]`).val(res.atributos.nome_social);
            $(`${mid} [name=nome_usuario]`).val(res.nome_usuario);
            if (res.atributos.idioma) {
                $(`${mid} [name="atributos[idioma]"]`).val(res.atributos.idioma);
            }
            $(`${mid} [name=email]`).val(res.email);
            (res.perfil).map((perfil) => {
                $(`${mid} [name=${perfil}]`).prop({ checked: true });
            });
            dataSet.length = 0;
            res.vinculo.map((data) => {
                dataSet.push(data);
            })
            console.log(dataSet);
            tbVinculo.rows.add(dataSet).draw();
            $(mid).modal('show');
        }).fail(function (xhr) {
            let message = 'Ocorreu um erro inesperado! Informe o administrador do sistema.';
            if (xhr.status == 404) {
                message = xhr.responseJSON.error;
            }
            $('.body > div > div:first').before(
                $('<div />', { class: 'alert alert-danger', role: 'alert' }).append([
                    $('<svg />', { class: 'icon icon-lg me-2 float-start' }).html(
                        $('<use />', { 'xlink:href': '/vendors/coreui/icons/svg/free.svg#cil-x-circle' })
                    ),
                    message
                ]).prop('outerHTML')
            )
        });
    });
});
/*
 * Configuracao dos botoes de acao da tabela 
 */
const tbButtons = $('<div />', { class: 'd-inline-flex' }).append([
    $('<buttom />', { class: 'btn btn-primary align-items-center d-inline-block me-2 editar', type: 'buttom' })
        .append($('<svg />', { class: 'icon icon-lg' })
            .append($('<use />', { 'xlink:href': '/vendors/coreui/icons/svg/free.svg#cil-pencil' }))),
    $('<buttom />', { class: 'btn btn-danger align-items-center d-inline-block excluir', type: 'buttom' })
        .append($('<svg />', { class: 'icon icon-lg' })
            .append($('<use />', { 'xlink:href': '/vendors/coreui/icons/svg/free.svg#cil-delete' })))
]).prop('outerHTML');

/*
 * Configura as listas de clientes 
 */
const configTable = (() => {
    return (perfil) => {
        $(`#table-${perfil}`).DataTable({
            rowId: 'id',
            retrieve: true,
            ajax: {
                url: '/users',
                type: 'POST',
                data: {
                    _token: $('[name=_token]').val(),
                    perfil: perfil
                },
                dataSrc: (res) => {
                    res.data.map((val, index) => {
                        res.data[index]['ordem'] = index + 1;
                    });
                    return res.data;
                }
            },
            columnDefs: [{ width: '1px', targets: [0, 2] }],
            autoWidth: false,
            columns: [
                {
                    data: 'ordem'
                },
                { data: 'nome_usuario' },
                {
                    data: 'id',
                    render: (obj) => {
                        return tbButtons;
                    }
                },
            ],
            language: {
                url: 'https://cdn.datatables.net/plug-ins/2.1.2/i18n/pt-BR.json',
            },
        });
    }
})();