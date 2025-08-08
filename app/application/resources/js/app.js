$(document).ready(function () {
    // Inicializa o smooth scroll
    const scroll = new SmoothScroll('a[href*="#"]', {
        speed: 300,
        speedAsDuration: true,
        offset: 0,
        updateURL: false,
        popstate: false,
        emitEvents: true
    });
    // Monta o menu lateral
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
    // Controle do menu lateral
    $('#sidebarMenu ul li a').on('click', function (e) {
        e.preventDefault();
        fetch($(this).attr('href'), {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json'
            },
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