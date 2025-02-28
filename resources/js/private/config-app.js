/**
 * Scripts para o tab "Aplicacao" do item de menu configuracoes
 */
export function setConfigFormValues() {
    fetch('/configuracao')
        .then(response => response.json())
        .then(data => {
            Object.keys(data).map(name =>{
                const form = document.querySelector('#aplicacao form');
                const field = form.querySelector(`#${name}`);

                if(field !== null){
                    const type = field.getAttribute('type');
                    if(type == 'checkbox'){
                        field.checked = data[name];
                    }
                    else if(name == 'service_collector'){
                        field.value = data[name];
                    }
                }
                
            });
        });
}