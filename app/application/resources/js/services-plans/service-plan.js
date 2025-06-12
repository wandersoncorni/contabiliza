/**
 * Scripts para a aba de planos de servicos do modal de criacao e edicao.
 * @author Wanderson Corni <wandersoncorni@gmail.com>
 */
'use strict';
import { loadPlansList } from '../services-plans.js';
const serviceListSelected = [];
export function init() {
    $('#app-content #modal-form-plan').on('show.bs.modal', function (e) {
        // Carrega a lista do seletor de categorias
        if ($('#lista-categorias option').length <= 1) {
            setCategoriesOptions();
        }
        // Carrega a lista do seletor de servicos
        setServicesOptions();
        if ($('#lista-planos option').length <= 1) {
            loadOptionsPlansList();
        }
        $('#form-config-plan')[0].reset();
        // Reinicia a lista de servicos
        optionReset();
    });
    // Eventos para o select de categorias
    setSelectCategoriesEvent();
    
    $('#app-content #form-config-plan').on('submit', function (e) {
        e.preventDefault();
        // Salva o plano
        savePlan();
    })
}
/**
 * Carrega a lista do select para categorias
 */
export function setCategoriesOptions() {
    fetch('/api/v1/categorias-servicos')
        .then(response => response.json())
        .then(data => {
            let categorias = '<option value="">Escolha uma categoria</option>';
            data.forEach(categoria => {
                categorias += `<option value="${categoria.id}">${categoria.nome}</option>`;
            });
            $('#lista-categorias').html(categorias);
        });
}
/**
 * Carrega a lista do select para servicos
 */
export function setServicesOptions() {
    if (!$('#lista-servicos option').length) {
        fetch('/api/v1/servicos')
            .then(response => response.json())
            .then(data => {
                let servicos = '';
                data.forEach(servico => {
                    servicos += `<option class="bg-white" value="${servico.id}">${servico.nome}</option>`;
                });
                $('#lista-servicos').html(servicos).prop('size', $('#lista-servicos option').length);
            })
    }
}
/**
 * Eventos para o select de categorias
 */
function setSelectCategoriesEvent() {
    $('#lista-servicos').click(function (e) {
        e.target.innerHTML = e.target.innerHTML.replace('✔', '')
        if (serviceListSelected.includes(e.target.value)) {
            serviceListSelected.splice(serviceListSelected.indexOf(e.target.value), 1);
            e.target.classList.remove('bg-black');
            e.target.classList.remove('text-white');
        }
        else {
            serviceListSelected.push(e.target.value);
            e.target.innerHTML = `&#x2714; ${e.target.innerHTML}`;
            e.target.classList.add('bg-black');
            e.target.classList.add('text-white');
        }
        $('#lista-servicos').val(serviceListSelected)
    });
}
/**
 * Carrega os dados do plano selecionado na lista paro o formulario de edicao
 * @param {string} plano 
 * @param {int} categoria_id 
 */
export function loadPlanForm(plano, categoria_id) {
    let leep = 0;
    $('#modal-form-plan').modal('show');
    const loader = setInterval(() => {
        if ($('#modal-form-plan [name="plano_servico_id"]').length > 0) {
            clearInterval(loader);
            $('#modal-form-plan [name="plano_servico_id"]').val(plano.id);
            $('#modal-form-plan [name="categoria_servico_id"]').val(categoria_id);
            const servicos = [];
            plano.categorias_servicos.forEach(cs => {
                if (cs.categoria.id != categoria_id) return;
                servicos.push(cs.servico.id);
            });

            $('#modal-form-plan [name="servico_id"]').val(servicos);
            setOptionSelected();
        }
    }, 500);
}
/** Reinicia a lista de servicos 
 * @returns {void}
 */
function optionReset() {
    $('#form-config-plan [name="servico_id"] option').each(function () {
        $(this).prop('selected', false);
        $(this).text($(this).text().replace('✔', ''));
        $(this).removeClass('bg-black');
        $(this).removeClass('text-white');
    });
}
/**
 * Carrega os planos de servicos
 */
export function loadOptionsPlansList() {
    fetch('/api/v1/planos-servicos')
        .then(response => response.json())
        .then(data => {
            let planos = '<option value="">Escolha um plano</option>';
            data.forEach(plano => {
                planos += `<option value="${plano.id}">${plano.nome}</option>`;
            });
            $('#lista-planos').html(planos);
        })
}

function setOptionSelected() {
    $('#form-config-plan [name="servico_id"] option:selected').each(function () {
        $(this).html('&#x2714;' + $(this).text());
        $(this).addClass('bg-black');
        $(this).addClass('text-white');
    });
}

function savePlan() {
    const config = [];
    $('#lista-servicos option:selected').each(function () {
        config.push({
            plano_servico_id: $('#form-config-plan [name="plano_servico_id"]').val(),
            categoria_servico_id: $('#form-config-plan [name="categoria_servico_id"]').val(),
            servico_id: $(this).val() 
        });
    })

    fetch('/api/v1/plano', {
        method: 'POST',
        body: JSON.stringify(config),
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        }
    }).then(async response => { 
        const data = await response.json();
        if (response.ok) {
            $('#form-config-plan')[0].reset();
            loadPlansList();
            Swal.fire({
                icon: 'success',
                title: 'Sucesso',
                text: data.message
            })
        }
    }).catch(error => {
        console.error('Erro ao carregar os dados:', error);
    });

}