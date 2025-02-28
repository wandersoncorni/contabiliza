<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>{{config('app.name')}}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="title" content="{{config('app.name')}}" />
    <meta name="author" content="{{config('app.author')}}" />
    <meta name="description" content="{{config('app.descricao')}}" />
    <meta name="keywords" content="{{config('app.author')}}" />
    <link rel="icon" href="/img/elattes.ico" type="favico" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.10.1/styles/overlayscrollbars.min.css" integrity="sha256-tZHrRjVqNSRyWg2wbppGnT833E/Ys0DHWGwT04GiqQg=" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" integrity="sha256-9kPW/n5nn53j4WMRYAxe9c1rCY96Oogo/MKSVdKzPmI=" crossorigin="anonymous" />
    <link rel="stylesheet" href="/css/adminlte.css" />
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    @stack('stylesheet')
    @stack('style')

</head>
<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <div class="app-wrapper">
        <nav class="app-header navbar navbar-expand bg-body">
            <div class="container-fluid">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                            <i class="bi bi-list"></i>
                        </a>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto">                    
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-lte-toggle="fullscreen">
                            <i data-lte-icon="maximize" class="bi bi-arrows-fullscreen"></i>
                            <i data-lte-icon="minimize" class="bi bi-fullscreen-exit" style="display: none"></i>
                        </a>
                    </li>
                    <li class="nav-item dropdown user-menu">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <img src="/img/avatars/default-profile.png" class="user-image rounded-circle shadow" alt="User Image" />
                            <span class="d-none d-md-inline">{{Auth::user()->name ?? ''}}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                            <li class="user-header text-bg-light">
                                <img src="/img/avatars/default-profile.png" class="rounded-circle shadow" alt="User Image" />
                                <p>
                                    {{Auth::user()->name ?? ''}}
                                    <small>Membro desde </small>
                                </p>
                            </li>
                            <li class="user-footer">
                                <a href="#" class="btn btn-default btn-flat">Perfil</a>
                                <a href="#" class="btn btn-default btn-flat float-end">Sair</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
        <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
            <div class="sidebar-brand">
                <a href="./index.html" class="brand-link">
                    <img src="/img/icon-elattes.png" alt="E-lattes" class="brand-image opacity-75 shadow mr-3" />
                    <span class="brand-text fw-light">{{config('app.name')}}</span>
                </a>
            </div>
            <div class="sidebar-wrapper">
                <nav class="mt-2">
                    <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">
                        <li class="nav-item">
                            <a href="#" class="nav-link active" data-lte-target="analises" id="analises-item">
                                <i class="nav-icon bi bi-activity"></i>
                                <p>Análises</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" data-lte-target="analise" class="nav-link" id="analise-item">
                                <i class="nav-icon bi bi-folder-plus"></i>
                                <p>Nova Análise</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" data-lte-target="config" class="nav-link" id="config-item">
                                <i class="nav-icon bi bi-tools"></i>
                                <p>Configurações</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" data-lte-target="extrator" class="nav-link" id="extrator-item">
                                <i class="nav-icon bi bi-layers"></i>
                                <p>Extrator Lattes</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" data-lte-target="usuario" class="nav-link" id="usuario-item">
                                <i class="nav-icon bi bi-people"></i>
                                <p>Usuários</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" data-lte-target="logs" class="nav-link" id="logs-item">
                                <i class="nav-icon bi bi-card-checklist"></i>
                                <p>Logs da aplicação</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="https://ajuda.elattes.com.br" class="nav-link">
                                <i class="nav-icon bi bi-question-octagon"></i>
                                <p>Ajuda</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/logout" class="nav-link">
                                <i class="nav-icon bi bi-door-open"></i>
                                <p>Sair</p>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>
        <main class="app-main">
            <div class="app-content-header bg-light bg-gradient">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            <h3 class="mb-0">Dashboard</h3>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-end">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="app-content">
                <div class="container-fluid">
                    {{$slot??''}}
                </div>
            </div>
        </main>
        <footer class="app-footer">
            <strong>
                Copyright &copy; 2014-2024&nbsp;
                <a href="https://adminlte.io" class="text-decoration-none">AdminLTE.io</a>.
            </strong>
            All rights reserved.
        </footer>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.10.1/browser/overlayscrollbars.browser.es6.min.js" integrity="sha256-dghWARbRe2eLlIJ56wNB+b760ywulqK3DzZYEpsg2fQ=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <script src="/js/adminlte.min.js"></script>
    <script src="{{ mix('js/app.js') }}"></script>
    @stack('script_src')
    <script>
        const SELECTOR_SIDEBAR_WRAPPER = '.sidebar-wrapper';
        const Default = {
            scrollbarTheme: 'os-theme-light'
            , scrollbarAutoHide: 'leave'
            , scrollbarClickScroll: true
        , };
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarWrapper = document.querySelector(SELECTOR_SIDEBAR_WRAPPER);
            if (sidebarWrapper && typeof OverlayScrollbarsGlobal?.OverlayScrollbars !== 'undefined') {
                OverlayScrollbarsGlobal.OverlayScrollbars(sidebarWrapper, {
                    scrollbars: {
                        theme: Default.scrollbarTheme
                        , autoHide: Default.scrollbarAutoHide
                        , clickScroll: Default.scrollbarClickScroll
                    , }
                , });
            }
            //Pega os itens do menu
            const menuItems = document.querySelectorAll('.sidebar-menu .nav-link');
            // Pegar todas as divisões de conteúdo
            const contentDivs = document.querySelectorAll('#appTabContent > .tab-pane');
            menuItems.forEach(item => {
                item.addEventListener('click', function (event) {
                    event.preventDefault();                    
                    // Remover a classe 'active' de todos os itens do menu
                    menuItems.forEach(link => link.classList.remove('active'));                    
                    // Adicionar a classe 'active' ao item clicado
                    item.classList.add('active');                    
                    // Esconder todos os conteúdos
                    contentDivs.forEach(content => content.classList.remove('show','active'));                    
                    // Mostrar o conteúdo associado ao item clicado
                    const targetId = item.getAttribute('data-lte-target');
                    const targetContent = document.getElementById(targetId);
                    if (targetContent) {
                        targetContent.classList.add('show','active');
                    }
                });
            });
        });
        /*
         * Traducao idioma portugues
         */
        const pt_BR = {
            placeholder: "Buscar...",
            searchTitle: "Buscar dentro da tabela.",
            pageTitle: "Página {page}",
            perPage: "entradas por página.",
            noRows: "Nenhum registro encontrado.",
            info: "Exibindo {start} até {end} de {rows} registro(s).",
            noResults: "Nenhum resultado corresponde à sua consulta de pesquisa.",
        }

    </script>    
    @stack('script_text')
</body>
</html>
