/**
 * Scripts para o registro de usuários
 */
document.querySelector('#show_password').checked = false;
document.querySelector('#concorde_termo').checked = false;
document.querySelector('#password').addEventListener('input', function () {
    const password = this.value;

    // Elementos das regras
    const length = document.querySelector('#length');
    const uppercase = document.querySelector('#uppercase');
    const lowercase = document.querySelector('#lowercase');
    const number = document.querySelector('#number');
    const special = document.querySelector('#special');

    // Expressões regulares
    const regexUpper = /[A-Z]/;
    const regexLower = /[a-z]/;
    const regexNumber = /[0-9]/;
    const regexSpecial = /[@$!%*?&]/;

    // Validações
    validateRule(length, password.length >= 8);
    validateRule(uppercase, regexUpper.test(password));
    validateRule(lowercase, regexLower.test(password));
    validateRule(number, regexNumber.test(password));
    validateRule(special, regexSpecial.test(password));
});

function validateRule(element, isValid) {
    if (isValid) {
        element.classList.remove('invalid');
        element.classList.add('valid');
        element.querySelector('i').classList.remove('heroicon-x');
        element.querySelector('i').classList.add('heroicon-check');
    } else {
        element.classList.remove('valid');
        element.classList.add('invalid');
        element.querySelector('i').classList.remove('heroicon-check');
        element.querySelector('i').classList.add('heroicon-x');
    }
}

const $showPwd = document.querySelector("#show_password");
$showPwd.addEventListener("change", function () {
    const passwordField = document.querySelector("#password");
    const confirmField = document.querySelector("#password_confirmation");
    if (this.checked) {
        passwordField.type = "text";
        confirmField.type = "text";
    } else {
        passwordField.type = "password";
        confirmField.type = "password";
    }
});

document.querySelector("#register-form").addEventListener("submit", function (e) {
    e.preventDefault(); // Impede o envio padrão do formulário
    // Remove mensagens de erro anteriores
    removeErrorMessages();
    // Valida os campos
    const isValid = validateFields();
    let statusCode = undefined;

    if (isValid) {
        const formData = new FormData(document.querySelector("#register-form"));
        formData.append(document.createElement('input').name = '_token', getCsrfToken());
        fetch('/api/v1/account', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
            }
        })
            .then(response => { statusCode = response.status; return response.json()})
            .then(data => {
                if(data.errors) {
                    Object.keys(data.errors).forEach((key) => {
                        const field = document.querySelector(`[name=${key}]`);
                        addErrorMessage(field, data.errors[key][0]);
                    });
                    return;
                }
                else if(data.error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Erro',
                        text: data.error ?? 'Erro desconhecido',
                    });
                    return;
                }
                else if(statusCode < 200 && statusCode > 299) {
                    Swal.fire({ 
                        icon: 'error',
                        title: 'Erro',
                        text: `${data.message}` ?? 'Erro desconhecido',
                    });
                    return;
                }
                else if(statusCode >= 200 && statusCode <= 299) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Cadastro realizado com sucesso',
                        text: data.message ?? 'Sucesso!!',
                    });
                    return;
                }
                Swal.fire({
                    icon: 'waning',
                    title: 'Atenção',
                    text: 'Um erro desconhecido ocorreu!',
                });
            })
    }
});

function validateFields() {
    const password = document.querySelector("#password").value;
    const confirmPassword = document.querySelector("#password_confirmation").value;

    let isValid = true;

    if(document.querySelectorAll(".list-unstyled .invalid").length > 0) {
        addErrorMessage(document.querySelector("#password"), "A senha não atende aos requisitos.");
        isValid = false;
    }
    if(password !== confirmPassword) {
        addErrorMessage(document.querySelector("#password_confirmation"), "As senhas não coincidem.");
        isValid = false;
    }
    if(!document.querySelector("#concorde_termo").checked) {
        addErrorMessage(document.querySelector("#concorde_termo"), "Você deve concordar com os termos.");
        isValid = false;
    }
    return isValid;
}

function addErrorMessage(field, message) {
    const errorDiv = document.createElement("div");
    errorDiv.classList.add("invalid-feedback");
    errorDiv.textContent = message;
    field.classList.add("is-invalid"); // Adiciona classe de erro ao campo    
    field.parentNode.insertBefore(errorDiv, field.nextSibling);
}

function removeErrorMessages() {
    const errorMessages = document.querySelectorAll(".invalid-feedback");
    errorMessages.forEach((message) => {
        message.remove();
    });

    document.querySelectorAll(".is-invalid").forEach((field) => {
        field.classList.remove("is-invalid");
    });
}
