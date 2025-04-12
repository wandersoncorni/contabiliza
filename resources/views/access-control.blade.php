@extends('layout')
@push('styles_href')
<link href="{{ asset('/vendor/sweetalert2/dist/sweetalert2.min.css') }}" rel="stylesheet">
@endpush
@push('scripts_src')
<script src="{{ asset('/vendor/sweetalert2/dist/sweetalert2.all.min.js') }}"></script>
<script src="{{ asset('/vendor/smooth-scroll/dist/smooth-scroll.polyfills.min.js') }}"></script>
@endpush
@section('content')
<main>
    @yield('main')
</main>
@endsection
