/**
 * Scripts para autenticacao (login, registro e recuperacao de senha)
 */
'use strict'

/**
 * Exibe mensagens de erro dos campos
 */
export function setErrorMessage(el, message) {
    const div = document.createElement('div');
    el.classList.add('is-invalid');
    div.classList.add('invalid-feedback');
    div.textContent = message;
    el.insertAdjacentElement('afterend', div);
};
/**
 * Exibe mensagens de erro do servidor
 */
const iconClass = {
    success: 'bi-check-circle-fill',
    warning: 'bi-exclamation-triangle-fill',
    danger: 'bi-dash-circle-fill',
}
export function  setAlert(message, type = 'success') {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(el => el.remove());
    let icon = document.createElement('i');
    icon.classList.add('bi', iconClass[type]);
    const alert = document.createElement('div');
    alert.classList.add('alert', `alert-${type}`);
    alert.setAttribute('role', 'alert');
    alert.append(icon);
    alert.append(` ${message}`);
    const card = document.querySelector('.card-body');
    card.append(alert);
}

export function  switchLoader(show = true) {
    const loader = document.querySelector('#loader');
    if (show) {
        loader.classList.remove('d-none');
        loader.classList.add('d-flex');
    } else {
        loader.classList.remove('d-flex');
        loader.classList.add('d-none');
    }
}