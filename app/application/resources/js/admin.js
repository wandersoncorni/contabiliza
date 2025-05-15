
/**
 * Cria o menu de gestao para os licenciados
 */
globalThis.buildLicensedMenu = function () {
    const licensed = JSON.parse(sessionStorage.getItem('licensed_context'));
    if($('#sidebarMenuLicensed').length > 0){
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
            (()=>{
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
        ).prop({id: 'sidebarMenuLicensed'})
    );
}

$(document).ready(function () {
    if(sessionStorage.getItem('licensed_context') !== null){
        buildLicensedMenu();
    }

    $('#sidebarMenu').on('click','#sidebarMenuLicensed a', function (e) {
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
            else if(response.status === 404){
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
});

globalThis.loadUsersTable = function (selector, url) {
    alert('')
}