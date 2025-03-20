@push('scripts')
<x-script path="{{module_path('access-control','resources/js/register.js')}}" />
@endpush
<x-public-body>
    <div class="bg-body-tertiary min-vh-100 d-flex flex-row align-items-center">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card mb-4 mx-4">
                        <div class="card-body p-4">
                            <h1>Registro</h1>
                            <p class="text-body-secondary">Crie sua conta</p>
                            <form id="form-register" method="post" action="/api/v1/register">
                                <div class="input-group mb-3"><span class="input-group-text">
                                        <svg class="icon">
                                            <use xlink:href="vendors/coreui/icons/svg/free.svg#cil-user"></use>
                                        </svg></span>
                                    <input class="form-control" type="text" name="name" placeholder="Seu nome">
                                </div>
                                <div class="input-group mb-3"><span class="input-group-text">
                                        <svg class="icon">
                                            <use xlink:href="vendors/coreui/icons/svg/free.svg#cil-envelope-open"></use>
                                        </svg></span>
                                    <input class="form-control" type="text" name="email" placeholder="Email">
                                </div>
                                <div class="input-group mb-3"><span class="input-group-text">
                                        <svg class="icon">
                                            <use xlink:href="vendors/coreui/icons/svg/free.svg#cil-lock-locked"></use>
                                        </svg></span>
                                    <input class="form-control" type="password" name="password" placeholder="Senha">
                                </div>
                                <div class="input-group mb-4"><span class="input-group-text">
                                        <svg class="icon">
                                            <use xlink:href="vendors/coreui/icons/svg/free.svg#cil-lock-locked"></use>
                                        </svg></span>
                                    <input class="form-control" type="password" name="password_confirmation" placeholder="Repita a senha">
                                </div>
                                <button class="btn btn-block btn-success" type="submit">Criar conta</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-success" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="successModalLabel">Confirmação de registro</h5>
                    <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="fs-4 fw-semibold text-success mb2"><i class="icon icon-xxl cil-check"></i> Registro efetuado com sucesso!</div>
                    <p>Um e-mail de confirmação foi enviado para o endereço informado. Acesse o link para ativar sua conta.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-coreui-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>

</x-public-body>
