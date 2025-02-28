<x-public-layout>
    <main class="d-flex w-100">
        <div class="container d-flex flex-column">
            <div class="row vh-100">
                <div class="col-sm-10 col-md-8 col-lg-6 col-xl-5 mx-auto d-table h-100">
                    <div class="d-table-cell align-middle">
                        <div class="card mb-3">
                            <div class="card-header bg-secondary bg-gradient">
                                <img src="/img/logo-elattes.png" alt="E-lattes" class="img-fluid" />
                                <img src="/img/fiocruz-branco-44.png" alt="E-lattes" class="img-fluid float-end" />
                            </div>
                            <div class="card-body">
                                <div class="m-sm-3">
                                    <form method="POST" action="{{ route('login') }}" id="login-form">
                                        <div class="mb-3">
                                            <label class="form-label">Email</label>
                                            <input class="form-control form-control-lg" type="text" name="email" placeholder="Digite seu email" />
                                            <div class="invalid-feedback"></div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Senha</label>
                                            <input class="form-control form-control-lg" type="password" name="password" placeholder="Digite sua senha" />
                                        </div>
                                        <div>
                                            <div class="form-check align-items-center">
                                                <input id="customControlInline" type="checkbox" class="form-check-input" value="remember-me" name="remember-me">
                                                <label class="form-check-label text-small" for="customControlInline">Lembrar de mim</label>
                                            </div>
                                        </div>
                                        <div class="d-grid gap-2 mt-3">
                                            <button type="submit" class="btn btn-lg btn-primary">Entar</button>
                                        </div>
                                        @csrf
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 mb-3">
                                Não possui conta? <a href="/register">Registre-se</a>
                            </div>
                            <div class="col-6 text-end mb-3">
                                Esqueceu a senha? <a href="/password-reset">Recupere aqui</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</x-public-layout>
