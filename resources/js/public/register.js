/**
 * Scripts para registro
 */
import * as auth from './autenticacao.js';
import{validateEmail} from '../utils.js';
/**
 * Valida os campos do form
 * @param {*} elements 
 * @returns boolean
 */
const passwordPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
export function validarForm(elements) {
    let isValid = true;
    elements.forEach((el) => {
        const name = el.getAttribute('name');
        const parent = el.parentElement;
        const confirm = name == 'password' ? document.querySelector('[name=password_confirmation]') : null;
        if (!el.value) {
            auth.setErrorMessage(parent.nextElementSibling, 'Campo obrigatório');
            el.classList.add('is-invalid');
            isValid = false;
        }
        else if (name == 'email' && !validateEmail(el.value)) {
            auth.setErrorMessage(parent.nextElementSibling, 'Por favor, insira um endereço de email válido.');
            el.classList.add('is-invalid');
            isValid = false;
        }
        else if (name == "password" && !passwordPattern.test(el.value)) {
            auth.setErrorMessage(parent.nextElementSibling, 'A senha deve ter no mínimo 8 caracteres, incluindo pelo menos uma letra maiúscula, uma letra minúscula, um número e um caractere especial.');
            el.classList.add('is-invalid');
            isValid = false;
        }
        else if (name == "password" && el.value !== confirm.value) {
            auth.setErrorMessage(parent.nextElementSibling, 'A confirmação de senha não corresponde.');
            el.classList.add('is-invalid');
            isValid = false;
        }
    });
    const termos = document.querySelector('.form-check-input');
    if (termos.checked == false) {
        const parent = termos.parentElement;
        auth.setAlert('Você deve aceitar os termos de uso!', 'warning');
        isValid = false;
    }
    return isValid;
}
/**
 * Envia o formulario
 * @params formData O Objeto com os dados do formulario
 */
export function enviarDados(formData) {
    let statusText = 'success';
    let message = null;
    auth.switchLoader();
    fetch('register', {
        method: 'POST',
        body: formData,
        headers: {
            'Accept': 'application/json'
        }
    })
        .then(response => {
            if (!response.ok) {
                [statusText, message] = setarErro(response.status, [statusText, message]);
            }
            return response.json();
        })
        .then(data => {
            //Fecha o loader
            auth.switchLoader(false);
            if (statusText == 'success') {
                exibirModal();
                return;
            }
            if (data.errors != null) {
                Object.keys(data.errors).map((key) => {
                    const el = document.querySelector(`[name=${key}]`);
                    const parent = el.parentElement;
                    data.errors[key].map((msg) => {
                        el.classList.add('is-invalid');
                        auth.setErrorMessage(parent.nextElementSibling, msg);
                    });
                });
                return;
            }
            auth.setAlert(message ?? data.message, statusText);
        })
        .catch(error => {
            auth.switchLoader(false);
            auth.setAlert('Erro de solicitação desconhecido', 'danger');
        });
}
/**
 * Retorna o erro da requisicao
 * @params statusText
 */
export function setarErro(status, [statusText, message]) {
    switch (status) {
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
    return [statusText, message];
}
/**
 * Exibe o modal com a informcao sobre a aprovacao
 */
export function exibirModal() {
    const registerModal = document.getElementById('registerModal');
    const modal = new bootstrap.Modal(registerModal, { backdrop: 'static' });
    modal.show();
    registerModal.addEventListener('hidden.bs.modal', function (event) {
        window.location.href = '/login';
    });
}