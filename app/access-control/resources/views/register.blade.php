@extends('access-control')
@push('styles')
<style>
    .valid {
        color: green;
    }

    .invalid {
        color: red;
    }

    .list-unstyled i {
        float: left;
        margin-top: -1px;
    }

</style>
@endpush
@push('scripts')
<script src="js/register.js"></script>
@endpush
@section('main')
<section class="vh-lg-100 mt-5 mt-lg-0 bg-soft d-flex align-items-center">
    <div class="container">
        <div class="row justify-content-center form-bg-image" data-background-lg="{{ asset('/img/illustrations/signin.svg') }}">
            <div class="col-12 d-flex align-items-center justify-content-center">
                <div class="bg-white shadow border-0 rounded border-light p-4 p-lg-5 w-100 fmxw-500">
                    <div class="text-center text-md-center mb-4 mt-md-0">
                        <x-logo />
                        <h1 class="mt-3 mb-0 h3">Crie sua conta</h1>
                    </div>
                    <form action="#" class="mt-4" id="register-form">
                        @csrf
                        <div class="form-group mb-4">
                            <label for="name">Nome</label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1">
                                    <svg class="icon icon-xs text-gray-600" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
                                        <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                                    </svg>
                                </span>
                                <input type="text" class="form-control" placeholder="Seu nome" id="name" name="name" autofocus required>
                            </div>
                        </div>
                        <!-- Form -->
                        <div class="form-group mb-4">
                            <label for="email">Email</label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1">
                                    <svg class="icon icon-xs text-gray-600" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
                                        <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                                    </svg>
                                </span>
                                <input type="email" class="form-control" placeholder="example@company.com" id="email" name="email" required autocomplete="off" />
                            </div>
                        </div>
                        <!-- End of Form -->
                        <div class="form-group">
                            <!-- Form -->
                            <div class="form-group mb-4">
                                <label for="password">Senha</label>
                                <div class="input-group">
                                    <span class="input-group-text" id="basic-addon2">
                                        <svg class="icon icon-xs text-gray-600" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                                        </svg>
                                    </span>
                                    <input type="password" placeholder="Senha" class="form-control" id="password" name="password" required>
                                </div>
                            </div>
                            <!-- End of Form -->
                            <!-- Form -->
                            <div class="form-group mb-4">
                                <label for="confirm_password">Confirme a senha</label>
                                <div class="input-group">
                                    <span class="input-group-text" id="basic-addon2">
                                        <svg class="icon icon-xs text-gray-600" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                                        </svg>
                                    </span>
                                    <input type="password" placeholder="confirmação da senha" class="form-control" id="password_confirmation" name="password_confirmation" required>
                                </div>
                            </div>
                            <div class="form-group mb-4">
                                <label for="show_password">
                                    <input type="checkbox" id="show_password" class="form-check-input">
                                    Exibir senha
                                </label>
                            </div>
                            <div class="form-group mb-4">
                                <div class="form-text">A senha deve conter:</div>
                                <ul class="list-unstyled">
                                    <li id="length" class="invalid">
                                        <i class="heroicon heroicon-x"></i> Mínimo de 8 caracteres
                                    </li>
                                    <li id="uppercase" class="invalid">
                                        <i class="heroicon heroicon-x"></i> Pelo menos uma letra maiúscula
                                    </li>
                                    <li id="lowercase" class="invalid">
                                        <i class="heroicon heroicon-x"></i> Pelo menos uma letra minúscula
                                    </li>
                                    <li id="number" class="invalid">
                                        <i class="heroicon heroicon-x"></i> Pelo menos um número
                                    </li>
                                    <li id="special" class="invalid">
                                        <i class="heroicon heroicon-x"></i> Pelo menos um caractere especial (@, #, $, etc.)
                                    </li>
                                </ul>
                            </div>
                            <!-- End of Form -->
                            <div class="mb-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="concorde_termo" required>
                                    <label class="form-check-label fw-normal mb-0" for="concorde_termo">
                                        Eu concordo com <a href="{{asset('docs/termos_e_condicoes.pdf')}}" target="_blank" class="text-info" style="text-decoration: underline;"><b>termos e condições</i></b></a>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-gray-800">Enviar</button>
                        </div>
                    </form>
                    <div class="d-flex justify-content-center align-items-center mt-4">
                        <span class="fw-normal">
                            Já possui uma conta!
                            <a href="{{route('login')}}" class="fw-bold">Autentique-se aqui</a>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
