<x-public-layout>
    <div class="register-page">
        <div class="register-box">
            <div class="card">
                <div class="card-body register-card-body">
                    <p class="register-box-msg h2">Recuperação de senha!</p>
                    <form action="/password-reset" method="post" id="reset-form">
                        <div class="input-group mb-3">
                            <div class="form-floating">
                                <input id="registerEmail" type="text" class="form-control" name="email" placeholder="Seu email" />
                                <label for="registerEmail">Email</label>
                            </div>
                            <div class="input-group-text"><span class="bi bi-envelope"></span></div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <div class="d-grid gap-2 mb-3">
                                    <button type="submit" class="btn btn-primary">Enviar</button>
                                </div>
                            </div>
                        </div>
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>
    <x-modal id="reset-modal" title="Reinicialização da senha">
        <h3 class="text-success">
            <x-icon type="check-circle-fill" />
            Solicitação concluída com sucesso!
        </h3>
        <p>Você recebeu um email com as instruções para reiniciar sua senha.
            Caso contrário, informe o administrador do sistema.</p>
        @push('modal-footer-reset-modal')
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
        @endpush

    </x-modal>
</x-public-layout>
