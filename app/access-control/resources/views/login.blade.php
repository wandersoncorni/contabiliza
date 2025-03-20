@push('scripts')
<x-script path="{{module_path('access-control','resources/js/login.js')}}" />
@endpush
<x-public-body>
    <div class="bg-body-tertiary min-vh-100 d-flex flex-row align-items-center">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-4 col-md-6 col-sm-8 col-10">
                    <div class="card-group d-block d-md-flex row">
                        <div class="card col-md-6 p-4 mb-0">
                            <div class="card-body">
                                <h1>Login</h1>
                                <br />
                                <form id="login-form" method="post" action="/api/v1/login">
                                    <div class="input-group mb-3"><span class="input-group-text">
                                            <svg class="icon">
                                                <use xlink:href="/vendors/coreui/icons/svg/free.svg#cil-user"></use>
                                            </svg></span>
                                        <input class="form-control" type="text" name="email" placeholder="E-mail">
                                    </div>
                                    <div class="input-group mb-4"><span class="input-group-text">
                                            <svg class="icon">
                                                <use xlink:href="/vendors/coreui/icons/svg/free.svg#cil-lock-locked"></use>
                                            </svg></span>
                                        <input class="form-control" type="password" name="password" placeholder="Senha">
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <button class="btn btn-primary px-4" type="submit">Login</button>
                                        </div>
                                        <div class="col-6 text-end">
                                            <button class="btn btn-link px-0" type="button">Esqueceu a senha?</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-public-body>
