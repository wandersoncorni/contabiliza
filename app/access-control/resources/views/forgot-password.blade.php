@extends('layout')
@push('scripts')
    <script src="{{ asset('js/forgot-password.js') }}"></script>
@endpush
@section('content')
<main>
    <section class="vh-lg-100 mt-5 mt-lg-0 bg-soft d-flex align-items-center">
        <div class="container">
            <div class="row justify-content-center form-bg-image">
                <div class="col-12 d-flex align-items-center justify-content-center">
                    <div class="signin-inner my-3 my-lg-0 bg-white shadow border-0 rounded p-4 p-lg-5 w-100 fmxw-500">
                        <div class="text-center text-md-center mb-4 mt-md-0">
                            <x-logo />
                        </div>
                        <h1 class="h3">Esqueceu a senha?</h1>
                        <p class="mb-4">Não se precupe! Informe o seu email e vamos lhe enviar um link para redefinir sua senha!</p>
                        <form action="#" id="formForgotPassword">
                            <!-- Form -->
                            <div class="mb-4">
                                <label for="email">Seu email</label>
                                <div class="input-group">
                                    <input type="email" class="form-control" id="email" placeholder="email@company.com" required autofocus>
                                </div>
                            </div>
                            <!-- End of Form -->
                            <div class="d-grid text-center">
                                <button type="submit" class="btn btn-gray-800">Recuperar acesso</button>
                                ou
                                <a href="{{ url('login') }}" class="d-inline-flex align-items-center justify-content-center mb-4">
                                    <svg class="icon icon-xs me-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M7.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l2.293 2.293a1 1 0 010 1.414z" clip-rule="evenodd"></path>
                                    </svg>
                                    Voltar para o login
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main @endsection
