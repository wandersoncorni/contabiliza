/*
 * ATTENTION: The "eval" devtool has been used (maybe by default in mode: "development").
 * This devtool is neither made for production nor for readable output files.
 * It uses "eval()" calls to create a separate source file in the browser devtools.
 * If you are trying to read the output file, select a different devtool (https://webpack.js.org/configuration/devtool/)
 * or disable the default devtool with "devtool: false".
 * If you are looking for production-ready output files, see mode: "production" (https://webpack.js.org/configuration/mode/).
 */
/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./resources/js/plans.js":
/*!*******************************!*\
  !*** ./resources/js/plans.js ***!
  \*******************************/
/***/ ((__unused_webpack_module, __unused_webpack_exports, __webpack_require__) => {

eval("/* provided dependency */ var $ = __webpack_require__(/*! jquery */ \"jquery\");\n$(document).ready(function () {\n  fetch('/api/v1/plans', {\n    method: 'GET',\n    headers: {\n      'Content-Type': 'application/json'\n    },\n    credentials: 'include'\n  }).then(response => response.json()).then(data => {\n    // 1. Lista original dos planos\n    const planos = data;\n\n    // 2. Obter todas as categorias e seus serviços (únicos)\n    const mapaCategoriasGlobais = {};\n    planos.forEach(plano => {\n      plano.categorias_servicos.forEach(item => {\n        const cat = item.categoria.nome;\n        const serv = item.servico.nome;\n        if (!mapaCategoriasGlobais[cat]) {\n          mapaCategoriasGlobais[cat] = new Set();\n        }\n        mapaCategoriasGlobais[cat].add(serv);\n      });\n    });\n\n    // 3. Transformar Sets em arrays\n    const todasCategorias = {};\n    for (const [cat, servicos] of Object.entries(mapaCategoriasGlobais)) {\n      todasCategorias[cat] = Array.from(servicos);\n    }\n\n    // 4. Montar os planos com todas as categorias, marcando os serviços\n    const planosCompletos = planos.map(plano => {\n      const categorias = {};\n\n      // Criar um set com os serviços que o plano realmente possui\n      const servicosDoPlano = new Set(plano.categorias_servicos.map(item => `${item.categoria.nome}|${item.servico.nome}`));\n\n      // Iterar sobre todas as categorias/serviços globais\n      for (const [categoria, servicos] of Object.entries(todasCategorias)) {\n        categorias[categoria] = servicos.map(servico => {\n          const chave = `${categoria}|${servico}`;\n          return {\n            nome: servico,\n            checked: servicosDoPlano.has(chave)\n          };\n        });\n      }\n      const planoTag = plano.nome.toLowerCase();\n      $('.plans .cards').append($('<div>', {\n        class: 'col-12 col-lg-6 col-xl-4'\n      }).append($('<div>', {\n        class: `card mb-4 mb-xl-0 shadow plano-${planoTag}`\n      }).append($('<div>', {\n        class: 'card-header border-gray-100 py-4 px-4'\n      }).append($('<div>', {\n        class: 'd-flex mb-3'\n      }).append($('<span>', {\n        class: 'h5 mb-0'\n      }).text('A partir de'), $('<span>', {\n        class: 'price display-2 mb-0',\n        'data-annual': plano.valor_anual,\n        'data-monthly': plano.valor_mensal\n      }).text('R$' + formatCurrency(plano.valor_mensal)), $('<span>', {\n        class: 'h6 fw-normal align-self-end'\n      }).text('/mês')), $('<h2>', {\n        class: 'mb-3 text-black d-flex'\n      }).html(plano.nome + `<div class=\"border-rounded-circle bg-success tag-plano-${planoTag}\"></div>`)), $('<div>', {\n        class: 'card-body py-4 px-4'\n      }).append((() => {\n        const categoria_item = [];\n        Object.keys(categorias).map(categoria => {\n          const servicos = categorias[categoria].map(servico => $('<div>', {\n            class: 'd-flex align-items-center mb-3'\n          }).append($('<i>', {\n            class: `heroicon heroicon-${servico.checked ? 'check' : 'x'} text-${servico.checked ? 'success' : 'danger'} me-2`\n          }), $('<span>', {\n            class: 'text-black'\n          }).text(servico.nome)));\n          categoria_item.push($('<div>', {\n            class: 'mb-4'\n          }).append($('<div>', {\n            class: 'h5 fw-bolder mb-3'\n          }).text(categoria), servicos));\n        });\n        return categoria_item;\n      })()), $('<div>', {\n        class: 'card-footer border-gray-100 d-grid px-4 pb-4'\n      }).append($('<a>', {\n        class: `btn btn-metal btn-${planoTag} d-inline-flex align-items-center justify-content-center`,\n        href: `/plans/${plano.id}`\n      }).text('Assinar')))));\n    });\n  });\n  $('#app-content').on('change', '#billingSwitch', function () {\n    const isChecked = $(this).is(':checked');\n    $('.plans .cards').find('.card').each(function () {\n      const valorAnual = parseFloat($(this).find('.price').data('annual'));\n      const valorMensal = parseFloat($(this).find('.price').data('monthly'));\n      if (isChecked) {\n        animatePriceChange(valorMensal, valorAnual, $(this).find('.price'));\n      } else {\n        animatePriceChange(valorAnual, valorMensal, $(this).find('.price'));\n      }\n    });\n  });\n  $('#app-content').on('click', '#labelMensal, #labelAnual', function () {\n    if ($(this).prop('id') === 'labelMensal' && $('#billingSwitch').is(':checked')) {\n      $('#billingSwitch').prop('checked', false).trigger('change');\n    } else if ($(this).prop('id') === 'labelAnual' && !$('#billingSwitch').is(':checked')) {\n      $('#billingSwitch').prop('checked', true).trigger('change');\n    }\n  });\n});\nfunction animatePriceChange(start, end, display, duration = 1500) {\n  const startTime = performance.now();\n  const diff = end - start;\n  function easeInOut(t) {\n    // ease-in-out cubic\n    return t < 0.5 ? 4 * t * t * t : 1 - Math.pow(-2 * t + 2, 3) / 2;\n  }\n  function update(currentTime) {\n    const elapsed = currentTime - startTime;\n    const progress = Math.min(elapsed / duration, 1);\n    const easedProgress = easeInOut(progress);\n    const currentValue = start + diff * easedProgress;\n    display.text(formatCurrency(currentValue));\n    if (progress < 1) {\n      requestAnimationFrame(update);\n    }\n  }\n  requestAnimationFrame(update);\n}\nfunction formatCurrency(value) {\n  return value.toLocaleString(\"pt-BR\", {\n    style: \"currency\",\n    currency: \"BRL\",\n    minimumFractionDigits: 2\n  });\n}\n\n//# sourceURL=webpack://access-control/./resources/js/plans.js?");

/***/ }),

/***/ "jquery":
/*!*************************!*\
  !*** external "jQuery" ***!
  \*************************/
/***/ ((module) => {

"use strict";
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
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module can't be inlined because the eval devtool is used.
/******/ 	var __webpack_exports__ = __webpack_require__("./resources/js/plans.js");
/******/ 	
/******/ })()
;