/**
 * Script para a pagina de login
 * @version 1.0
 */
document.querySelector('#login-form').addEventListener("submit", async (event) => {
    event.preventDefault();
    fetch('/api/v1/login', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        credentials: 'include', // Necessário para cookies HTTP-only
        body: JSON.stringify({
            email: document.getElementById('email').value,
            password: document.getElementById('password').value,
            _token: document.querySelector('input[name="_token"]').value
        })
    })
        .then(response => response.json())
        .then(data => {
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
        event.preventDefault(); // Evita o envio automático padrão
        document.querySelector("[type=submit]").click(); // Dispara o clique no botão de envio
    }
});