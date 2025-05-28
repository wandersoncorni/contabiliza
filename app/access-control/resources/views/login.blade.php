@extends('access-control')
@push('scripts')    
<script src="{{ asset('js/login.js') }}"></script>
@endpush
@section('main')
<section class="vh-100 mt-lg-0 bg-soft d-flex align-items-center">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 d-flex align-items-center justify-content-center">
                <div class="bg-white shadow border-0 rounded border-light p-4 p-lg-5 w-100 fmxw-500">
                    <div class="text-center text-md-center mb-4 mt-md-0">
                        <x-logo />
                        <h1 class="mt-5 mb-0 h3">Autentique-se</h1>
                    </div>
                    <form action="#" class="mt-4" id="login-form">
                        <!-- Form -->
                        <div class="form-group mb-4">
                            <label for="email">Seu email</label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1">
                                    <svg class="icon icon-xs text-gray-600" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
                                        <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                                    </svg>
                                </span>
                                <input type="email" class="form-control" placeholder="email@company.com" id="email" name="email" autofocus required autocomplete="off">
                            </div>
                        </div>
                        <!-- End of Form -->
                        <div class="form-group">
                            <!-- Form -->
                            <div class="form-group mb-4">
                                <label for="password">Sua senha</label>
                                <div class="input-group">
                                    <span class="input-group-text" id="basic-addon2">
                                        <svg class="icon icon-xs text-gray-600" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                                        </svg>
                                    </span>
                                    <input type="password" placeholder="Senha" class="form-control" id="password" name="password" required autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group mb-4">
                                <label for="show_password">
                                    <input type="checkbox" id="show_password" class="form-check-input">
                                    Mostrar senha
                                </label>
                            </div>
                            <!-- End of Form -->
                            <div class="d-flex justify-content-between align-items-top mb-4">
                                <div><a href="{{ route('register.view') }}" class="fw-bold">Registre-se</a></div>

                                <div><a href="{{ route('forgot-password.view') }}" class="small text-right">Esqueceu a senha?</a></div>
                            </div>
                        </div>
                        @csrf
                        <div class="d-grid">
                            <button type="submit" id="submit" class="btn btn-gray-800">Enviar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
