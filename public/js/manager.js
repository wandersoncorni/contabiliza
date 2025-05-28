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

/***/ "./resources/js/agents.js":
/*!********************************!*\
  !*** ./resources/js/agents.js ***!
  \********************************/
/***/ ((__unused_webpack_module, __unused_webpack_exports, __webpack_require__) => {

"use strict";
eval("/* provided dependency */ var $ = __webpack_require__(/*! jquery */ \"jquery\");\n/**\r\n * Scripts para pagina de consultores\r\n */\n\n\n$(document).ready(function () {\n  const tb = loadUsersTable('#tb-agents', '/api/v1/agents');\n});\n\n//# sourceURL=webpack://access-control/./resources/js/agents.js?");

/***/ }),

/***/ "./resources/js/clients.js":
/*!*********************************!*\
  !*** ./resources/js/clients.js ***!
  \*********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   init: () => (/* binding */ init)\n/* harmony export */ });\n/* harmony import */ var _users_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./users.js */ \"./resources/js/users.js\");\n/**\r\n * Scripts para pagina de consultores\r\n */\n\n\n\nfunction init() {\n  const tb = loadClientsTable();\n  _users_js__WEBPACK_IMPORTED_MODULE_0__.loadFilters(0, null, 1);\n}\nfunction loadClientsTable() {\n  const url = '/api/v1/clients';\n  return new DataTable('#tb-clients', {\n    ajax: function (data, callback, settings) {\n      fetch(url, {\n        method: 'GET',\n        headers: {\n          'Content-Type': 'application/json'\n        },\n        credentials: 'include'\n      }).then(response => response.json()).then(json => {\n        callback({\n          data: json\n        });\n      }).catch(error => {\n        console.error('Erro ao carregar os dados:', error);\n      });\n    },\n    columns: [{\n      data: data => _users_js__WEBPACK_IMPORTED_MODULE_0__.getUserData(data)\n    }, {\n      data: data => _users_js__WEBPACK_IMPORTED_MODULE_0__.getActive(data)\n    }, {\n      data: data => _users_js__WEBPACK_IMPORTED_MODULE_0__.formatDate(data.created_at)\n    }, {\n      data: data => _users_js__WEBPACK_IMPORTED_MODULE_0__.getButtons(data.id, url)\n    }],\n    columnDefs: [{\n      targets: [1, 2, 3],\n      orderable: false\n    }, {\n      targets: [0],\n      searchable: false\n    }]\n  });\n}\n\n//# sourceURL=webpack://access-control/./resources/js/clients.js?");

/***/ }),

/***/ "./resources/js/companies.js":
/*!***********************************!*\
  !*** ./resources/js/companies.js ***!
  \***********************************/
/***/ (() => {

eval("\n\n//# sourceURL=webpack://access-control/./resources/js/companies.js?");

/***/ }),

/***/ "./resources/js/consultants.js":
/*!*************************************!*\
  !*** ./resources/js/consultants.js ***!
  \*************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   init: () => (/* binding */ init)\n/* harmony export */ });\n/* harmony import */ var _users_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./users.js */ \"./resources/js/users.js\");\n/**\r\n * Scripts para pagina de consultores\r\n */\n\n\n\nfunction init() {\n  const tb = loadTable();\n  _users_js__WEBPACK_IMPORTED_MODULE_0__.loadFilters(0, null, 1);\n}\nfunction loadTable() {\n  const url = '/api/v1/consultants';\n  return new DataTable('#tb-consultants', {\n    ajax: function (data, callback, settings) {\n      fetch(url, {\n        method: 'GET',\n        headers: {\n          'Content-Type': 'application/json'\n        },\n        credentials: 'include'\n      }).then(response => response.json()).then(json => {\n        callback({\n          data: json\n        });\n      }).catch(error => {\n        console.error('Erro ao carregar os dados:', error);\n      });\n    },\n    columns: [{\n      data: data => _users_js__WEBPACK_IMPORTED_MODULE_0__.getUserData(data)\n    }, {\n      data: data => _users_js__WEBPACK_IMPORTED_MODULE_0__.getActive(data)\n    }, {\n      data: data => _users_js__WEBPACK_IMPORTED_MODULE_0__.formatDate(data.created_at)\n    }, {\n      data: data => _users_js__WEBPACK_IMPORTED_MODULE_0__.getButtons(data.id, url)\n    }],\n    columnDefs: [{\n      targets: [1, 2, 3],\n      orderable: false\n    }, {\n      targets: [0],\n      searchable: false\n    }]\n  });\n}\n\n//# sourceURL=webpack://access-control/./resources/js/consultants.js?");

/***/ }),

/***/ "./resources/js/manager.js":
/*!*********************************!*\
  !*** ./resources/js/manager.js ***!
  \*********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony import */ var _clients_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./clients.js */ \"./resources/js/clients.js\");\n/* harmony import */ var _consultants_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./consultants.js */ \"./resources/js/consultants.js\");\n/* harmony import */ var _agents_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./agents.js */ \"./resources/js/agents.js\");\n/* harmony import */ var _agents_js__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_agents_js__WEBPACK_IMPORTED_MODULE_2__);\n/* harmony import */ var _companies_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./companies.js */ \"./resources/js/companies.js\");\n/* harmony import */ var _companies_js__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_companies_js__WEBPACK_IMPORTED_MODULE_3__);\n/* harmony import */ var _partners_js__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./partners.js */ \"./resources/js/partners.js\");\n/* harmony import */ var _partners_js__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(_partners_js__WEBPACK_IMPORTED_MODULE_4__);\n/* harmony import */ var _portfolios_js__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./portfolios.js */ \"./resources/js/portfolios.js\");\n/* harmony import */ var _plans_js__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ./plans.js */ \"./resources/js/plans.js\");\n/* provided dependency */ var $ = __webpack_require__(/*! jquery */ \"jquery\");\n/**\r\n * Scripts para o modulo de gerenciamento\r\n */\n\n\n\n\n\n\n\n\n\n$(document).ready(function () {\n  $(document).on('page:loaded', function (e) {\n    const url = e.originalEvent.detail.url;\n    const modules = {\n      consultants: _consultants_js__WEBPACK_IMPORTED_MODULE_1__,\n      clients: _clients_js__WEBPACK_IMPORTED_MODULE_0__,\n      agents: _agents_js__WEBPACK_IMPORTED_MODULE_2__,\n      companies: _companies_js__WEBPACK_IMPORTED_MODULE_3__,\n      partners: _partners_js__WEBPACK_IMPORTED_MODULE_4__,\n      portfolios: _portfolios_js__WEBPACK_IMPORTED_MODULE_5__,\n      plans: _plans_js__WEBPACK_IMPORTED_MODULE_6__\n    };\n    const path = url.substr(1);\n    if (modules[path]) {\n      modules[path].init();\n    } else {\n      console.warn(\"Módulo não encontrado:\", path);\n    }\n  });\n});\n\n//# sourceURL=webpack://access-control/./resources/js/manager.js?");

/***/ }),

/***/ "./resources/js/partners.js":
/*!**********************************!*\
  !*** ./resources/js/partners.js ***!
  \**********************************/
/***/ (() => {

eval("\n\n//# sourceURL=webpack://access-control/./resources/js/partners.js?");

/***/ }),

/***/ "./resources/js/plans.js":
/*!*******************************!*\
  !*** ./resources/js/plans.js ***!
  \*******************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   init: () => (/* binding */ init)\n/* harmony export */ });\n/**\r\n * Scripts para pagina de consultores\r\n */\n\n\nfunction init() {\n  const tb = loadTable();\n}\nfunction loadTable() {\n  const url = '/api/v1/services-plans';\n  return new DataTable('#tb-plans', {\n    ajax: function (data, callback) {\n      fetch(url, {\n        method: 'GET',\n        headers: {\n          'Content-Type': 'application/json'\n        },\n        credentials: 'include'\n      }).then(response => response.json()).then(json => {\n        callback({\n          data: json\n        });\n      }).catch(error => {\n        console.error('Erro ao carregar os dados:', error);\n      });\n    },\n    columns: [{\n      data: 'name'\n    }, {\n      data: 'active'\n    }, {\n      data: 'created_at'\n    }, {\n      data: data => ''\n    }],\n    columnDefs: [{\n      targets: [1, 2, 3],\n      orderable: false\n    }, {\n      targets: [0],\n      searchable: false\n    }]\n  });\n}\n\n//# sourceURL=webpack://access-control/./resources/js/plans.js?");

/***/ }),

/***/ "./resources/js/portfolios.js":
/*!************************************!*\
  !*** ./resources/js/portfolios.js ***!
  \************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   init: () => (/* binding */ init)\n/* harmony export */ });\n/**\r\n * Scripts para pagina de portifólios do modulo de gerenciamento\r\n */\n\n\nfunction init() {\n  loadTable();\n}\nfunction loadTable() {\n  return new DataTable('#tb-portfolios', {\n    ajax: (data, callback) => fetch('/api/v1/portfolios', {\n      method: 'GET',\n      credentials: 'include'\n    }).then(response => response.json()).then(data => {\n      return callback({\n        data: data\n      });\n    }).catch(error => {\n      console.error('Erro ao carregar os dados:', error);\n    }),\n    columns: [{\n      data: 'name'\n    }, {\n      data: 'status'\n    }, {\n      data: 'created_at'\n    }, {\n      data: 'actions'\n    }],\n    columnDefs: [{\n      targets: [1, 2, 3],\n      orderable: false\n    }, {\n      targets: [0, 2],\n      searchable: false\n    }]\n  });\n}\n\n//# sourceURL=webpack://access-control/./resources/js/portfolios.js?");

/***/ }),

/***/ "./resources/js/users.js":
/*!*******************************!*\
  !*** ./resources/js/users.js ***!
  \*******************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   formatDate: () => (/* binding */ formatDate),\n/* harmony export */   getActive: () => (/* binding */ getActive),\n/* harmony export */   getButtons: () => (/* binding */ getButtons),\n/* harmony export */   getUserData: () => (/* binding */ getUserData),\n/* harmony export */   init: () => (/* binding */ init),\n/* harmony export */   loadFilters: () => (/* binding */ loadFilters),\n/* harmony export */   loadTable: () => (/* binding */ loadTable)\n/* harmony export */ });\n/* provided dependency */ var $ = __webpack_require__(/*! jquery */ \"jquery\");\n/**\r\n * Modulo de usuarios\r\n */\n\n\nfunction init() {\n  $('#users-table').on('click', '#check-all', function () {\n    $('#users-table tbody input[type=\"checkbox\"]').prop('checked', $(this).is(':checked'));\n  });\n  $('#new-user').on('click', function () {\n    if (!$('#role_id option').length) {\n      fetch('/api/v1/roles', {\n        method: 'GET',\n        headers: {\n          'Content-Type': 'application/json'\n        },\n        credentials: 'include'\n      }).then(response => response.json()).then(json => {\n        const roles = json.map(role => `<option value=\"${role.id}\">${role.name}</option>`);\n        roles.unshift('<option selected >Selecione um profile</option>');\n        $('#role_id').html(roles.join(''));\n      });\n    }\n    if (!$('#id_licensed option').length) {\n      fetch('/api/v1/licensed', {\n        method: 'GET',\n        headers: {\n          'Content-Type': 'application/json'\n        },\n        credentials: 'include'\n      }).then(response => response.json()).then(json => {\n        const licensed = json.map(licensed => `<option value=\"${licensed.id}\">${licensed.name}</option>`);\n        licensed.unshift('<option selected >Selecione um licenciado</option>');\n        $('#id_licensed').html(licensed.join(''));\n      });\n    }\n  });\n}\nfunction loadTable(url, table) {\n  return new DataTable(table, {\n    ajax: function (data, callback, settings) {\n      fetch(url, {\n        method: 'GET',\n        headers: {\n          'Content-Type': 'application/json'\n        },\n        credentials: 'include'\n      }).then(response => response.json()).then(json => {\n        callback({\n          data: json\n        });\n      }).catch(error => {\n        console.error('Erro ao carregar os dados:', error);\n      });\n    },\n    columns: [{\n      data: data => $('<input />', {\n        type: 'checkbox',\n        class: 'form-check-input',\n        id: `user-${data.id}`,\n        value: data.id\n      }).prop('outerHTML')\n    }, {\n      data: data => getUserData(data)\n    }, {\n      data: 'person.role_name'\n    }, {\n      data: data => getActive(data)\n    }, {\n      data: data => formatDate(data.created_at)\n    }, {\n      data: data => getButtons(data.id)\n    }],\n    columnDefs: [{\n      targets: [0, 2, 3, 4, 5],\n      orderable: false\n    }, {\n      targets: [0, 4, 5],\n      searchable: false\n    }]\n  });\n}\nfunction loadFilters(colSearch = 1, colProfile = 2, colStatus = 3) {\n  $('#search-users').on('keyup', function () {\n    const value = $(this).val();\n    if (value.length < 3) {\n      $('#users-table').DataTable().column(colSearch).search('').draw();\n      return;\n    }\n    $('#users-table').DataTable().column(colSearch).search(value).draw();\n  });\n  $('#filter-profile').on('change', function () {\n    const value = $(this).val();\n    if (value == 'todos') {\n      $('#users-table').DataTable().column(colProfile).search('').draw();\n      return;\n    }\n    $('#users-table').DataTable().column(colProfile).search(value).draw();\n  });\n  $('#filter-status').on('change', function () {\n    const value = $(this).val();\n    if (value == 'todos') {\n      $('#users-table').DataTable().column(colStatus).search('').draw();\n      return;\n    }\n    $('#users-table').DataTable().column(3).search(value).draw();\n  });\n  $('#clear-user-filters').on('click', function () {\n    $('#search-users').val('').trigger('keyup');\n    $('#filter-profile').val('todos').trigger('change');\n    $('#filter-status').val('todos').trigger('change');\n  });\n}\nfunction getUserData(data) {\n  return $('<div />', {\n    class: 'd-flex'\n  }).append([$('<img />', {\n    class: 'rounded-circle avatar bg-light me-3',\n    src: data.person.photo ?? '/img/user.png'\n  }), $('<div />').append([$('<h1 />', {\n    class: 'h5 mb-0 font-size-14'\n  }).text(data.person.name), $('<p />', {\n    class: 'text-muted font-size-12 mb-0'\n  }).append($('<i />', {\n    class: 'heroicon heroicon-envelope mt-1 me-1 float-start'\n  }), data.email)])]).prop('outerHTML');\n}\nfunction getButtons(uid, url = '/api/v1/users') {\n  return $('<div />').append([$('<button />', {\n    class: 'btn btn-link btn-transparent text-dark dropdown-toggle dropdown-toggle-split m-0 p-0',\n    type: 'button',\n    'data-bs-toggle': 'dropdown',\n    'aria-expanded': false,\n    'aria-haspopup': true\n  }).append($('<i />', {\n    class: 'heroicon heroicon-horizontal-elipsis float-start'\n  })), $('<div />', {\n    class: 'dropdown-menu dashboard-dropdown dropdown-menu-start mt-2 py-1'\n  }).append($('<a />', {\n    class: 'dropdown-item text-info',\n    href: `${url}/${uid}`,\n    'data-action': 'show'\n  }).append($('<i />', {\n    class: 'heroicon heroicon-eye me-2'\n  }), 'Ver'), $('<a />', {\n    class: 'dropdown-item text-primary',\n    href: `${url}/${uid}`,\n    'data-action': 'edit'\n  }).append($('<i />', {\n    class: 'heroicon heroicon-pencil-square me-2'\n  }), 'Editar'), $('<a />', {\n    class: 'dropdown-item text-danger',\n    href: `${url}/${uid}`,\n    'data-action': 'delete'\n  }).append($('<i />', {\n    class: 'heroicon heroicon-trash me-2'\n  }), 'Excluir'))]).prop('innerHTML');\n}\nfunction getActive(data) {\n  return data.active ? $('<span />', {\n    class: 'text-success'\n  }).text('Ativo').prop('outerHTML') : $('<span />', {\n    class: 'text-danger'\n  }).text('Inativo').prop('outerHTML');\n}\nfunction formatDate(date) {\n  return new Date(date).toLocaleDateString('pt-BR', {\n    year: 'numeric',\n    month: '2-digit',\n    day: '2-digit'\n  });\n}\n\n//# sourceURL=webpack://access-control/./resources/js/users.js?");

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
/******/ 	/* webpack/runtime/compat get default export */
/******/ 	(() => {
/******/ 		// getDefaultExport function for compatibility with non-harmony modules
/******/ 		__webpack_require__.n = (module) => {
/******/ 			var getter = module && module.__esModule ?
/******/ 				() => (module['default']) :
/******/ 				() => (module);
/******/ 			__webpack_require__.d(getter, { a: getter });
/******/ 			return getter;
/******/ 		};
/******/ 	})();
/******/ 	
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
/******/ 	var __webpack_exports__ = __webpack_require__("./resources/js/manager.js");
/******/ 	
/******/ })()
;