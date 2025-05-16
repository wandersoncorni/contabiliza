$(document).ready(function () {
    const scroll = new SmoothScroll('a[href*="#"]', {
        speed: 300,
        speedAsDuration: true,
        offset: 0,
        updateURL: false,
        popstate: false,
        emitEvents: true
    });
    menuItens.forEach(item => {
        $('#sidebarMenu ul').append(
            $('<li />', { class: 'nav-item' }).append(
                $('<a />', { class: 'nav-link', href: item.route ?? item.link }).append([
                    $('<i />', { class: `heroicon ${item.icon} float-start me-2` }),
                    item.label
                ])
            )
        )
    });
    $('#sidebarMenu ul li a').on('click', function (e) {
        e.preventDefault();
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
                else if (response.status === 403) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Acesso negado!',
                        text: "Não possui permissão para acessar essa página.",
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
                $('#sidebarMenu ul li').removeClass('active');
                $(this).parent().addClass('active');
                sessionStorage.setItem("sidebarMenuItem", $(this).attr('href'));
                $('#app-content').html(html);

                const event = new CustomEvent('page:loaded', {
                    detail: {
                        url: $(this).attr('href')
                    }
                });
                document.dispatchEvent(event);
            })
    });
    $(`#sidebarMenu ul li a[href="${sessionStorage.getItem("sidebarMenuItem") ?? "/painel"}"]`).trigger('click');
    // Implementa o evento de clique para o botão de logout
    $(".btn-logout").on("click", function (e) {
        e.preventDefault();
        fetch('/api/v1/logout', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            credentials: 'include'
        })
            .then(response => {
                window.location.href = '/';
            });
    });

    const sessionTime = 15 * 60 * 1000;
    let inativeTime = 0;
    ['click', 'mousemove', 'keydown', 'scroll', 'touchstart'].forEach(event => {
        $('body').on(event, function (e) {
            inativeTime = 0;
        });
    });

    setInterval(() => {
        inativeTime += 1000;
        if (inativeTime >= sessionTime) {
            window.location.reload();
        }
    }, 1000);
});
/**
 * Constroi as tabelas de susuarios para os modulos de consultores, clientes e agentes
 * @param {string} container 
 * @param {string} url 
 * @returns 
 */
globalThis.loadUsersTable = function (container, url) {
    return new DataTable(container, {
        ajax: function (data, callback, settings) {
            fetch(url, {
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
            {
                data: (data) => {
                    return $('<div />', { class: 'd-flex' }).append([
                        $('<img />', { class: 'rounded-circle avatar bg-light me-3', src: data.person.photo ?? '/img/user.png' }),
                        $('<div />').append([
                            $('<h1 />', { class: 'h5 mb-0 font-size-14' }).text(data.person.name),
                            $('<p />', { class: 'text-muted font-size-12 mb-0' }).append(
                                $('<i />', { class: 'heroicon heroicon-envelope mt-1 me-1 float-start' }),
                                data.email
                            ),
                        ]),
                    ]).prop('outerHTML');
                }
            },
            { data: (data) => data.active ? $('<span />', { class: 'text-success' }).text('Ativo').prop('outerHTML') : $('<span />', { class: 'text-danger' }).text('Inativo').prop('outerHTML') },
            {
                data: (data) => new Date(data.created_at).toLocaleDateString('pt-BR', {
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
            { targets: [0], orderable: false },
            { targets: [0, 1], searchable: false },
        ],
    });
}