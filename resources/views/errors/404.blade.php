@extends('layout')
@section('content')
<main>
    <section class="vh-100 d-flex align-items-center justify-content-center">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center d-flex align-items-center justify-content-center">
                    <div>
                        <img class="img-fluid w-75" src="/img/illustrations/404.svg" alt="404 not found">
                        <h1 class="mt-5">Página não <span class="fw-bolder text-primary">encontrada</span></h1>
                        <p class="lead my-4">Oops! Parece que você se perdeu. Se você acha que isso é um erro, contate-nos.</p>
                        <a href="{{ url('/') }}" class="btn btn-gray-800 d-inline-flex align-items-center justify-content-center mb-4">
                            <svg class="icon icon-xs me-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M7.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l2.293 2.293a1 1 0 010 1.414z" clip-rule="evenodd"></path>
                            </svg>
                            Voltar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection
