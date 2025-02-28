import { getDatatableObject } from '../utils.js';
import { deleteAnalise, loadAnalisesData } from './analises.js';
import { loadUserData } from './config-user.js';
import { loadLogData } from './log.js';
import { setConfigFormValues } from './config-app.js';
/**
 * Excuta a aplicacao
 */
document.addEventListener("DOMContentLoaded", function () {
    // Inicia carregando os dados da primeira pagina que eh analises
    let tbPermanente = getDatatableObject('tab-permanente');
    let tbTemporaria = getDatatableObject('tab-temporaria');
    loadAnalisesData(tbPermanente, tbTemporaria);
    // Adiciona eventos aos itens do menu lateral
    document.querySelector('#analises-item').addEventListener('click', function () {
        if (tbPermanente != null && tbPermanente.initialized) {
            tbPermanente.destroy();
            tbTemporaria.destroy();
        }
        tbPermanente = getDatatableObject('tab-permanente');
        tbTemporaria = getDatatableObject('tab-temporaria');
        loadAnalisesData(tbPermanente, tbTemporaria);
    });
    document.querySelector('#config-item').addEventListener('click', function () {        
        setConfigFormValues();
    });

    /****************************************************************
     * Scripts da pagina analises
     ***************************************************************/
    document.querySelectorAll('#tab-permanente, #tab-temporaria').forEach(tab => {
        tab.addEventListener("click", function (e) {
            const target = e.target.closest("#actions button");
            if (target) {
                const classes = (target.getAttribute('class')).split(" ");
                if (classes.includes('download')) {
                    console.log('download')
                    return;
                }
                if (classes.includes('detalhar')) {
                    console.log('detalhar')
                    return;
                }
                if (classes.includes('editar')) {
                    editAnalise(target.getAttribute('data-id'));
                    return;
                }
                if (classes.includes('excluir')) {
                    deleteAnalise(target.getAttribute('data-id'));
                    return;
                }
            }
        });
    });

    /****************************************************************
     * Scripts da pagina configuracoes
     ***************************************************************/
    /**
     * Secao aplicacao
     */
    document.querySelectorAll('#aplicacao form input','#aplicacao form select').forEach(el => {
        el.addEventListener('change', function() {
            const data = {};
            const elName = this.attributes.name.value;
            data[elName] = this.attributes.type.value == 'checkbox' ? this.checked : this.value;
            
            console.log(data)
            fetch('/configuracao',{
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            }).then(response => response.json())
            .then(data => {
                console.log(data)
            });
        });
    });
    /**
     * Secao usuario
     */
    const uid = document.querySelector('#exclusaoModal .modal-body #uid');
    let userTable = null;
    document.querySelector('#usuarios-tab').addEventListener('click', function (e) {
        if (userTable != null && userTable.initialized) {
            userTable.destroy();
        }
        userTable = getDatatableObject('users-table');
        loadUserData(userTable);
    });
    document.querySelector('#users-table').addEventListener('click', function (e) {
        const target = e.target.closest(".delete");
        if (target) {
            uid.setAttribute('value', target.parentElement.getAttribute('aria-uid'));
        }
    });
    document.querySelector('#exclusaoModal').addEventListener('hidden.bs.modal', function (event) {
        excluirUsuario(uid.getAttribute('value'));
        uid.setAttribute('value', '');
    });
    // document.querySelector('.block').addEventListener('click', function(e){

    // });
    document.querySelector('#btn-delete').addEventListener('click', function (e) {

    });
    // Carrega a tabela ao clicar na aba de logs
    let logsTable = null;
    document.querySelector('#config-logs-tab').addEventListener('click', function (e) {
        // if (logsTable !== null && logsTable.initialized) {
        //     logsTable.destroy();
        // }
        // logsTable = getDatatableObject('logs-table');
        loadLogData(logsTable);
    });
});