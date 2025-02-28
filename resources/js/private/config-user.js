/**
 * Scripts para o item configuracoes
 */
import {fillTableWithPlaceholders} from '../utils.js'
/**
 * Carrega os dados
 * @param {object} userTable
 */
export function loadUserData(userTable) {
    fillTableWithPlaceholders('users-table',10,2);
    fetch(`/usuarios?fields=${encodeURIComponent('id,name,email,active,profile_id,photo')}`, {
        method: 'get',
        headers: {
            'Accept': 'application/json'
        }
    }).then(response => {
        return response.json();
    }).then(data => {
        const numRows = userTable.data.data.length;
        const rowsToDelete = Array.from({ length: numRows }, (_, i) => i);
        userTable.rows.remove(rowsToDelete);
        if (data.length) {
            const dt = setDataTable(data);
            userTable.insert(dt);
        }
    })
        .catch(error => { });
}
/**
 * Formata a coluna dos dados do usuario
 * @param {object} data Os dados da requisicao
 * @return ObjectHTML
 */
function getUserData(data) {
    const container = document.createElement('div');
    const header = document.createElement('h5');
    header.innerHTML = data.name;
    const avatar = document.createElement('img');
    avatar.setAttribute('src', '/usuario/avatar/' + (data.photo ?? 'default.png'));
    avatar.classList.add('avatar');
    const info = document.createElement('p');
    info.innerHTML = data.email;
    container.append(avatar, header, info);
    return container.outerHTML;
}
/**
 * Monta os botoes as acoes
 * @returns object html
 */
function getButtons(data) {
    const container = document.createElement('div');
    container.classList.add('btns-group');
    container.setAttribute('id', 'actions');
    container.setAttribute('aria-uid', data.id);

    const buttons = [
        { icon: "bi-person-lock", class: "btn-warning me-1 block", attr: { type: 'button', title: 'Bloquear' } },
        { icon: "bi-person-dash", class: "btn-danger me-1 delete", attr: { type: 'button', title: 'Excluir', 'data-bs-toggle': 'modal', 'data-bs-target': '#exclusaoModal' } },
    ];

    buttons.forEach(btn => {
        const button = document.createElement("button");
        Object.keys(btn.attr).map(name => button.setAttribute(name, btn.attr[name]));
        button.className = `btn ${btn.class}`;
        button.innerHTML = `<i class="${btn.icon}"></i>`;
        container.appendChild(button);
    });

    return container.outerHTML;
}
/**
 * Configura o conteudo da tabela
 * @param {object} data 
 * @returns 
 */
function setDataTable(data) {
    const lns = [];
    data.map((data) => {
        lns.push({
            'Usuários': getUserData(data),
            'Ações': getButtons(data)
        });
    });
    return lns;
};

export function excluirUsuario(uid) {
    fetch('/usuario/123', {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json',
            //'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ confirmacao: true })
    })
        .then(response => response.json())
        .then(data => console.log(data));
}