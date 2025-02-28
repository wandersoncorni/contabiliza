/**
 * Scripts para a tela de login
 * @version 1.0
 */
'use strict';

const form = document.querySelector('#login-form');
form.addEventListener('submit', function (e) {
    e.preventDefault();
    const email = document.querySelector('[name=email]');
    const password = document.querySelector('[name=password]');
    const inputs = document.querySelectorAll('[type="text"]');
    const errorContainer = document.querySelectorAll('.invalid-feedback');
    const isInvalid = document.querySelectorAll('.is-invalid');

    let isValid = true;
    errorContainer.forEach(el => el.remove());
    isInvalid.forEach(el => el.classList.remove('is-invalid'));

    inputs.forEach((el) => {
        const name = el.getAttribute('name');
        if (el.value === '') {
            setErrorMessage(el, 'Campo obrigatório');
            isValid = false;
        }
        else if (name == 'email' && !emailPattern.test(el.value)) {
            setErrorMessage(el, 'Por favor, insira um endereço de email válido.');
            isValid = false;
        }
    });

    // Se as validações passarem, enviar os dados via AJAX
    if (isValid) {
        let formData = new FormData();
        formData.append('email', email.value);
        formData.append('password', password.value);
        formData.append('_token', document.querySelector('[name=_token]').value);
        let statusText = 'success';
        let message = null;

        fetch('/login', {
            method: 'POST',
            body: formData,
            headers: {
                'Accept': 'application/json'
            }
        })
            .then(response => {
                if (!response.ok) {
                    switch (response.status) {
                        case 401:
                            statusText = 'danger';
                            break;
                        case 419:
                            message = 'O tempo do formulário venceu! Recarregue a página e tente de novo.', 'danger';
                            statusText = 'warning';
                            break
                        case 500:
                            message = 'Erro interno do servidor! Informe o administrador.', 'danger';
                            statusText = 'danger';
                            break;
                        default:
                            message = 'Erro desconhecido';
                            statusText = 'danger';
                    }
                }
                return response.json();
            })
            .then(data => {
                if (statusText == 'success') {
                    window.location.href = '/analysis';
                    return;
                }

                setAlert(message ?? data.message, statusText);
            })
            .catch(error => {
                setAlert('Erro desconhecido', 'danger');
            });
    }
});