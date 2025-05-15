/**
 * Script for the Forgot Password page.
 */
document.addEventListener('DOMContentLoaded', function () {
    document.querySelector('#formForgotPassword').addEventListener('submit', function (event) {
        event.preventDefault(); // Prevent the default form submission

        const email = document.querySelector('#email').value.trim();

        if (email === '') {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Informe o email.',
            });
            return;
        }

        fetch('/csrf-token', {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
            },
        })
            .then(response => response.json())
            .then((data) => {
                return fetch('/api/v1/forgot-password', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ email: email, _token: data.token }),
                });

            })
            .then((response) => {
                if (response.ok) {
                    return response.json();
                } else {
                    throw new Error('Error: ' + response.status);
                }
            })
            .then((data) => {
                Swal.fire({
                    icon: 'success',
                    title: 'Sucesso',
                    text: data.message,
                });
            })
            .catch((error) => {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Erro',
                    text: 'Ocorreu um erro ao enviar o email.',
                });
            });
    });
});
