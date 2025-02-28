/**
 * Modulo de contrucao da tabela da pagina de analises
 */
import {timeElapsed, fillTableWithPlaceholders} from '../utils.js';
/**
 * Retorna uma instancia da tabela htmls
 * @param {string} id 
 */
function getDatatableObject(id){
    return new simpleDatatables.DataTable(`#${id}`, {
        labels: pt_BR
    });
}
/**
 * Retorna o conteudo da coluna analise
 * @param {object} data 
 */
function getLabel(data){
    const status = ['Falhou','Rodando','Pronto','Espera'];
    const content = document.createElement('div');
    const header = document.createElement('h4');        
    
    if(data.status == 2){
        const link = document.createElement('a');
        link.setAttribute('href',`/analysis/dashboard/id/${data.id} `);
        link.innerHTML = data.name;
        header.innerHTML = link.outerHTML;
    }
    else{
        header.classList.add('text-secondary');
        header.innerHTML =  data.name;
    }
    
    const desc = document.createElement('p');
    desc.innerHTML = data.description ?? '';
    
    const resumo = document.createElement('p');
    resumo.innerHTML = `<b>${data.total_list}</b> perquisadores ${data.date_from} até ${data.date_to} `;
    const update = document.createElement('small');
    update.classList.add('float-end','text-primary');
    update.innerHTML = `Última atualização:  ${timeElapsed(data.updated)} atrás.`;

    const company = document.createElement('small');
    company.innerHTML = `Criada por <a href="#">${data.user.name}</a> ${data.user.company??''}, ${timeElapsed(data.created)} atrás.`; 

    content.append(update, header, desc, resumo,company);
    return content.outerHTML;
}
/**
 * Limpa da tabela
 * @param {*} dtb 
 */
function clearTable(dtb){
    const numRows = dtb.data.data.length;
    const rowsToDelete = Array.from({ length: numRows }, (_, i)  => i);
    dtb.rows.remove(rowsToDelete); 
}
/**
 * Retorna o rotuelo do estado da analise
 * @param {*} status 
 * @returns 
 */
function getStatusLabel(status){
    const statusColor = ['danger', 'warning', 'success', 'info'];
    const statusLabel = ['Falhou', 'Em processamento', 'Pronta', 'Aguardando'];
    const stLabel = document.createElement('span');
    
    stLabel.classList.add('badge', `bg-${statusColor[status]}`, 'p-2');
    stLabel.innerHTML = statusLabel[status];
    return stLabel.outerHTML;
}
/**
 * Monta os botoes as acoes
 * @param {numeric} id O id do registro
 * @returns object html
 */
function getButtons(id){
    const container = document.createElement('div');
    container.classList.add('btns-group');
    container.setAttribute('id','actions');

    const buttons = [
        { icon: "bi-download", class: "btn-primary me-1 download", attr:{type: 'button', title: 'Baixar JSON'}},
        { icon: "bi-r-circle", class: "btn-secondary me-1 detalhar", attr:{type: 'button', title: 'Detalhes do processamento R'}},
        { icon: "bi-pencil", class: "btn-warning me-1 editar", attr:{type: 'button', title: 'Editar análise', 'data-id': id}},
        { icon: "bi-trash", class: "btn-danger me-1 excluir", attr:{type: 'button', title: 'Excluir análise', 'data-id': id}}
    ];
    
    buttons.forEach(btn => {
        const button = document.createElement("button");
        Object.keys(btn.attr).map( name => button.setAttribute(name,btn.attr[name]));
        button.className = `btn btn-sm ${btn.class}`;
        button.innerHTML = `<i class="${btn.icon}"></i>`;
        container.appendChild(button);
    });

    return container.outerHTML;
}
/**
 * Seta as linhas da tabela
 * @param {object} data Os dados
 * @param {object} dtb1 A tabela permanente
 * @param {object} dtb2 A tabela temporaria
 */
function setDataTable(data, dtb1, dtb2){
    const dadosPermanentes = [];
    const dadosTemporarios = [];
    data.map((dt)=>{
        if(dt.state){
            dadosPermanentes.push({
                "Análises": getLabel(dt),
                "Situação": getStatusLabel(dt.status),
                "Ações": getButtons(dt.id)
            });
        }
        else{
            dadosTemporarios.push({
                "Análises": getLabel(dt),
                "Situação": getStatusLabel(dt.status),
                "Ações": getButtons()
            });
        }
    });
    clearTable(dtb1);
    dtb1.insert(dadosPermanentes);
    clearTable(dtb2 );
    dtb2.insert(dadosTemporarios);
}
/**
 * Requisita os dados e insere nas tabelas
 * @param {object} dtb1 O objeto simpleDatatables
 * @param {object} dtb2 O objeto simpleDatatables
 */
export function loadAnalisesData(dtb1, dtb2){
    fillTableWithPlaceholders('tab-permanente',9,3);
    fetch('/analises', {
        method: 'get',
        headers: {
            'Accept': 'application/json'
        }
    }).then(response => {
        return response.json();
    }).then(data => {
        if(data.length){                
            setDataTable(data, dtb1, dtb2);
            return;
        }
        clearTable(dtb1);
        clearTable(dtb2);
    })
    .catch(error => {
        
    });
}

export function createAnalise(){

}
/**
 * Atualiza uma analise
 */
export function updateAnalise(){
    
}
/**
 * Exlui a analise
 * @param {numeric} id O id da analise
 * @return boolean
 */
export function deleteAnalise(id){
    console.log(id)
}

export function detalharAnalise(){
    
}

