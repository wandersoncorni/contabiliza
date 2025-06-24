/**
 * Scripts para pagina de empresas
 */
'use strict';
import * as helpers from '../helpers.js';

$(document).ready(function () {
    // Carrega a lista de empresas
    const tb = loadTable();
    $('#modal-form-company').on('show.bs.modal', function () {
        // Cria uma empresa
        $('#btn-save-company').on('click', function (e) {
            $('.is-invalid').removeClass('is-invalid');
            // const navtab = $('#form-company :required:first-of-type').parents('div.tab-pane').prop('id');
            // $(`#nav-tab a[href="#${navtab}"]`).tab('show');($('#form-company :required:first-of-type').parents('div.tab-pane').prop('id'));
            $('#form-company :required').each(function () {
                if ($(this).val() == '') {
                    console.log($(this).prop('name'));
                    if (!$('.is-invalid').length) {
                        const navtab = $(this).parents('div.tab-pane').prop('id');
                        $(`#nav-tab a[href="#${navtab}"]`).tab('show');
                    }
                    $(this).addClass('is-invalid');
                    e.preventDefault();
                    $(this).focus();
                }
            });
        });
        // Cria um socio
        $('#add-partner').on('click', function (e) {
            addPartner();
        });

        $('#capital_social').on('input', function () { helpers.formatCurrencyValue(this); });
        setupFormPartner();
        helpers.formatPercentage('.percentage');
        progressUpdate('.participacao');
        loadPlans();
    });
    $('#modal-form-company .modal-footer button').on('click', function () {
        const btnId = $(this).prop('id')
        if (btnId == 'btn-next') {
            nextStep();
            return;
        }
        else if (btnId == 'btn-prev') {
            prevStep();
        }
    });
});
// Carrega a lista de empresas
function loadTable() {
    return new DataTable('#tb-companies', {
        ajax: function (data, callback) {
            fetch('/api/v1/companies', {
                method: 'GET',
                credentials: 'include'
            }).then(async response => {
                if (!response.ok) {
                    callback({ data: [] });
                    return;
                }
                const data = await response.json();
                return callback({ data: data });
            });
        },
        columns: [
            { data: 'name' },
            { data: 'actions' }
        ],
        columnDefs: [
            { targets: [0], orderable: true, searchable: true },
            { targets: [1], orderable: false, searchable: false },
        ]
    });
}
// aplica a máscara no CPF
function formatCPF(field) {
    var value = $(field).val().replace(/\D/g, ''); // remove tudo que não for número

    if (value.length > 11) value = value.substring(0, 11); // limita a 11 dígitos

    // aplica a máscara
    if (value.length > 9) {
        value = value.replace(/(\d{3})(\d{3})(\d{3})(\d{1,2})/, "$1.$2.$3-$4");
    } else if (value.length > 6) {
        value = value.replace(/(\d{3})(\d{3})(\d{1,3})/, "$1.$2.$3");
    } else if (value.length > 3) {
        value = value.replace(/(\d{3})(\d{1,3})/, "$1.$2");
    }

    $(field).val(value);
}
// aplica a máscara no telefone
function formatFone(field) {
    var value = $(field).val().replace(/\D/g, ''); // remove tudo que não for número

    if (value.length > 11) value = value.substring(0, 11); // limita a 11 dígitos

    if (value.length >= 10) {
        // celular com 9 dígitos
        value = value.replace(/^(\d{2})(\d{5})(\d{4})$/, '($1) $2-$3');
    } else if (value.length >= 6) {
        // fixo com 8 dígitos
        value = value.replace(/^(\d{2})(\d{4})(\d{0,4})$/, '($1) $2-$3');
    } else if (value.length >= 3) {
        value = value.replace(/^(\d{2})(\d{0,5})$/, '($1) $2');
    } else if (value.length > 0) {
        value = value.replace(/^(\d{0,2})$/, '($1');
    }

    $(field).val(value);
}
function savePartner() {
    // Valida campos obrigatorios
    $('.is-invalid').removeClass('is-invalid');
    $('.invalid-feedback').remove();
    $('#form-partner :required').each(function () {
        if ($(this).val() == '') {
            $(this).addClass('is-invalid');
            $(this).parent().append('<div class="invalid-feedback">Campo obrigatorio</div>');
        }
    })
    if ($('.is-invalid').length) {
        return;
    }
    // Formata os dados
    const fields = $('#form-partner').serializeArray();
    const ln = [];
    fields.forEach(field => {
        console.log(field);
        if (field.value == '') return;
        const totalFields = $('[name = "nome[]"]').length;
        $('#nav-partners').append(
            $('<input />', { type: 'hidden', name: `${field.name}[${totalFields}]`, value: field.value })
        );
        if ((field.name) == 'nome') {
            ln.push(field.value);
        }
        else if (field.name == 'resp_rf' && field.value == '0') {
            ln.push('<strong class="text-danger">Não</strong>');
        }
        else if (field.name == 'resp_rf' && field.value == '1') {
            ln.push('<strong class="text-success">Sim</strong>');
        }
    });
    ln.push('<button type="button" class="btn btn-sm btn-danger delete-partner"><i class="fa fa-times"></i></button>');
    $('#tb-partners').DataTable().row.add(ln).draw();
    $('#modal-form-partner').modal('hide');
    $('#form-partner')[0].reset();
    $('#modal-form-company').modal('show');
}
// Salva os dados de criacao de uma nova empresa
function saveCompany() {
    const formData = new FormData(document.querySelector('#form-company'));
    formData.set('capital_social', helpers.clearCurrencyValue(formData.get('capital_social')));
    fetch('/api/v1/company', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            'accept': 'application/json'
        },
        body: formData
    }).then(async response => {
        if (!response.ok) {
            return;
        }
        const data = await response.json();
        location.href = '/company/' + data.id;
    });
}

function addPartner() {
    const accordionClone = $('#accordionForm1').clone(true);
    const count = $('.accordion').length + 1;
    accordionClone.prop({ id: `accordionForm${count}` });
    accordionClone.find('.accordion-button').attr({
        'data-bs-target': `#collapseForm${count}`,
        'aria-controls': `collapseForm${count}`
    }
    ).text(`Sócio ${count}`);
    accordionClone.find('.accordion-header').attr({ id: `headerForm${count}` });
    accordionClone.find('.accordion-collapse').prop({ id: `collapseForm${count}` })
        .attr({
            'aria-labelledby': `headerForm${count}`,
            'data-bs-parent': `#accordionForm${count}`
        });
    accordionClone.find('input').val('');
    accordionClone.find('[data-address="socio1"]').attr('data-address', `socio${count}`);
    $('.accordion:last-of-type').after(accordionClone);
}

function setupFormPartner() {
    $('.cpf').on('input', function () { formatCPF(this) });
    $('.phone').on('input', () => formatFone('.phone'));
    $('.cep').on('input', function () {
        helpers.cepFormat(this);
        helpers.getAddress(this);
    });
    $('.uf').append(
        (() => {
            let options = '';
            Object.keys(statesList).forEach(abbreviation => {
                options += `<option value="${abbreviation}">${statesList[abbreviation]}</option>`;
            });
            return options;
        })()
    )
}
// lista de estados para o select de uf
const statesList = {
    '': 'Selecione o Estado',
    'AC': 'Acre',
    'AL': 'Alagoas',
    'AP': 'Amapá',
    'AM': 'Amazonas',
    'BA': 'Bahia',
    'CE': 'Ceará',
    'DF': 'Distrito Federal',
    'ES': 'Espírito Santo',
    'GO': 'Goiás',
    'MA': 'Maranhão',
    'MT': 'Mato Grosso',
    'MS': 'Mato Grosso do Sul',
    'MG': 'Minas Gerais',
    'PA': 'Pará',
    'PB': 'Paraíba',
    'PR': 'Paraná',
    'PE': 'Pernambuco',
    'PI': 'Piauí',
    'RJ': 'Rio de Janeiro',
    'RN': 'Rio Grande do Norte',
    'RS': 'Rio Grande do Sul',
    'RO': 'Rondônia',
    'RR': 'Roraima',
    'SC': 'Santa Catarina',
    'SP': 'São Paulo',
    'SE': 'Sergipe',
    'TO': 'Tocantins'
}

function progressUpdate(field) {
    $(field).on('input', function () {
        let total = 0;
        $(field).each(function () {
            let textVal = $(this).val() ?? 0;
            let val = textVal.replace(/[^0-9.]/g, '');
            total += parseFloat(val);
            if (total > 100) total = 100;
        });

        $('.progress-bar').css('width', total + '%')
            .attr({ 'aria-valuenow': total })
            .removeClass(['bg-info', 'bg-success'])
            .addClass(`bg-${total == 100 ? 'success' : 'info'}`);
        $('.progress-info span').text(total + '%');
    });
}

function loadPlans() {
    fetch('/api/v1/plans', {
        method: 'GET',
        headers: {
            'accept': 'application/json'
        },
        credentials: 'include'
    }).then(async response => {
        if (!response.ok) {
            return;
        }
        const data = await response.json();
        const options = ['<option value="">Selecione um plano</option>'];
        data.forEach(plan => {
            options.push(`<option value="${plan.id}">${plan.nome}</option>`);
        });
        $('#plano_id').html(options.join(''));
    });
}

function nextStep() {
    let el = null;
    // Validação
    helpers.removeInvalidFeedback();
    $('.tab-pane.active :required').each(function () {
        if ($(this).val() == '') {
            helpers.addInvalidFeedback(this);
            el = this;
        }
        if(el != null && $('.tab-pane.active').prop('id') == 'nav-partners') {
            const parent = $(el).parents('.accordion-item');
            parent.addClass('is-invalid');
            if(!parent.children('#collapseForm1').hasClass('show')) {
                parent.find('button').click();
            }
        }
    });
    
    if ($('.is-invalid').length) {
        return;
    }
    // Passa para o proximo passo se não houver erros
    const nextStep = $('.step-wizard-item.current-item').next('.step-wizard-item');
    const nextTab = $('.tab-pane.active').next('.tab-pane');
    // Verifica se existe o proximo passo e retorna se não houver
    if(nextStep.length == 0) {
        $('#btn-next').addClass('disabled');
        $('#btn-save-company').removeClass('disabled');
        return;
    }
    // Passa para o proximo tab
    $('.tab-pane.active').removeClass('show active');
    nextTab.addClass('show active');
    // Passa para o proximo passo
    $('.current-item').removeClass('current-item');
    nextStep.addClass('current-item');
    $('#btn-prev').removeClass('disabled');

}

function prevStep() {
    const prev = $('.step-wizard-item.current-item').prev('.step-wizard-item');
    const prevTab = $('.tab-pane.active').prev('.tab-pane');
    // sempre desabilita o botão de salvar
    $('#btn-save-company').addClass('disabled');
    if(prev.length == 0) {
        $('#btn-prev').addClass('disabled');        
        return;
    }    
    // Volta ao tab anterior
    $('.tab-pane.active').removeClass('show active');
    prevTab.addClass('show active');
    // Volta ao passo anterior
    $('.current-item').removeClass('current-item');
    prev.addClass('current-item');
    $('#btn-next').removeClass('disabled');
}