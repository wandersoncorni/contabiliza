/**
 * Script para o formulário de socio
 */
'use strict';

import * as helpers from '../helpers.js';

let partnerCount = 0;

export function createPartnerForm() {
    partnerCount++;
    const selector = `partner-${partnerCount}`;
    const accordionId = `accordionForm${partnerCount}`;
    const collapseId = `collapseForm${partnerCount}`;
    const headerId = `headerForm${partnerCount}`;
    const formId = `form-partner-${partnerCount}`;
    const formHtml = `
    <form id="${formId}">
        <div class="accordion mb-3" id="${accordionId}">
            <div class="accordion-item">
                <h2 class="accordion-header" id="${headerId}">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#${collapseId}" aria-expanded="false" aria-controls="${collapseId}">
                    <label class="form-label m-0 label-name" style="font-size: 18px;">Sócio</label>
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
                                    <input type="text" class="form-control" name="nome" required />
                                    <input type="hidden" name="id" id="id" value="" />
                                </div>
                                <div class="col-lg-3 col-md-3">
                                    <label class="form-label">CPF</label>
                                    <input type="text" class="form-control cpf" name="cpf" required />
                                </div>
                                <div class="col-lg-3 col-md-3">
                                    <label class="form-label">Telefone</label>
                                    <input type="text" class="form-control phone" name="telefone" required />
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-6">
                                    <label class="form-label">E-mail</label>
                                    <input type="email" class="form-control" name="email" required />
                                </div>
                                <div class="col-6">
                                    <label class="form-label">Profissão</label>
                                    <input type="text" class="form-control" name="profissao" required />
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-6">
                                    <label class="form-label">Estado Civil</label>
                                    <select class="form-select estado-civil" name="estado_civil" required ></select>
                                </div>
                                <div class="col-6">
                                <label class="form-label">Regime de Bens</label>
                                    <select class="form-select" name="regime_bens" id="regimes_bens" disabled >
                                </select>
                                </div>
                            </div>
                        </div>

                        <!-- Endereço -->
                        <div class="col-lg-12 col-md-12 bg-gray-100 rounded-lg shadow p-4 mb-3">
                            <h5 class="mb-3">Endereço</h5>
                            <div class="row mb-3">
                                <div class="col-lg-2 mb-3">
                                    <label class="form-label">CEP</label>
                                    <input type="text" name="cep" data-address="${selector}" class="form-control cep-partner" required />
                                </div>
                                <div class="col-lg-4 mb-3">
                                    <label class="form-label">Logradouro</label>
                                    <input type="text" name="logradouro" data-address="${selector}" class="form-control" required />
                                </div>
                                <div class="col-lg-2 mb-3">
                                    <label class="form-label">Número</label>
                                    <input type="text" name="numero" data-address="${selector}" class="form-control" />
                                </div>
                                <div class="col-lg-4 mb-3">
                                    <label class="form-label">Complemento</label>
                                    <input type="text" name="complemento" data-address="${selector}" class="form-control" />
                                </div>
                                <div class="col-lg-4 mb-3">
                                    <label class="form-label">Bairro</label>
                                    <input type="text" name="bairro" data-address="${selector}" class="form-control" required />
                                </div>
                                <div class="col-lg-4 mb-3">
                                    <label class="form-label">Município</label>
                                    <input type="text" name="localidade" data-address="${selector}" class="form-control" required />
                                </div>
                                <div class="col-lg-4 mb-3">
                                    <label class="form-label">Estado</label>
                                    <select name="estado" data-address="${selector}" class="form-select uf" required></select>
                                </div>
                            </div>
                        </div>

                        <!-- Participação -->
                        <div class="col-lg-12 col-md-12 bg-gray-100 rounded-lg shadow p-4 mb-3">
                            <h5 class="mb-3">Participação societária</h5>
                            <div class="row">
                                <div class="col-12 d-flex align-items-center mb-3">
                                    <label class="form-label me-3">Prolabore:</label>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="pro_labore" value="0" id="pro_labore_${partnerCount}0" checked />
                                        <label class="form-check-label" for="pro_labore_${partnerCount}0">não</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="pro_labore" value="1" id="pro_labore_${partnerCount}1" />
                                        <label class="form-check-label" for="pro_labore_${partnerCount}1">sim</label>
                                    </div>
                                </div>
                                <div class="col-12 d-flex align-items-center mb-3">
                                    <label class="form-label me-3">Participação (%)</label>
                                    <input type="text" class="form-control percentage participacao me-2" style="width: 70px;" name="participacao" value="0%" placeholder="0%" required />
                                </div>
                                <div class="col-12 d-flex align-items-center">
                                    <label class="form-label me-3">Responsável perante a Receita Federal:</label>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="resp_rf" value="0" id="resp_rf_${partnerCount}0" checked />
                                        <label class="form-check-label" for="resp_rf_${partnerCount}0">não</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="resp_rf" value="1" id="resp_rf_${partnerCount}1" />
                                        <label class="form-check-label" for="resp_rf_${partnerCount}1">sim</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>`;

    $('#partners-container').append(formHtml);

    listarRegimeBens(formId);
    listarEstadosCivis(formId);

    helpers.listStates(`#${formId} [name="estado"]`);

    $(document).on('change', `#${formId} [name="estado_civil"]`, function () {
        if (this.value == 2) {
            $(`#${formId} [name="regime_bens"]`).prop('disabled', false);
            return;
        }
        $(`#${formId} [name="regime_bens"]`).prop('disabled', true);
    });

    setupFormPartner(formId);
}

/**
 * @function setupFormPartner
 * @description Sets up the form for partner input fields, including formatting and event listeners.
 */
function setupFormPartner(formId) {
    $(`#${formId} [name="cpf"]`).on('input', function () { helpers.cpfFormat(this) });
    $(`#${formId} [name="telefone"]`).on('input', function () { helpers.foneFormat(this) });
    $(`#${formId} [name="cep"]`).on('input', function () {
        helpers.cepFormat(this);
        helpers.getAddress(this);
        if($(`#${formId} [name="id"]`).val()){
            ['logradouro', 'bairro', 'localidade','estado'].forEach(field => {
                $(`#${formId} [name="${field}"]`).attr('data-changed', true);
            });
        }
    });
    //Detecta alterações e marca o campo como alterado
    $(`#${formId} input, #${formId} email, #${formId} select, #${formId} :checkbox`).on('change', function(){
        if($(`#${formId} [name="id"]`).val()){
            $(this).attr('data-changed', 'true');
        }
    });
}
let listaRegimesBens = [];
/**
 * @function listarRegimeBens
 * @description Fetches the list of property regimes from the API and populates the select element.
 * @param {number} pid - The ID of the partner being added.
 */
async function listarRegimeBens(formId) {
    const field = $(`#${formId} [name="regime_bens"]`);
    if (listaRegimesBens.length == 0) {
        const response = await fetch('/api/v1/regime-bens', { method: 'GET' });
        const regimesBens = await response.json();
        listaRegimesBens = regimesBens;
    }
    field.html(`<option value="">Selecione uma opção</option>`);
    listaRegimesBens.forEach(regimeBens => {
        field.append(`<option value="${regimeBens.id}">${regimeBens.nome}</option>`);
    });
}

let listaEstadosCivis = [];
async function listarEstadosCivis(formId) {
    const field = $(`#${formId} [name="estado_civil"]`);
    if (listaEstadosCivis.length == 0) {
        const response = await fetch('/api/v1/auxiliares/listar-estado-civil');
        listaEstadosCivis = await response.json();
    }
    field.html(`<option value="">Selecione uma opção</option>`);
    listaEstadosCivis.forEach(estadoCivil => {
        field.append(`<option value="${estadoCivil.id}">${estadoCivil.descricao}</option>`);
    });
}