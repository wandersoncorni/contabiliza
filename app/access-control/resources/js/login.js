/**
 * Script para a pagina de login
 * @version 1.0
 */
let xsrfToken = null;
document.addEventListener("DOMContentLoaded", () => {
    fetch('sanctum/csrf-cookie', {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json'
        },
        credentials: 'include',
    }).then(response => {
        xsrfToken = (document.cookie).split(`XSRF-TOKEN=`)[1];
    });
});
document.querySelector('#login-form').addEventListener("submit", async (event) => {
    event.preventDefault();
    fetch('/api/v1/login', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
        },
        credentials: 'include',
        body: JSON.stringify({
            email: document.getElementById('email').value,
            password: document.getElementById('password').value,
        })
    })
        .then(async response => {
            if (response.status == 419) {
                fetch('/csrf-token', {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                    },
                })
                    .then(async response => {
                        const data = await response.json();
                        document.querySelector('meta[name="csrf-token"]').setAttribute('content', data.token);
                        document.querySelector('#login-form [type="submit"]').click();
                    });
                return;
            }

            const data = await response.json();
            if (data.error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Erro',
                    text: data.error,
                });
                return;
            }
            window.location.href = '/';
        })
        .catch(error => console.error('Erro:', error));
});
document.querySelector("#show_password").addEventListener("change", function () {
    const passwordField = document.querySelector("#password");
    this.checked ? passwordField.type = "text" : passwordField.type = "password";
});
document.querySelector("#show_password").checked = false;
document.querySelector("body").addEventListener("keydown", (event) => {
    if (event.key === "Enter") {
        event.preventDefault();
        document.querySelector("[type=submit]").click(); // Dispara o clique no botão de envio
    }
});