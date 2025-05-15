/**
 * Scripts para pagina padrao do sistema
 */
export function init() {
    // Inicializa o smooth scroll
    const scroll = new SmoothScroll('a[href*="#"]', {
        speed: 300,
        speedAsDuration: true,
        offset: 0,
        updateURL: false,
        popstate: false,
        emitEvents: true
    });
    /**
     * Função para gerar o menu
     * @param {Array} menuData - Array de objetos com os dados do menu
     */
    function generateMenu(menuItens) {
        const menuContainer = document.querySelector("#sidebarMenu");
        menuItens.forEach(item => {
            const menuItem = document.createElement("li");
            menuItem.classList.add("nav-item");

            const link = document.createElement("a");
            link.classList.add("nav-link");
            link.href = item.route ? `${item.route}` : item.link;
            link.target = item.link ? "_blank" : '_self';

            const spanIcon = document.createElement("span");
            spanIcon.classList.add("sidebar-icon");
            spanIcon.innerHTML = `<i class="heroicon ${item.icon} float-start"></i>`;

            const spanText = document.createElement("span");
            spanText.classList.add("sidebar-text");
            spanText.innerHTML = item.label;

            link.appendChild(spanIcon);
            link.appendChild(spanText);

            menuItem.appendChild(link);
            menuContainer.appendChild(menuItem);
        });
        document.querySelector("#sidebarMenu .nav-item:first-child").classList.add("active");
        if (localStorage.getItem("sidebarMenuItem") === null) {
            localStorage.setItem("sidebarMenuItem", document.querySelector("#sidebarMenu .nav-item.active a").getAttribute("href"));
        }
    }
    generateMenu(menuItens);
    /**
     * Impelementa o logout
     */
    document.querySelectorAll(".btn-logout").forEach((logout) => logout.addEventListener("click", (e) => {
        e.preventDefault;
        fetch('/api/v1/logout', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'XSRF-TOKEN': sessionStorage.getItem('XSRF-TOKEN')
            },
            credentials: 'include'
        })
            .then(response => {
                window.location.href = '/';
            });
    }));

    document.querySelectorAll('.dashboard-dropdown a, #sidebarMenu a.nav-link').forEach((item) => item.addEventListener('click', (e) => {
        e.preventDefault();
        const target = e.target.closest('a');
        if(target.href != sessionStorage.getItem('history')){
            sessionStorage.setItem('history', target.href);
            loadContent(sessionStorage.getItem('history'));
        }
    }));

    loadContent(sessionStorage.getItem('history') ?? window.location.href+'painel');

    // Interceptando fetch API
    const originalFetch = window.fetch;
    const Loader = loader();
    window.fetch = async (...args) => {
        Loader.show();
        try {
            const response = await originalFetch(...args);
            return response;
        } finally {
            Loader.hide();
        }
    };
};

async function loadContent(url, container = "#app-content") {
    try {
        const dest = new URL(url);
        if(dest.pathname == '/'){
            url += 'painel';
        }
        const response = await fetch(url).then((response)=>{
            return response;
        });
        if (!response.ok) {
            Swal.fire({
                icon: 'error',
                title: 'Erro',
                text: "Ops! Ocorreu um erro.",
            });
            sessionStorage.setItem('history',`https://${window.location.host}/painel`)
            throw new Error('Erro ao buscar os dados');
        }
        document.querySelector(container).innerHTML = await response.text();
        const textScript = document.querySelector(container).querySelector('script');
        if(textScript){
            const script = document.createElement('script');
            script.innerHTML = textScript.innerHTML;
            document.querySelector('body').append(script);
            document.querySelector(container).querySelector('script').remove();
        }
        
    } catch (erro) {
        console.log('Erro no fetch:', erro);
    }
}

let activeRequests = 0;
export function loader() {
    const loader = document.querySelector("#loader");    
    return {
        show: () => {
            activeRequests++;
            loader.classList.add("active");
        },
        hide: () => {
            activeRequests = Math.max(0, activeRequests - 1);
            if (activeRequests === 0) {
                loader.classList.remove("active");
            }
        }
    }
}