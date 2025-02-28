/**
 * Modulo com funcoes de uso geral
 */
/**
 * Padrao da senha para validacao
 */
const passwordPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
/**
 * Valida um endereco de email
 * @param {string} email
 * @return boolean
 */
export function validateEmail(email) {
    const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    return emailPattern.test(email);
}
/**
 * Formata uma string no padrao 'String'
 * @param {string} str 
 * @returns 
 */
export function capitalize(str) {
    return str.charAt(0) + str.slice(1).toLowerCase();
}
/**
 * Formata uma data no padro local (pt-BR)
 * @param {string} dateString 
 * @returns 
 */
export function formatDate(dateString) {
    const date = new Date(dateString.replace(' ', 'T'))
    const formatter = new Intl.DateTimeFormat('pt-BR', { year: 'numeric', month: '2-digit', day: '2-digit', hour: '2-digit', minute: '2-digit' });
    return formatter.format(date);
}
/**
 * Calcula o tempo passado a partir de um dado momento
 * @param {string} dateString 
 * @returns 
 */
export function timeElapsed(dateString) {
    
    const date = new Date(dateString.replace(" ", "T"));
    const now = new Date();

    // Calcula a diferenca em milisegundos
    const diffInMs = now - date;

    // converte os milisegundos
    const seconds = diffInMs / 1000;
    const minutes = seconds / 60;
    const hours = minutes / 60;
    const days = hours / 24;
    const weeks = days / 7;
    const months = days / 30;

    // Cria uma instancia de RelativeTimeFormat
    const rtf = new Intl.RelativeTimeFormat('en', { numeric: 'auto' });

    // Retorna o tempo com base no claculo
    if (Math.abs(minutes) < 60) {
        return `${Math.round(minutes)} minuto${Math.round(minutes) !== 1 ? 's' : ''}`;
    } else if (Math.abs(hours) < 14) {
        return `${Math.round(hours)} hora${Math.round(hours) !== 1 ? 's' : ''}`;
    } else if (Math.abs(days) < 30) {
        return `${Math.round(days)} dia${Math.round(days) !== 1 ? 's' : ''}`;
    } else if (Math.abs(weeks) < 4) {
        return `${Math.round(weeks)} semana${Math.round(weeks) !== 1 ? 's' : ''}`;
    } else {
        return `${Math.round(months)} ${Math.round(months) === 1 ? 'mês' : 'meses'}`;
    }
}
/**
 * Preenche uma tabela com linhas preenchidas com placeholders
 * @param {string} tableId 
 * @param {numeric} numRows 
 * @param {numeric} numCols 
 * @returns 
 */
export function fillTableWithPlaceholders(tableId, numRows, numCols) {
    // Pega a tabela
    const table = document.getElementById(tableId);
    
    // Retorna erro se não existir
    if (!table) {
        console.error('Tabela não encontrada!');
        return;
    }
    const lines = [];
    // Cria as linhas
    for (let i = 0; i < numRows; i++) {
        const tr = document.createElement('tr');

        // Cria a celula (coluna)
        for (let j = 0; j < numCols; j++) {
            const td = document.createElement('td');

            // Cria o placeholder
            const placeholder = document.createElement('div');
            placeholder.classList.add('placeholder', 'glow');
            placeholder.innerHTML = '<span class="visually-hidden">Loading...</span>';

            // insere na celula
            td.append(placeholder);

            lines.push(td)
        }
    }
    return lines;
}
/**
 * Retorna uma instancia da tabela htmls
 * @param {string} id 
 */
export function getDatatableObject(id){
    return new simpleDatatables.DataTable(`#${id}`, {
        labels: pt_BR
    });
}