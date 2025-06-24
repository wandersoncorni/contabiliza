/*
 * ATTENTION: The "eval" devtool has been used (maybe by default in mode: "development").
 * This devtool is neither made for production nor for readable output files.
 * It uses "eval()" calls to create a separate source file in the browser devtools.
 * If you are trying to read the output file, select a different devtool (https://webpack.js.org/configuration/devtool/)
 * or disable the default devtool with "devtool: false".
 * If you are looking for production-ready output files, see mode: "production" (https://webpack.js.org/configuration/mode/).
 */
/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./resources/js/company/index.js":
/*!***************************************!*\
  !*** ./resources/js/company/index.js ***!
  \***************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

eval("__webpack_require__.r(__webpack_exports__);\n/* harmony import */ var _helpers_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../helpers.js */ \"./resources/js/helpers.js\");\n/* provided dependency */ var $ = __webpack_require__(/*! jquery */ \"jquery\");\n/**\r\n * Scripts para pagina de empresas\r\n */\n\n\n\n$(document).ready(function () {\n  // Carrega a lista de empresas\n  const tb = loadTable();\n  $('#modal-form-company').on('show.bs.modal', function () {\n    // Cria uma empresa\n    $('#btn-save-company').on('click', function (e) {\n      $('.is-invalid').removeClass('is-invalid');\n      // const navtab = $('#form-company :required:first-of-type').parents('div.tab-pane').prop('id');\n      // $(`#nav-tab a[href=\"#${navtab}\"]`).tab('show');($('#form-company :required:first-of-type').parents('div.tab-pane').prop('id'));\n      $('#form-company :required').each(function () {\n        if ($(this).val() == '') {\n          console.log($(this).prop('name'));\n          if (!$('.is-invalid').length) {\n            const navtab = $(this).parents('div.tab-pane').prop('id');\n            $(`#nav-tab a[href=\"#${navtab}\"]`).tab('show');\n          }\n          $(this).addClass('is-invalid');\n          e.preventDefault();\n          $(this).focus();\n        }\n      });\n    });\n    // Cria um socio\n    $('#add-partner').on('click', function (e) {\n      addPartner();\n    });\n    $('#capital_social').on('input', function () {\n      _helpers_js__WEBPACK_IMPORTED_MODULE_0__.formatCurrencyValue(this);\n    });\n    setupFormPartner();\n    _helpers_js__WEBPACK_IMPORTED_MODULE_0__.formatPercentage('.percentage');\n    progressUpdate('.participacao');\n    loadPlans();\n  });\n  $('#modal-form-company .modal-footer button').on('click', function () {\n    const btnId = $(this).prop('id');\n    if (btnId == 'btn-next') {\n      nextStep();\n      return;\n    } else if (btnId == 'btn-prev') {\n      prevStep();\n    }\n  });\n});\n// Carrega a lista de empresas\nfunction loadTable() {\n  return new DataTable('#tb-companies', {\n    ajax: function (data, callback) {\n      fetch('/api/v1/companies', {\n        method: 'GET',\n        credentials: 'include'\n      }).then(async response => {\n        if (!response.ok) {\n          callback({\n            data: []\n          });\n          return;\n        }\n        const data = await response.json();\n        return callback({\n          data: data\n        });\n      });\n    },\n    columns: [{\n      data: 'name'\n    }, {\n      data: 'actions'\n    }],\n    columnDefs: [{\n      targets: [0],\n      orderable: true,\n      searchable: true\n    }, {\n      targets: [1],\n      orderable: false,\n      searchable: false\n    }]\n  });\n}\n// aplica a máscara no CPF\nfunction formatCPF(field) {\n  var value = $(field).val().replace(/\\D/g, ''); // remove tudo que não for número\n\n  if (value.length > 11) value = value.substring(0, 11); // limita a 11 dígitos\n\n  // aplica a máscara\n  if (value.length > 9) {\n    value = value.replace(/(\\d{3})(\\d{3})(\\d{3})(\\d{1,2})/, \"$1.$2.$3-$4\");\n  } else if (value.length > 6) {\n    value = value.replace(/(\\d{3})(\\d{3})(\\d{1,3})/, \"$1.$2.$3\");\n  } else if (value.length > 3) {\n    value = value.replace(/(\\d{3})(\\d{1,3})/, \"$1.$2\");\n  }\n  $(field).val(value);\n}\n// aplica a máscara no telefone\nfunction formatFone(field) {\n  var value = $(field).val().replace(/\\D/g, ''); // remove tudo que não for número\n\n  if (value.length > 11) value = value.substring(0, 11); // limita a 11 dígitos\n\n  if (value.length >= 10) {\n    // celular com 9 dígitos\n    value = value.replace(/^(\\d{2})(\\d{5})(\\d{4})$/, '($1) $2-$3');\n  } else if (value.length >= 6) {\n    // fixo com 8 dígitos\n    value = value.replace(/^(\\d{2})(\\d{4})(\\d{0,4})$/, '($1) $2-$3');\n  } else if (value.length >= 3) {\n    value = value.replace(/^(\\d{2})(\\d{0,5})$/, '($1) $2');\n  } else if (value.length > 0) {\n    value = value.replace(/^(\\d{0,2})$/, '($1');\n  }\n  $(field).val(value);\n}\nfunction savePartner() {\n  // Valida campos obrigatorios\n  $('.is-invalid').removeClass('is-invalid');\n  $('.invalid-feedback').remove();\n  $('#form-partner :required').each(function () {\n    if ($(this).val() == '') {\n      $(this).addClass('is-invalid');\n      $(this).parent().append('<div class=\"invalid-feedback\">Campo obrigatorio</div>');\n    }\n  });\n  if ($('.is-invalid').length) {\n    return;\n  }\n  // Formata os dados\n  const fields = $('#form-partner').serializeArray();\n  const ln = [];\n  fields.forEach(field => {\n    console.log(field);\n    if (field.value == '') return;\n    const totalFields = $('[name = \"nome[]\"]').length;\n    $('#nav-partners').append($('<input />', {\n      type: 'hidden',\n      name: `${field.name}[${totalFields}]`,\n      value: field.value\n    }));\n    if (field.name == 'nome') {\n      ln.push(field.value);\n    } else if (field.name == 'resp_rf' && field.value == '0') {\n      ln.push('<strong class=\"text-danger\">Não</strong>');\n    } else if (field.name == 'resp_rf' && field.value == '1') {\n      ln.push('<strong class=\"text-success\">Sim</strong>');\n    }\n  });\n  ln.push('<button type=\"button\" class=\"btn btn-sm btn-danger delete-partner\"><i class=\"fa fa-times\"></i></button>');\n  $('#tb-partners').DataTable().row.add(ln).draw();\n  $('#modal-form-partner').modal('hide');\n  $('#form-partner')[0].reset();\n  $('#modal-form-company').modal('show');\n}\n// Salva os dados de criacao de uma nova empresa\nfunction saveCompany() {\n  const formData = new FormData(document.querySelector('#form-company'));\n  formData.set('capital_social', _helpers_js__WEBPACK_IMPORTED_MODULE_0__.clearCurrencyValue(formData.get('capital_social')));\n  fetch('/api/v1/company', {\n    method: 'POST',\n    headers: {\n      'X-CSRF-TOKEN': $('meta[name=\"csrf-token\"]').attr('content'),\n      'accept': 'application/json'\n    },\n    body: formData\n  }).then(async response => {\n    if (!response.ok) {\n      return;\n    }\n    const data = await response.json();\n    location.href = '/company/' + data.id;\n  });\n}\nfunction addPartner() {\n  const accordionClone = $('#accordionForm1').clone(true);\n  const count = $('.accordion').length + 1;\n  accordionClone.prop({\n    id: `accordionForm${count}`\n  });\n  accordionClone.find('.accordion-button').attr({\n    'data-bs-target': `#collapseForm${count}`,\n    'aria-controls': `collapseForm${count}`\n  }).text(`Sócio ${count}`);\n  accordionClone.find('.accordion-header').attr({\n    id: `headerForm${count}`\n  });\n  accordionClone.find('.accordion-collapse').prop({\n    id: `collapseForm${count}`\n  }).attr({\n    'aria-labelledby': `headerForm${count}`,\n    'data-bs-parent': `#accordionForm${count}`\n  });\n  accordionClone.find('input').val('');\n  accordionClone.find('[data-address=\"socio1\"]').attr('data-address', `socio${count}`);\n  $('.accordion:last-of-type').after(accordionClone);\n}\nfunction setupFormPartner() {\n  $('.cpf').on('input', function () {\n    formatCPF(this);\n  });\n  $('.phone').on('input', () => formatFone('.phone'));\n  $('.cep').on('input', function () {\n    _helpers_js__WEBPACK_IMPORTED_MODULE_0__.cepFormat(this);\n    _helpers_js__WEBPACK_IMPORTED_MODULE_0__.getAddress(this);\n  });\n  $('.uf').append((() => {\n    let options = '';\n    Object.keys(statesList).forEach(abbreviation => {\n      options += `<option value=\"${abbreviation}\">${statesList[abbreviation]}</option>`;\n    });\n    return options;\n  })());\n}\n// lista de estados para o select de uf\nconst statesList = {\n  '': 'Selecione o Estado',\n  'AC': 'Acre',\n  'AL': 'Alagoas',\n  'AP': 'Amapá',\n  'AM': 'Amazonas',\n  'BA': 'Bahia',\n  'CE': 'Ceará',\n  'DF': 'Distrito Federal',\n  'ES': 'Espírito Santo',\n  'GO': 'Goiás',\n  'MA': 'Maranhão',\n  'MT': 'Mato Grosso',\n  'MS': 'Mato Grosso do Sul',\n  'MG': 'Minas Gerais',\n  'PA': 'Pará',\n  'PB': 'Paraíba',\n  'PR': 'Paraná',\n  'PE': 'Pernambuco',\n  'PI': 'Piauí',\n  'RJ': 'Rio de Janeiro',\n  'RN': 'Rio Grande do Norte',\n  'RS': 'Rio Grande do Sul',\n  'RO': 'Rondônia',\n  'RR': 'Roraima',\n  'SC': 'Santa Catarina',\n  'SP': 'São Paulo',\n  'SE': 'Sergipe',\n  'TO': 'Tocantins'\n};\nfunction progressUpdate(field) {\n  $(field).on('input', function () {\n    let total = 0;\n    $(field).each(function () {\n      let textVal = $(this).val() ?? 0;\n      let val = textVal.replace(/[^0-9.]/g, '');\n      total += parseFloat(val);\n      if (total > 100) total = 100;\n    });\n    $('.progress-bar').css('width', total + '%').attr({\n      'aria-valuenow': total\n    }).removeClass(['bg-info', 'bg-success']).addClass(`bg-${total == 100 ? 'success' : 'info'}`);\n    $('.progress-info span').text(total + '%');\n  });\n}\nfunction loadPlans() {\n  fetch('/api/v1/plans', {\n    method: 'GET',\n    headers: {\n      'accept': 'application/json'\n    },\n    credentials: 'include'\n  }).then(async response => {\n    if (!response.ok) {\n      return;\n    }\n    const data = await response.json();\n    const options = ['<option value=\"\">Selecione um plano</option>'];\n    data.forEach(plan => {\n      options.push(`<option value=\"${plan.id}\">${plan.nome}</option>`);\n    });\n    $('#plano_id').html(options.join(''));\n  });\n}\nfunction nextStep() {\n  let el = null;\n  // Validação\n  _helpers_js__WEBPACK_IMPORTED_MODULE_0__.removeInvalidFeedback();\n  $('.tab-pane.active :required').each(function () {\n    if ($(this).val() == '') {\n      _helpers_js__WEBPACK_IMPORTED_MODULE_0__.addInvalidFeedback(this);\n      el = this;\n    }\n    if (el != null && $('.tab-pane.active').prop('id') == 'nav-partners') {\n      const parent = $(el).parents('.accordion-item');\n      parent.addClass('is-invalid');\n      if (!parent.children('#collapseForm1').hasClass('show')) {\n        parent.find('button').click();\n      }\n    }\n  });\n  if ($('.is-invalid').length) {\n    return;\n  }\n  // Passa para o proximo passo se não houver erros\n  const nextStep = $('.step-wizard-item.current-item').next('.step-wizard-item');\n  const nextTab = $('.tab-pane.active').next('.tab-pane');\n  // Verifica se existe o proximo passo e retorna se não houver\n  if (nextStep.length == 0) {\n    $('#btn-next').addClass('disabled');\n    $('#btn-save-company').removeClass('disabled');\n    return;\n  }\n  // Passa para o proximo tab\n  $('.tab-pane.active').removeClass('show active');\n  nextTab.addClass('show active');\n  // Passa para o proximo passo\n  $('.current-item').removeClass('current-item');\n  nextStep.addClass('current-item');\n  $('#btn-prev').removeClass('disabled');\n}\nfunction prevStep() {\n  const prev = $('.step-wizard-item.current-item').prev('.step-wizard-item');\n  const prevTab = $('.tab-pane.active').prev('.tab-pane');\n  // sempre desabilita o botão de salvar\n  $('#btn-save-company').addClass('disabled');\n  if (prev.length == 0) {\n    $('#btn-prev').addClass('disabled');\n    return;\n  }\n  // Volta ao tab anterior\n  $('.tab-pane.active').removeClass('show active');\n  prevTab.addClass('show active');\n  // Volta ao passo anterior\n  $('.current-item').removeClass('current-item');\n  prev.addClass('current-item');\n  $('#btn-next').removeClass('disabled');\n}\n\n//# sourceURL=webpack://access-control/./resources/js/company/index.js?");

/***/ }),

/***/ "./resources/js/helpers.js":
/*!*********************************!*\
  !*** ./resources/js/helpers.js ***!
  \*********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   addInvalidFeedback: () => (/* binding */ addInvalidFeedback),\n/* harmony export */   cepFormat: () => (/* binding */ cepFormat),\n/* harmony export */   clearCurrencyValue: () => (/* binding */ clearCurrencyValue),\n/* harmony export */   curencyFormat: () => (/* binding */ curencyFormat),\n/* harmony export */   formatCurrencyValue: () => (/* binding */ formatCurrencyValue),\n/* harmony export */   formatPercentage: () => (/* binding */ formatPercentage),\n/* harmony export */   getAddress: () => (/* binding */ getAddress),\n/* harmony export */   removeInvalidFeedback: () => (/* binding */ removeInvalidFeedback)\n/* harmony export */ });\n/* provided dependency */ var $ = __webpack_require__(/*! jquery */ \"jquery\");\n/**\r\n * Classe para armazenar funcoes utilitarias\r\n */\n\n\n/**\r\n * Formata o valor do campo monetario\r\n * @param {string} field O seletor do campo\r\n */\nfunction formatCurrencyValue(field) {\n  $(field).on('input', function () {\n    let valor = $(this).val();\n    valor = valor.replace(/\\D/g, '');\n    valor = (Number(valor) / 100).toFixed(2);\n    $(this).val(new Intl.NumberFormat('pt-BR', {\n      style: 'currency',\n      currency: 'BRL'\n    }).format(valor));\n  });\n}\n/**\r\n * Sanitiza o valor dos campos com a classe \"currency\"\r\n * @param {string} field\r\n * @returns\r\n */\nfunction clearCurrencyValue(value) {\n  return value.replace(/[^\\d,]/g, '').replace('.', '').replace(',', '.');\n}\n/**\r\n * Formata o valor para o padrao monetario brasileiro\r\n * @param {String} value\r\n * @returns\r\n */\nfunction curencyFormat(value) {\n  return new Intl.NumberFormat('pt-BR', {\n    style: 'currency',\n    currency: 'BRL'\n  }).format(value);\n}\n/**\r\n * Formata o cep\r\n * @param {*} field \r\n */\nfunction cepFormat(field) {\n  // Remove tudo que não for número\n  let value = $(field).val().replace(/\\D/g, '');\n\n  // Limita a 8 dígitos\n  if (value.length > 8) {\n    value = value.substring(0, 8);\n  }\n\n  // Aplica o formato 00000-000\n  if (value.length > 5) {\n    value = value.substring(0, 5) + '-' + value.substring(5);\n  }\n  $(field).val(value);\n}\n/**\r\n * Busca o endereço pelo cep\r\n */\nfunction getAddress(field) {\n  if ($(field).val().length == 9) {\n    const seletor = $(field).data('address');\n    fetch('https://viacep.com.br/ws/' + $(field).val() + '/json/', {\n      method: 'GET',\n      dataType: 'json'\n    }).then(async response => {\n      if (!response.ok) {\n        return;\n      }\n      const data = await response.json();\n      $(`[data-address=\"${seletor}\"]`).each(function () {\n        Object.keys(data).forEach(d => {\n          if ($(this).prop('name').includes(d)) {\n            $(this).val(data[d]);\n          }\n        });\n      });\n    });\n  }\n}\nfunction formatPercentage(field) {\n  $(field).on('input', function () {\n    let val = $(this).val();\n    val = sanitizeInput(val);\n    if (val.length > 5) {\n      val = val.substring(0, 5);\n    }\n    if (val > 100) {\n      val = val / 10;\n    }\n    $(this).val(val + (val !== '' ? '%' : ''));\n  });\n  $(field).on('focus', function () {\n    let val = $(this).val();\n    $(this).val(val.replace('%', ''));\n  });\n  $(field).on('blur', function () {\n    let val = sanitizeInput($(this).val());\n    val = clampToPercentage(val);\n    if (val !== '') {\n      $(this).val(val + '%');\n    } else {\n      $(this).val('');\n    }\n  });\n}\nfunction sanitizeInput(val) {\n  // Permitir só números e um único ponto\n  val = val.replace(/[^0-9.]/g, '');\n  let partes = val.split('.');\n  if (partes.length > 2) {\n    val = partes[0] + '.' + partes[1];\n  }\n  return val;\n}\nfunction clampToPercentage(val) {\n  let num = parseFloat(val);\n  if (isNaN(num)) return '';\n  if (num < 0) num = 0;\n  if (num > 100) num = 100;\n  return num.toString();\n}\nfunction addInvalidFeedback(field, message = 'Campo obrigatório!') {\n  $(field).addClass('is-invalid');\n  $(field).after('<div class=\"invalid-feedback\">' + message + '</div>');\n}\nfunction removeInvalidFeedback() {\n  $('.is-invalid').removeClass('is-invalid');\n  $('.invalid-feedback').remove();\n}\n\n//# sourceURL=webpack://access-control/./resources/js/helpers.js?");

/***/ }),

/***/ "jquery":
/*!*************************!*\
  !*** external "jQuery" ***!
  \*************************/
/***/ ((module) => {

module.exports = jQuery;

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/define property getters */
/******/ 	(() => {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = (exports, definition) => {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module can't be inlined because the eval devtool is used.
/******/ 	var __webpack_exports__ = __webpack_require__("./resources/js/company/index.js");
/******/ 	
/******/ })()
;