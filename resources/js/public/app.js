/**
 * Scripts para a area publica da aplicacao
 */
import { validateEmail } from '../utils.js';
import * as auth from './autenticacao.js';
import * as register from './register.js';
/**
 * Scripts para a tela de login
 * @version 1.0
 */
document.addEventListener("DOMContentLoaded", function () {
    /*******************************************************
     * Scripts para login
     ******************************************************/
    const loginForm = document.querySelector('#login-form');
    if (loginForm !== null) {
        loginForm.addEventListener('submit', function (e) {
            e.preventDefault();
            const email = document.querySelector('[name=email]');
            const password = document.querySelector('[name=password]');
            const inputs = document.querySelectorAll('[name="email"], [name="password"]');
            const errorContainer = document.querySelectorAll('.invalid-feedback');
            const isInvalid = document.querySelectorAll('.is-invalid');

            let isValid = true;
            errorContainer.forEach(el => el.remove());
            isInvalid.forEach(el => el.classList.remove('is-invalid'));

            inputs.forEach((el) => {
                const name = el.getAttribute('name');
                if (el.value === '') {
                    auth.setErrorMessage(el, 'Campo obrigatório');
                    isValid = false;
                }
                else if (name == 'email' && !validateEmail(el.value)) {
                    validateEmail.setErrorMessage(el, 'Por favor, insira um endereço de email válido.');
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

                        auth.setAlert(message ?? data.message, statusText);
                    })
                    .catch(error => {
                        auth.setAlert('Erro desconhecido', 'danger');
                    });
            }
        });
    }
    /*******************************************************
     * Scripts para registro
     ******************************************************/
    /**
     * Executa o registro do usuario
     */
    const registerForm = document.querySelector('#register-form');
    if (registerForm !== null) {
        registerForm.addEventListener('submit', function (e) {
            e.preventDefault();
            const inputs = document.querySelectorAll('[type=text],[type=password]');
            const isInvalid = document.querySelectorAll('.invalid-feedback');

            isInvalid.forEach(el => el.remove());
            const alerTermos = document.querySelector('.alert');
            if (alerTermos != null) {
                alerTermos.remove();
            }
            const invalid = document.querySelectorAll('.is-invalid');
            invalid.forEach(el => el.classList.remove('is-invalid'));

            if (register.validarForm(inputs)) {
                const formData = new FormData();
                formData.append('name', document.querySelector('[name=name]').value);
                formData.append('email', document.querySelector('[name=email]').value);
                formData.append('company', document.querySelector('[name=company]').value);
                formData.append('password', document.querySelector('[name=password]').value);
                formData.append('password_confirmation', document.querySelector('[name=password_confirmation]').value);
                formData.append('_token', document.querySelector('[name=_token]').value);

                register.enviarDados(formData);
            }
        });
    }    
    /*******************************************************
     * Scripts para recuperacao de senha
     ******************************************************/
    const resetForm = document.querySelector('#reset-form');
    if (resetForm !== null) {
        resetForm.addEventListener('submit', function (e) {
            e.preventDefault();
            const invalidFeedback = document.querySelectorAll('.invalid-feedback');
            invalidFeedback.forEach(el => el.remove());
            const email = document.querySelector('[name=email]');
            email.classList.remove();
            const parent = email.parentElement;
            if (!validateEmail(email.value)) {
                auth.setErrorMessage(email, 'Informe um endereço de email válido.');
                return;
            }
            auth.switchLoader(true);
            const formData = new FormData();
            formData.append('email', document.querySelector('[name=email]').value);
            formData.append('_token', document.querySelector('[name=_token]').value);
            let statusText = 'success';
            let message = null;
            fetch('password-reset', {
                method: 'POST',
                body: formData,
                headers: {
                    'Accept': 'application/json'
                }
            })
                .then(response => {
                    if (!response.ok) {
                        switch (response.status) {
                            case 400:
                                statusText = 'danger';
                                break;
                            case 401:
                                statusText = 'danger';
                                break;
                            case 419:
                                message = 'O tempo do formulário expirou! Recarregue a página e tente de novo.', 'danger';
                                statusText = 'warning';
                                break
                            case 500:
                                message = 'Erro interno do servidor! Informe o administrador.', 'danger';
                                statusText = 'danger';
                                break;
                            default:
                                message = 'Erro interno desconhecido';
                                statusText = 'danger';
                        }
                    }
                    return response.json();
                })
                .then(data => {
                    auth.switchLoader(false);
                    if (statusText == 'success') {
                        const resetModal = document.querySelector('#reset-modal');
                        const modal = new bootstrap.Modal(resetModal, { backdrop: 'static' });
                        modal.show();
                        resetModal.addEventListener('hidden.bs.modal', function (event) {
                            window.location.href = '/login';
                        });
                        return;
                    }
                    auth.setAlert(message ?? 'O endereço de email informado não está cadastrado!', statusText);
                })
                .catch(error => {
                    auth.setAlert('Erro de solicitação desconhecido', 'danger');
                });
        });
    }
});