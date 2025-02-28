/**
 * Script para analises
 */
document.addEventListener("DOMContentLoaded", function () {    
    /**
     * Retorna o conteudo da coluna analise
     * @param {object} data 
     */
    const getLabel = (data)=>{
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
        try{
            console.log('try')
            timeElapsed(data.updated)
        }catch(error){
            console.log(error);
        }
        console.log(timeElapsed(data.updated)) 
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
    const clearTable = (dtb)=>{
        const numRows = dtb.data.data.length;
        const rowsToDelete = Array.from({ length: numRows }, (_, i) => i);
        dtb.rows.remove(rowsToDelete); 
    }
    /**
     * Retorna o rotuelo do estado da analise
     * @param {*} status 
     * @returns 
     */
    const getStatusLabel = (status)=>{
        const statusColor = ['danger', 'warning', 'success', 'info'];
        const statusLabel = ['Falhou', 'Em processamento', 'Pronta', 'Aguardando'];
        const stLabel = document.createElement('span');
        
        stLabel.classList.add('badge', `bg-${statusColor[status]}`, 'p-2');
        stLabel.innerHTML = statusLabel[status];
        return stLabel.outerHTML;
    }
    /**
     * Monta os botoes as acoes
     * @returns object html
     */
    const getButtons = ()=>{
        const container = document.createElement('div');
        container.classList.add('btns-group');
        container.setAttribute('id','actions');

        const buttons = [
            { icon: "bi-download", class: "btn-primary me-1 download", attr:{type: 'button', title: 'Baixar JSON'}},
            { icon: "bi-r-circle", class: "btn-secondary me-1 detalhar", attr:{type: 'button', title: 'Detalhes do processamento R'}},
            { icon: "bi-pencil", class: "btn-warning me-1 editar", attr:{type: 'button', title: 'Editar análise'}},
            { icon: "bi-trash", class: "btn-danger me-1 excluir", attr:{type: 'button', title: 'Excluir análise'}}
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
    const setDataTable = (data, dtb1, dtb2)=>{
        const dadosPermanentes = [];
        const dadosTemporarios = [];
        data.map((dt)=>{
            if(dt.state){
                dadosPermanentes.push({
                    "Análises": getLabel(dt),
                    "Situação": getStatusLabel(dt.status),
                    "Ações": getButtons()
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
    //Inicialisa as tabelas
    let tbPermanente = getDatatableObject('tab-permanente');
    let tbTemporaria = getDatatableObject('tab-temporaria');
    //busca os dados e atualiza a tabela
    const loadData = (dtb1, dtb2)=>{
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
    //Atualiza a tabela
    loadData(tbPermanente, tbTemporaria);
    /**
     * Adiciona um evento nos botoes
     */
    document.querySelectorAll('#tab-permanente, #tab-temporaria').forEach( tab => {
        tab.addEventListener("click", function(e){
            const target = e.target.closest("#actions button");      
            if(target){
                const classes = (target.getAttribute('class')).split(" ");
                if(classes.includes('download')){
                    console.log('download')
                    return;
                }
                if(classes.includes('detalhar')){
                    console.log('detalhar')
                    return;
                }
                if(classes.includes('editar')){
                    console.log('editar')
                    return;
                }
                if(classes.includes('excluir')){
                    console.log('excluir')
                    return;
                }
            }
        });
    });
    /**
     * Adiciona um evento ao menu lateral para recarregar a pagina
     */
    document.querySelector('#analises-item').addEventListener('click', function(){
        loadData(tbPermanente, tbTemporaria);
    });
});