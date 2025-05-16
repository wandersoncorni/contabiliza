<?php
$userImage = 'data:image/svg+xml,<svg data-slot="icon" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6ZM3.465 14.493a1.23 1.23 0 0 0 .41 1.412A9.957 9.957 0 0 0 10 18c2.31 0 4.438-.784 6.131-2.1.43-.333.604-.903.408-1.41a7.002 7.002 0 0 0-13.074.003Z"></path></svg>';
?>
@extends('layout')
@push('styles')
<link rel="stylesheet" href="/vendor/datatables/datatables.min.css">
@endpush
@push('scripts')
    <script src="/vendor/jquery/jquery.min.js"></script>
    <script src="/vendor/datatables/datatables.min.js"></script>
    <script src="/js/app.js"></script>
    <script>
    fetch('/vendor/datatables/pt-BR.json')
    .then(res => res.json())
    .then(res => {
        $.extend(true, $.fn.dataTable.defaults, {
            language: res
        });
    });
    </script>
    <script src="/js/{{Auth::user()->person->roles[0]}}.js"></script>
@endpush
@section('content')
<nav class="navbar navbar-dark navbar-theme-primary px-4 col-12 d-lg-none">
    <a class="navbar-brand me-lg-5" href="/">
        <img class="navbar-brand-dark" src="/img/logo3.png" alt="ContabilizaTech" />
    </a>
    <div class="d-flex align-items-center">
        <button class="navbar-toggler d-lg-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    </div>
</nav>
@include('partials.sidebar')
<main class="content">
    @include('partials.navbar-top')
    <div class="mt-4" id="app-content"></div>    
</main>
@endsection
