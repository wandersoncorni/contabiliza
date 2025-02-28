<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>{{ config('app.name') }}</title>
    <!--begin::Primary Meta Tags-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="title" content="{{ config('app.name') }}" />
    <meta name="author" content="ColorlibHQ" />
    <meta name="description" content="Busca e analise de currículo lattes" />
    <meta name="keywords" content="curriculo lattes, fiocruz" />
    <link rel="icon" href="/img/elattes.ico" type="favico" />
    <!--end::Primary Meta Tags-->

    <!--begin::Third Party Plugin(OverlayScrollbars)-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.10.1/styles/overlayscrollbars.min.css" integrity="sha256-tZHrRjVqNSRyWg2wbppGnT833E/Ys0DHWGwT04GiqQg=" crossorigin="anonymous" />
    <!--end::Third Party Plugin(OverlayScrollbars)-->
    <!--begin::Third Party Plugin(Bootstrap Icons)-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" integrity="sha256-9kPW/n5nn53j4WMRYAxe9c1rCY96Oogo/MKSVdKzPmI=" crossorigin="anonymous" />
    <!--end::Third Party Plugin(Bootstrap Icons)-->
    <!--begin::Required Plugin(AdminLTE)-->
    <link rel="stylesheet" href="/css/adminlte.css" />
    <!--end::Required Plugin(AdminLTE)-->
    <script>
        window.onload = function() {
            const loader = document.querySelector('#loader');
            loader.classList.remove('d-flex');
            loader.classList.add('d-none');
        };

    </script>
</head>
<body>
    <div id="loader" class="d-flex justify-content-center align-items-center" style="height: 100vh;">
        <div class="spinner-grow" style="width: 3rem; height: 3rem;" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
    {{ $slot }}
    
    <script type="text/javascript" src="/js/adminlte.js"></script>
    <script type="text/javascript" src="/js/bootstrap-5.3.3.min.js"></script>
    <script src="{{ mix('js/public/app.js') }}"></script>
    @stack('scripts')
</body>
</html>
