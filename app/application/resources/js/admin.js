
/**
 * Scripts para funcoes de administracao
 */
import * as licensed from './licensed.js';
import * as users from './users.js';
$(document).ready(function () {
    if (sessionStorage.getItem('licensed_context') !== null) {
        buildLicensedMenu();
    }
    // Carrega a tabela e adiciona os eventos
    $(document).on('page:loaded', function (e) {
        const url = e.originalEvent.detail.url;
        if(url == '/licensed'){
            licensed.init();
        }
        else if(url == '/users'){
            users.init();            
            users.loadFilters();
            users.loadTable('/api/v1/users');
        }
    });
    $('#app-content').on('click', '#tb-licensed tbody tr td:last-child button', function () {
        sessionStorage.setItem('licensed_context', JSON.stringify({ id: $(this).attr('data-id'), name: $(this).attr('data-name') }));
        buildLicensedMenu();
    });
});
function buildLicensedMenu() {
    const licensed = JSON.parse(sessionStorage.getItem('licensed_context'));
    if ($('#sidebarMenuLicensed').length > 0) {
        $('#sidebarMenuLicensed').remove();
    }
    const menuItens = [
        {
            label: 'Consultores',
            icon: 'heroicon-users',
            route: '/consultants'
        },
        {
            label: 'Clientes',
            icon: 'heroicon-users',
            route: '/clients'
        },
        {
            label: 'Agentes',
            icon: 'heroicon-users',
            route: '/agents'
        }
    ]

    const menu = [$('<li />').append($('<h6 />', { class: 'nav-heading' }).html(`<h5>${licensed.name}</h5>`))];
    $('#sidebarMenu .sidebar-inner').append(
        $('<ul />', { class: 'nav flex-column pt-3 pt-md-0 mt-3' }).append(
            (() => {
                menuItens.forEach(item => {
                    menu.push(
                        $('<li />', { class: 'nav-item' }).append(
                            $('<a />', { class: 'nav-link', href: item.route }).append(
                                $('<i />', { class: `heroicon ${item.icon} float-start me-2` }),
                                item.label
                            )
                        )
                    );
                });
                return menu;
            })()
        ).prop({ id: 'sidebarMenuLicensed' })
    );

    $('#sidebarMenu').on('click', '#sidebarMenuLicensed a', function (e) {
        e.preventDefault();
        $('#sidebarMenu ul li, #sidebarMenuLicensed ul li').removeClass('active');
        $(this).parent().addClass('active');
        fetch($(this).attr('href'), {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json'
            },
            credentials: 'include'
        })
            .then(response => {
                if (response.status === 200) {
                    return response.text();
                }
                else if (response.status === 404) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Página não encontrada!',
                        text: "A página que você tentou acessar não foi encontrada.",
                    });
                }
                else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Erro ao tentar acessar a página!',
                        text: "Ocorreu um erro interno ao tentar acessar a página.",
                    });
                }
            })
            .then(html => {
                $('#app-content').html(html);
            })
    })
}