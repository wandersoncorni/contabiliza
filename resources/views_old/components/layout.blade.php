<?php
use Illuminate\Support\Facades\Auth;
?>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <base href="./">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="description" content="CoreUI - Open Source Bootstrap Admin Template">
    <meta name="author" content="Łukasz Holeczek">
    <meta name="keyword" content="Bootstrap,Admin,Template,Open,Source,jQuery,CSS,HTML,RWD,Dashboard">
    <title>{{ config('app.name') }}</title>
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="assets/favicon/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    <!-- Vendors styles-->
    @component('components.tag-link',['file'=>'css/simplebar.css'])
    @component('components.tag-link',['file'=>'css/style.min.css'])
    @endcomponent
    @component('components.tag-script',['file'=>'js/color-modes.js'])
    @endcomponent
    @component('components.tag-link',['file'=>'/css/app.css'])
    @endcomponent

    <link rel="stylesheet" href="/vendors/coreui/icons/css/free.min.css">
    @stack('styles')

    <script>
        const header = document.querySelector('header.header');
        document.addEventListener('scroll', () => {
            if (header) {
                header.classList.toggle('shadow-sm', document.documentElement.scrollTop > 0);
            }
        });
        (() => {
            const THEME = 'coreui-free-bootstrap-admin-template-theme';
            const theme = '{{ Auth::check() ? Auth::user()->getAttribute("atributos")["default_theme"] : "light" }}'
            if (['auto', 'dark', 'light'].includes(theme)) {
                localStorage.setItem(THEME, theme);
            }
        })();

    </script>
</head>
<html>
<body>
    {{ $slot }}
    <script src="/js/jquery-3.7.1.min.js"></script>
    <script>
        $(function() {
            $.ajaxSetup({
                complete: function(res) {
                    if (res.status == 401) {
                        window.location.replace(`http://${location.host}/login`);
                    }
                }
            });
        });

    </script>
    @stack('scripts')
</body>
</html>
