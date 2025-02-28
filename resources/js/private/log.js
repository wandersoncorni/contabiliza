/**
 * Scripts para configuracao/logs
 */
import {fillTableWithPlaceholders} from '../utils.js'
/**
 * Carrega os dados da tabela
 */
export function loadLogData(table) {
    fillTableWithPlaceholders('logs-table',10,3);
    fetch(`/logs?fields=${encodeURIComponent('user.name,action,orign,datetime')}`, {
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
    }).catch(error => {});
}