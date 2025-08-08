/**
 * Script para o formulário de socio
 */
'use strict';

import * as helpers from '../helpers.js';

const estadosCivis = [
    { value: '', label: 'Escolha uma opção' },
    { value: 1, label: 'Solteiro' },
    { value: 2, label: 'Casado' },
    { value: 3, label: 'Separado Judicialmente' },
    { value: 4, label: 'Divorciado' },
    { value: 5, label: 'Viúvo' },
    { value: 6, label: 'Desquitado' },
    { value: 7, label: 'União Consensual' },
    { value: 8, label: 'Ignorado' }
];

const estados = [
    { value: '', label: 'Escolha um estado' },
    { value: 'AC', label: 'Acre' },
    { value: 'AL', label: 'Alagoas' },
    { value: 'AP', label: 'Amapá' },
    { value: 'AM', label: 'Amazonas' },
    { value: 'BA', label: 'Bahia' },
    { value: 'CE', label: 'Ceará' },
    { value: 'DF', label: 'Distrito Federal' },
    { value: 'ES', label: 'Espírito Santo' },
    { value: 'GO', label: 'Goiás' },
    { value: 'MA', label: 'Maranhão' },
    { value: 'MT', label: 'Mato Grosso' },
    { value: 'MS', label: 'Mato Grosso do Sul' },
    { value: 'MG', label: 'Minas Gerais' },
    { value: 'PA', label: 'Pará' },
    { value: 'PB', label: 'Paraíba' },
    { value: 'PR', label: 'Paraná' },
    { value: 'PE', label: 'Pernambuco' },
    { value: 'PI', label: 'Piauí' },
    { value: 'RJ', label: 'Rio de Janeiro' },
    { value: 'RN', label: 'Rio Grande do Norte' },
    { value: 'RS', label: 'Rio Grande do Sul' },
    { value: 'RO', label: 'Rondônia' },
    { value: 'RR', label: 'Roraima' },
    { value: 'SC', label: 'Santa Catarina' },
    { value: 'SP', label: 'São Paulo' },
    { value: 'SE', label: 'Sergipe' },
    { value: 'TO', label: 'Tocantins' }
];

let partnerCount = 0;

function buildSelectOptions(options) {
    try {
        return options.map(opt => `<option value="${opt.value}">${opt.label}</option>`).join('');
    }
    catch (e) {
        return options.forEach(opt => `<option value="${opt.id}">${opt.nome}</option>`).join('');
    }

}

export function createPartnerForm() {
    partnerCount++;
    const partnerId = `partner-${partnerCount}`;
    const accordionId = `accordionForm${partnerCount}`;
    const collapseId = `collapseForm${partnerCount}`;
    const headerId = `headerForm${partnerCount}`;

    const formHtml = `
    <div class="accordion mb-3" id="${accordionId}">
      <div class="accordion-item">
        <h2 class="accordion-header" id="${headerId}">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#${collapseId}" aria-expanded="false" aria-controls="${collapseId}">
            <label class="form-label m-0" style="font-size: 18px;">Sócio</label>
          </button>
        </h2>
        <div id="${collapseId}" class="accordion-collapse collapse" aria-labelledby="${headerId}" data-bs-parent="#${accordionId}">
          <div class="accordion-body bg-white">
            <div class="col-lg-12 mb-3 text-end">
              <button type="button" class="btn btn-danger d-inline-flex align-items-center me-2 remove-partner">
                <i class="heroicon heroicon-trash"></i> Excluir
              </button>
            </div>

            <!-- Dados pessoais -->
            <div class="col-lg-12 col-md-12 bg-gray-100 rounded-lg shadow p-4 mb-3">
              <h5 class="mb-3">Dados pessoais</h5>
              <div class="row mb-3">
                <div class="col-lg-6 col-md-5">
                  <label class="form-label">Nome</label>
                  <input type="text" class="form-control" name="socio[][nome]" required />
                </div>
                <div class="col-lg-3 col-md-3">
                  <label class="form-label">CPF</label>
                  <input type="text" class="form-control cpf" name="socio[][cpf]" required />
                </div>
                <div class="col-lg-3 col-md-3">
                  <label class="form-label">Telefone</label>
                  <input type="text" class="form-control phone" name="socio[][telefone]" required />
                </div>
              </div>
              <div class="row mb-3">
                <div class="col-6">
                  <label class="form-label">E-mail</label>
                  <input type="email" class="form-control" name="socio[][email]" required />
                </div>
                <div class="col-6">
                  <label class="form-label">Profissão</label>
                  <input type="text" class="form-control" name="socio[][profissao]" required />
                </div>
              </div>
              <div class="row mb-3">
                <div class="col-6">
                  <label class="form-label">Estado Civil</label>
                  <select class="form-select estado-civil" name="socio[][estado_civil]" required >
                    ${buildSelectOptions(estadosCivis)}
                  </select>
                </div>
                <div class="col-6">
                  <label class="form-label">Regime de Bens</label>
                    <select class="form-select" name="socio[][regime_bens]" id="regimes_bens" disabled >
                  </select>
                </div>
              </div>
            </div>

            <!-- Endereço -->
            <div class="col-lg-12 col-md-12 bg-gray-100 rounded-lg shadow p-4 mb-3">
              <h5 class="mb-3">Endereço</h5>
              <div class="row mb-3">
                <div class="col-lg-2">
                  <label class="form-label">CEP</label>
                  <input type="text" name="socio[][cep]" data-address="${partnerId}" class="form-control cep-partner" required />
                </div>
                <div class="col-lg-4">
                  <label class="form-label">Logradouro</label>
                  <input type="text" name="socio[][logradouro]" data-address="${partnerId}" class="form-control" required />
                </div>
                <div class="col-lg-2">
                  <label class="form-label">Número</label>
                  <input type="text" name="socio[][numero]" data-address="${partnerId}" class="form-control" />
                </div>
                <div class="col-lg-4">
                  <label class="form-label">Complemento</label>
                  <input type="text" name="socio[][complemento]" data-address="${partnerId}" class="form-control" />
                </div>
                <div class="col-lg-4">
                  <label class="form-label">Bairro</label>
                  <input type="text" name="socio[][bairro]" data-address="${partnerId}" class="form-control" required />
                </div>
                <div class="col-lg-4">
                  <label class="form-label">Município</label>
                  <input type="text" name="socio[][localidade]" data-address="${partnerId}" class="form-control" required />
                </div>
                <div class="col-lg-4">
                  <label class="form-label">Estado</label>
                  <select name="socio[][uf]" data-address="${partnerId}" class="form-select uf" required>
                    ${buildSelectOptions(estados)}
                  </select>
                </div>
              </div>
            </div>

            <!-- Participação -->
            <div class="col-lg-12 col-md-12 bg-gray-100 rounded-lg shadow p-4 mb-3">
              <h5 class="mb-3">Participação societária</h5>
              <div class="row">
                <div class="col-12 d-flex align-items-center mb-3">
                  <label class="form-label me-3">Prolabore</label>
                  <input type="checkbox" class="form-check-input" name="socio[][prolabore]" value="1">
                </div>
                <div class="col-12 d-flex align-items-center mb-3">
                  <label class="form-label me-3">Participação (%)</label>
                  <input type="text" class="form-control percentage participacao" style="width: 70px;" name="socio[][participacao]" placeholder="0%" required />
                </div>
                <div class="col-12 d-flex align-items-center">
                  <label class="form-label me-3">Responsável perante a Receita Federal</label>
                  <input type="checkbox" class="form-check-input" name="socio[][resp_rf]" value="1">
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>`;

    $('#partners-container').append(formHtml);
    listarRegimeBens();
    $(document).on('change', '.estado-civil', function () {
        if (this.value == 2) {
            $('#regimes_bens').prop('disabled', false);
            return;
        }
        $('#regimes_bens').prop('disabled', true);
    });
    
    setupFormPartner();
}

/**
 * @function setupFormPartner
 * @description Sets up the form for partner input fields, including formatting and event listeners.
 */
function setupFormPartner() {
    $('.cpf').on('input', function () { helpers.cpfFormat(this) });
    $('.phone').on('input', () => helpers.foneFormat('.phone'));
    $('.cep-partner').on('input', function () {
        helpers.cepFormat(this);
        helpers.getAddress(this);
    });
    $('.uf').append(
        (() => {
            let options = '';
            const statesList = helpers.statesList;
            Object.keys(statesList).forEach(abbreviation => {
                options += `<option value="${abbreviation}">${statesList[abbreviation]}</option>`;
            });
            return options;
        })()
    )
}

async function listarRegimeBens() {
    const response = await fetch('/api/v1/regime-bens', { method: 'GET' });
    const regimesBens = await response.json();
    $('#regimes_bens option').remove();
    $('#regimes_bens').append(`<option value="">Selecione uma opção</option>`);
    regimesBens.forEach(regimeBens => {
        $('#regimes_bens').append(`<option value="${regimeBens.id}">${regimeBens.nome}</option>`);
    });
}