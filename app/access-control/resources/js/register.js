/**
 * Scripts para o registro de usuários
 */
$(function () {
    $('#form-register').submit(function (e) {
        e.preventDefault();
        e.stopPropagation();
        // Limpar mensagens de erro anteriores
        $('.invalid-feedback').remove();

        // Validação dos campos de email e senha
        const name = $('[name=name]').val();
        const email = $('[name=email]').val();
        const password = $('[name=password]').val();
        const passwordConfirmation = $('[name=password_confirmation]').val();
        const emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
        const passwordPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;

        let hasError = false;

        if (!name.length) {
            setErrorMessage('[name=name]', 'O campo nome é obrigatório.');
            hasError = true;
        }

        if (!emailPattern.test(email)) {
            setErrorMessage('[name=email]', 'Por favor, insira um endereço de email válido.');
            hasError = true;
        }

        if (!passwordPattern.test(password)) {
            setErrorMessage('[name=password]', 'A senha deve ter no mínimo 8 caracteres, incluindo pelo menos uma letra maiúscula, uma letra minúscula, um número e um caractere especial.');
            hasError = true;
        }

        if (password !== passwordConfirmation) {
            setErrorMessage('[name=password_confirmation]', 'A confirmação de senha não corresponde.');
            hasError = true;
        }

        if (hasError) {
            return;
        }

        const form = $(this);
        const url = form.attr('action');
        const data = form.serialize();

        $.ajax({
            url: url,
            type: 'POST',
            data: data,
            dataType: 'json',
            beforeSend: function () {
                $('#loader').removeClass('d-done').addClass('d-flex');
            },
            success: function (resp) {
                $('#modal-success').modal('show');
            },
            error: function (resp) {
                const errors = resp.responseJSON.errors;
                Object.keys(errors).map(name => {
                    errors[name].map(message => {
                        setErrorMessage(`[name=${name}]`, message);
                    });
                });
            },
            always: function () {
                $('#loader').removeClass('d-flex').addClass('d-done');
            }
        });
    });
    $('#modal-success').on('hidden.coreui.modal', function (e) {
        window.location.href = window.location.origin + '/login';
    });
});

const setErrorMessage = (field, message) => {
    $(field).after(
        $('<div />', { class: 'invalid-feedback', style: 'display:block' }).html(message)
    );
};