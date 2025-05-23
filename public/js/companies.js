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

/***/ "./resources/js/companies.js":
/*!***********************************!*\
  !*** ./resources/js/companies.js ***!
  \***********************************/
/***/ ((__unused_webpack_module, __unused_webpack_exports, __webpack_require__) => {

eval("/* provided dependency */ var $ = __webpack_require__(/*! jquery */ \"jquery\");\n/**\r\n * Scripts para pagina de empresas\r\n */\n$(document).ready(function () {\n  const tb = new DataTable('#tb-companies', {\n    ajax: (data, callback) => fetch('/api/v1/companies', {\n      method: 'GET',\n      credentials: 'include'\n    }).then(response => response.json()).then(response => {\n      return callback({\n        data: response\n      });\n    }),\n    columns: [{\n      data: 'name'\n    }, {\n      data: 'actions'\n    }],\n    columnDefs: [{\n      targets: [0],\n      orderable: true,\n      searchable: true\n    }, {\n      targets: [1],\n      orderable: false,\n      searchable: false\n    }]\n  });\n  $('#new-company').click(function () {\n    newCompany();\n  });\n  $('#add-partner').click(function () {});\n  $('#cpf').on('input', function () {\n    var value = $(this).val().replace(/\\D/g, ''); // remove tudo que não for número\n\n    if (value.length > 11) value = value.substring(0, 11); // limita a 11 dígitos\n\n    // aplica a máscara\n    if (value.length > 9) {\n      value = value.replace(/(\\d{3})(\\d{3})(\\d{3})(\\d{1,2})/, \"$1.$2.$3-$4\");\n    } else if (value.length > 6) {\n      value = value.replace(/(\\d{3})(\\d{3})(\\d{1,3})/, \"$1.$2.$3\");\n    } else if (value.length > 3) {\n      value = value.replace(/(\\d{3})(\\d{1,3})/, \"$1.$2\");\n    }\n    $(this).val(value);\n  });\n  $('#telefone').on('input', function () {\n    var value = $(this).val().replace(/\\D/g, ''); // remove tudo que não for número\n\n    if (value.length > 11) value = value.substring(0, 11); // limita a 11 dígitos\n\n    if (value.length >= 10) {\n      // celular com 9 dígitos\n      value = value.replace(/^(\\d{2})(\\d{5})(\\d{4})$/, '($1) $2-$3');\n    } else if (value.length >= 6) {\n      // fixo com 8 dígitos\n      value = value.replace(/^(\\d{2})(\\d{4})(\\d{0,4})$/, '($1) $2-$3');\n    } else if (value.length >= 3) {\n      value = value.replace(/^(\\d{2})(\\d{0,5})$/, '($1) $2');\n    } else if (value.length > 0) {\n      value = value.replace(/^(\\d{0,2})$/, '($1');\n    }\n    $(this).val(value);\n  });\n});\nfunction newCompany() {\n  if ($.fn.dataTable.isDataTable('#tb-partners, #tb-billings')) {\n    $('#tb-partners, #tb-billings').DataTable().clear().draw();\n  } else {\n    const tbPartner = new DataTable('#tb-partners', {\n      columns: [{\n        data: 'name'\n      }, {\n        data: 'email'\n      }, {\n        data: 'actions'\n      }],\n      columnDefs: [{\n        targets: [0, 1],\n        orderable: true,\n        searchable: true\n      }, {\n        targets: [2],\n        orderable: false,\n        searchable: false\n      }]\n    });\n    const tbBillings = new DataTable('#tb-billings', {\n      columns: [{\n        data: 'descricao'\n      }, {\n        data: 'valor'\n      }, {\n        data: 'vencimento'\n      }, {\n        data: 'status'\n      }, {\n        data: 'actions'\n      }],\n      columnDefs: [{\n        targets: [0, 1],\n        orderable: true,\n        searchable: true\n      }, {\n        targets: [4],\n        orderable: false,\n        searchable: false\n      }]\n    });\n  }\n}\n\n//# sourceURL=webpack://access-control/./resources/js/companies.js?");

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
/******/ 	var __webpack_exports__ = __webpack_require__("./resources/js/companies.js");
/******/ 	
/******/ })()
;