/**
 * Scripts para pagina padrao do sistema
 */
export function init() {
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
        $('#sidebarMenu ul li').removeClass('active');
        $(this).parent().addClass('active');
        sessionStorage.setItem("sidebarMenuItem", $(this).attr('href'));
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
        })
        .then(html => {
            $('#app-content').html(html);
            $('#app-content').find('script').each(function () {
                const src = $(this).attr('src');
                $(this).remove();
                if (!$(`script[src="${src}"]`).length) {
                    const newScript = document.createElement('script');
                    newScript.src = src;
                    newScript.type = 'text/javascript';
                    newScript.async = false;
                    document.body.appendChild(newScript);
                }
            });
        })
    });
    $(`#sidebarMenu ul li a[href="${sessionStorage.getItem("sidebarMenuItem") ?? "/painel"}"]`).trigger('click');
    // Implementa o evento de clique para o botão de logout
    $(".btn-logout").on("click", function (e) {
        e.preventDefault();
        fetch('/api/v1/logout', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            credentials: 'include'
        })
        .then(response => {
            window.location.href = '/';
        });
    });
};