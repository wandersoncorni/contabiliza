<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <title>{{config('app.name')}}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="title" content="{{config('app.name')}}">
    <meta name="author" content="{{config('app.author')}}">
    <meta name="description" content="{{config('app.descricao')}}">
    <meta name="keywords" content="{{config('app.keywords')}}" />

    <link rel="icon" href="/favicon.png" type="favico" />
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="theme-color" content="#ffffff">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <link href="{{ asset('/vendor/sweetalert2/dist/sweetalert2.min.css') }}" rel="stylesheet">
    @stack('styles_href')
    <link type="text/css" href="{{ asset('css/volt.css') }}" rel="stylesheet">
    <link type="text/css" href="{{ asset('css/layout.css') }}" rel="stylesheet">
    <link type="text/css" href="{{ asset('css/heroicons.css') }}" rel="stylesheet">
    @stack('styles')
    <style>
        /* Estilos do Loader */
        .loader-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(255, 255, 255, 0.8);
            display: flex;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(5px);
            z-index: 1050;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s ease-in-out, visibility 0.3s ease-in-out;
        }

        .loader-overlay.active {
            opacity: 0.8;
            visibility: visible;
        }

        .loader-spinner {
            width: 3rem;
            height: 3rem;
            border: 4px solid #0d6efd;
            border-top: 4px solid transparent;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        .loader {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            display: inline-block;
            border-top: 4px solid #1a2cc4;
            border-right: 4px solid transparent;
            box-sizing: border-box;
            animation: rotation 1s linear infinite;
        }

        .loader::after {
            content: '';
            box-sizing: border-box;
            position: absolute;
            left: 0;
            top: 0;
            width: 48px;
            height: 48px;
            border-radius: 50%;
            border-bottom: 4px solid #fa146e;
            border-left: 4px solid transparent;
        }

        @keyframes rotation {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

    </style>
</head>
<body>
    <div id="loader" class="loader-overlay active">
        <div class="loader"></div>
    </div>
    @yield('content')
    <script src="{{ asset('/vendor/@popperjs/core/dist/umd/popper.min.js')}}"></script>
    <script src="{{ asset('/vendor/bootstrap/dist/js/bootstrap.min.js')}}"></script>
    <script src="{{ asset('/vendor/smooth-scroll/dist/smooth-scroll.polyfills.min.js')}}"></script>
    <script src="{{ asset('/vendor/smooth-scroll/dist/smooth-scroll.min.js')}}"></script>
    <script src="{{ asset('/vendor/sweetalert2/dist/sweetalert2.all.min.js') }}"></script>   
    <script src="{{ asset('js/volt.js') }}"></script>
     @stack('scripts_src')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const loader = document.getElementById("loader");
            loader.classList.remove("active");
        });
        class Loader {
            constructor() {
                this.loader = document.querySelector("#loader");
                this.activeRequests = 0;
            }

            show() {
                this.activeRequests++;
                this.loader.classList.add("active");
            }

            hide() {
                this.activeRequests = Math.max(0, this.activeRequests - 1);
                if (this.activeRequests === 0) {
                    this.loader.classList.remove("active");
                }
            }
        }

        const loader = new Loader();      

        // Interceptando fetch API
        const originalFetch = window.fetch;
        window.fetch = async (...args) => {
            loader.show();
            try {
                const response = await originalFetch(...args);
                return response;
            } finally {
                loader.hide();
            }
        };
    </script>
    @stack('scripts')
</body>

</html>
