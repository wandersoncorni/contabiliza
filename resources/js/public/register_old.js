/**
 * Scripts para o formulario de registro
 * @version 1.0
 * @author Wanderson <wandersoncorni@gmail.com>
 */
'use strict'

const form = document.querySelector('#form-register');
const passwordPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
/**
 * Executa o registro do usuario
 */
form.addEventListener('submit', function (e) {
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

    if (validarForm(inputs)) {
        const formData = new FormData();
        formData.append('name', document.querySelector('[name=name]').value);
        formData.append('email', document.querySelector('[name=email]').value);
        formData.append('company', document.querySelector('[name=company]').value);
        formData.append('password', document.querySelector('[name=password]').value);
        formData.append('password_confirmation', document.querySelector('[name=password_confirmation]').value);
        formData.append('_token', document.querySelector('[name=_token]').value);

        enviarDados(formData);
    }
});
/**
 * Valida os campos do form
 * @param {*} elements 
 * @returns boolean
 */
const validarForm = (elements) => {
    let isValid = true;
    elements.forEach((el) => {
        const name = el.getAttribute('name');
        const parent = el.parentElement;
        const confirm = name == 'password' ? document.querySelector('[name=password_confirmation]') : null;
        if (!el.value) {
            setErrorMessage(parent.nextElementSibling, 'Campo obrigatório');
            el.classList.add('is-invalid');
            isValid = false;
        }
        else if (name == 'email' && !emailPattern.test(el.value)) {
            setErrorMessage(parent.nextElementSibling, 'Por favor, insira um endereço de email válido.');
            el.classList.add('is-invalid');
            isValid = false;
        }
        else if (name == "password" && !passwordPattern.test(el.value)) {
            setErrorMessage(parent.nextElementSibling, 'A senha deve ter no mínimo 8 caracteres, incluindo pelo menos uma letra maiúscula, uma letra minúscula, um número e um caractere especial.');
            el.classList.add('is-invalid');
            isValid = false;
        }
        else if (name == "password" && el.value !== confirm.value) {
            setErrorMessage(parent.nextElementSibling, 'A confirmação de senha não corresponde.');
            el.classList.add('is-invalid');
            isValid = false;
        }
    });
    const termos = document.querySelector('.form-check-input');
    if (termos.checked == false) {
        const parent = termos.parentElement;
        setAlert('Você deve aceitar os termos de uso!', 'warning');
        isValid = false;
    }
    return isValid;
}
/**
 * Envia o formulario
 * @params formData O Objeto com os dados do formulario
 */
const enviarDados = (formData) => {
    let statusText = 'success';
    let message = null;
    switchLoader();
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
            switchLoader(false);
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
                        setErrorMessage(parent.nextElementSibling, msg);
                    });
                });
                return;
            }
            setAlert(message ?? data.message, statusText);
        })
        .catch(error => {
            switchLoader(false);
            setAlert('Erro de solicitação desconhecido', 'danger');
        });
}
/**
 * Retorna o erro da requisicao
 * @params statusText
 */
const setarErro = (status, [statusText, message]) => {
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
const exibirModal = () => {
    const registerModal = document.getElementById('registerModal');
    const modal = new bootstrap.Modal(registerModal, { backdrop: 'static' });
    modal.show();
    registerModal.addEventListener('hidden.bs.modal', function (event) {
        window.location.href = '/login';
    });
}