<!DOCTYPE html>
<!--
* CoreUI - Free Bootstrap Admin Template
* @version v5.1.1
* @link https://coreui.io/product/free-bootstrap-admin-template/
* Copyright (c) 2024 creativeLabs Łukasz Holeczek
* Licensed under MIT (https://github.com/coreui/coreui-free-bootstrap-admin-template/blob/main/LICENSE)
-->
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <base href="./">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="description" content="{{config('app.name')}}">
    <meta name="author" content="Łukasz Holeczek">
    <meta name="keyword" content="contabilidade">
    <title>{{config('app.name')}}</title>
    <link rel="apple-touch-icon" sizes="57x57" href="assets/favicon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="assets/favicon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="assets/favicon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="assets/favicon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="assets/favicon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="assets/favicon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="assets/favicon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="assets/favicon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="assets/favicon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192" href="assets/favicon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="assets/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="assets/favicon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/favicon/favicon-16x16.png">
    <link rel="manifest" href="assets/favicon/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="assets/favicon/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    <!-- Vendors styles-->
    <link rel="stylesheet" href="/vendors/simplebar/css/simplebar.css">
    <link rel="stylesheet" href="/css/simplebar.css">
    <link rel="stylesheet" href="/vendors/coreui/icons/css/free.min.css">
    <!-- Main styles for this application-->
    <link href="css/style.css" rel="stylesheet">
    <script>
        (() => {
            const THEME = 'coreui-free-bootstrap-admin-template-theme';
            const theme = '{{ Auth::check() ? Auth::user()->getAttribute("atributos")["default_theme"] : "light" }}'
            if (['auto', 'dark', 'light'].includes(theme)) {
                localStorage.setItem(THEME, theme);
            }
        })();

    </script>
    <script src="/js/color-modes.js"></script>
</head>
<body>
    <div id="loader" class="d-flex justify-content-center align-items-center" style="height: 100vh;">
        <div class="spinner-grow" style="width: 3rem; height: 3rem;" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
    {{$slot}}
    <span data-coreui-theme-value="">
        <svg class="icon icon-lg me-3">
            <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-sun"></use>
        </svg>Light
    </span>
    <!-- CoreUI and necessary plugins-->
    <script src="/vendors/coreui/coreui/js/coreui.bundle.min.js"></script>
    <script src="/vendors/simplebar/js/simplebar.min.js"></script>
    <script src="/js/jquery-3.7.1.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#loader').removeClass('d-flex').addClass('d-none');
        });

    </script>
    @stack('scripts')
</body>
</html>
