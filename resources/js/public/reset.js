/**
 * Scripts para recuperacao de senha
 */
'use strict'
const form = document.querySelector('#form-reset');

form.addEventListener('submit', function (e) {
    e.preventDefault();
    const email = document.querySelector('[name=email]');
    const parent = email.parentElement;
    if (!emailPattern.test(email.value)) {
        setErrorMessage(email, 'Informe um endereço de email válido.');
        return;
    }

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
            switchLoader(false);
            if (statusText == 'success') {
                const resetModal = document.querySelector('#reset-modal');
                const modal = new bootstrap.Modal(resetModal, { backdrop: 'static' });
                modal.show();
                resetModal.addEventListener('hidden.bs.modal', function (event) {
                    window.location.href = '/login';
                });
                return;
            }
            setAlert(message ?? 'O endereço de email informado não está cadastrado!', statusText);
        })
        .catch(error => {
            setAlert('Erro de solicitação desconhecido', 'danger');
        });
});