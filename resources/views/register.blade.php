@push('modal-footer')
<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
@endpush
<x-public-layout>
    <div class="register-page">
        <div class="register-box">
            <!-- /.register-logo -->
            <div class="card">
                <div class="card-header bg-secondary bg-gradient">
                    <img src="/img/logo-elattes.png" alt="E-lattes" class="img-fluid" />
                    <img src="/img/fiocruz-branco-44.png" alt="E-lattes" class="img-fluid float-end" />
                </div>
                <div class="card-body register-card-body">
                    <p class="register-box-msg h2">Registre-se!</p>
                    <form action="/register" method="post" id="register-form">
                        <div class="input-group mb-3">
                            <div class="form-floating">
                                <input id="registerFullName" type="text" class="form-control" name="name" placeholder="Seu nome" />
                                <label for="registerFullName">Nome</label>
                            </div>
                            <div class="input-group-text"><span class="bi bi-person"></span></div>
                        </div>
                        <div class="input-group mb-3">
                            <div class="form-floating">
                                <input id="registerEmail" type="text" class="form-control" name="email" placeholder="Seu email" />
                                <label for="registerEmail">Email</label>
                            </div>
                            <div class="input-group-text"><span class="bi bi-envelope"></span></div>
                        </div>
                        <div class="input-group mb-3">
                            <div class="form-floating">
                                <input id="registerCompany" type="text" class="form-control" name="company" placeholder="Instituição a que pertence" />
                                <label for="registerCompany">Instituição</label>
                            </div>
                            <div class="input-group-text"><span class="bi bi-buildings"></span></div>
                        </div>
                        <div class="input-group mb-3">
                            <div class="form-floating">
                                <input id="registerPassword" type="password" class="form-control" name="password" placeholder="Senha" />
                                <label for="registerPassword">Senha</label>
                            </div>
                            <div class="input-group-text"><span class="bi bi-lock-fill"></span></div>
                        </div>
                        <div class="input-group mb-3">
                            <div class="form-floating">
                                <input id="registerPassword" type="password" class="form-control" name="password_confirmation" placeholder="Confirme a senha" />
                                <label for="registerPassword">Confirmação da senha</label>
                            </div>
                            <div class="input-group-text"><span class="bi bi-lock-fill"></span></div>
                        </div>
                        <!--begin::Row-->
                        <div class="row">
                            <div class="col-8 d-inline-flex align-items-center">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" />
                                    <label class="form-check-label" for="flexCheckDefault">
                                        Concordo com os <a href="#">termos</a>
                                    </label>
                                </div>
                            </div>
                            <!-- /.col -->
                            <div class="col-4">
                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-primary">Enviar</button>
                                </div>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!--end::Row-->
                        @csrf
                    </form>

                    <p class="mb-0">
                        <a href="/login" class="link-primary text-center"> Já possuo uma conta.</a>
                    </p>
                </div>
                <!-- /.register-card-body -->
            </div>
        </div>
    </div>
    <x-modal id="registerModal" title="Confirmação de registro">
        <h3 class="text-success">
            <x-icon type="check-circle-fill" />
            Cadastro efetuado com sucesso!
        </h3>
        <p>Você recebeu um email com as instruções para ativar sua conta.
            Caso contrário, informe o administrador do sistema.</p>

    </x-modal>
</x-public-layout>
