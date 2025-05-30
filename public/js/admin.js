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

/***/ "./resources/js/admin.js":
/*!*******************************!*\
  !*** ./resources/js/admin.js ***!
  \*******************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

eval("__webpack_require__.r(__webpack_exports__);\n/* harmony import */ var _licensed_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./licensed.js */ \"./resources/js/licensed.js\");\n/* harmony import */ var _users_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./users.js */ \"./resources/js/users.js\");\n/* provided dependency */ var $ = __webpack_require__(/*! jquery */ \"jquery\");\n/**\r\n * Scripts para funcoes de administracao\r\n */\n\n\n$(document).ready(function () {\n  if (sessionStorage.getItem('licensed_context') !== null) {\n    buildLicensedMenu();\n  }\n  // Carrega a tabela e adiciona os eventos\n  $(document).on('page:loaded', function (e) {\n    const url = e.originalEvent.detail.url;\n    if (url == '/licensed') {\n      _licensed_js__WEBPACK_IMPORTED_MODULE_0__.init();\n    } else if (url == '/users') {\n      _users_js__WEBPACK_IMPORTED_MODULE_1__.init();\n    }\n  });\n  $('#app-content').on('click', '#tb-licensed tbody tr td:last-child button', function () {\n    sessionStorage.setItem('licensed_context', JSON.stringify({\n      id: $(this).attr('data-id'),\n      name: $(this).attr('data-name')\n    }));\n    buildLicensedMenu();\n  });\n});\nfunction buildLicensedMenu() {\n  const licensed = JSON.parse(sessionStorage.getItem('licensed_context'));\n  if ($('#sidebarMenuLicensed').length > 0) {\n    $('#sidebarMenuLicensed').remove();\n  }\n  const menuItens = [{\n    label: 'Consultores',\n    icon: 'heroicon-users',\n    route: '/consultants'\n  }, {\n    label: 'Clientes',\n    icon: 'heroicon-users',\n    route: '/clients'\n  }, {\n    label: 'Agentes',\n    icon: 'heroicon-users',\n    route: '/agents'\n  }];\n  const menu = [$('<li />').append($('<h6 />', {\n    class: 'nav-heading'\n  }).html(`<h5>${licensed.name}</h5>`))];\n  $('#sidebarMenu .sidebar-inner').append($('<ul />', {\n    class: 'nav flex-column pt-3 pt-md-0 mt-3'\n  }).append((() => {\n    menuItens.forEach(item => {\n      menu.push($('<li />', {\n        class: 'nav-item'\n      }).append($('<a />', {\n        class: 'nav-link',\n        href: item.route\n      }).append($('<i />', {\n        class: `heroicon ${item.icon} float-start me-2`\n      }), item.label)));\n    });\n    return menu;\n  })()).prop({\n    id: 'sidebarMenuLicensed'\n  }));\n  $('#sidebarMenu').on('click', '#sidebarMenuLicensed a', function (e) {\n    e.preventDefault();\n    $('#sidebarMenu ul li, #sidebarMenuLicensed ul li').removeClass('active');\n    $(this).parent().addClass('active');\n    fetch($(this).attr('href'), {\n      method: 'GET',\n      headers: {\n        'Content-Type': 'application/json'\n      },\n      credentials: 'include'\n    }).then(response => {\n      if (response.status === 200) {\n        return response.text();\n      } else if (response.status === 404) {\n        Swal.fire({\n          icon: 'error',\n          title: 'Página não encontrada!',\n          text: \"A página que você tentou acessar não foi encontrada.\"\n        });\n      } else {\n        Swal.fire({\n          icon: 'error',\n          title: 'Erro ao tentar acessar a página!',\n          text: \"Ocorreu um erro interno ao tentar acessar a página.\"\n        });\n      }\n    }).then(html => {\n      $('#app-content').html(html);\n    });\n  });\n}\n\n//# sourceURL=webpack://access-control/./resources/js/admin.js?");

/***/ }),

/***/ "./resources/js/licensed.js":
/*!**********************************!*\
  !*** ./resources/js/licensed.js ***!
  \**********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   init: () => (/* binding */ init)\n/* harmony export */ });\n/* provided dependency */ var $ = __webpack_require__(/*! jquery */ \"jquery\");\n/**\r\n * Script for the license page\r\n */\n\n\nfunction init() {\n  $(document).ready(function () {\n    const tb = new DataTable('#tb-licensed', {\n      autoWidth: false,\n      columns: [{\n        data: 'name'\n      }, {\n        data: data => data.active ? '<span class=\"text-success\">Ativo</span>' : '<span class=\"text-danger\">Inativo</span>'\n      }, {\n        data: data => new Intl.DateTimeFormat('pt-BR', {\n          day: '2-digit',\n          month: '2-digit',\n          year: 'numeric'\n        }).format(new Date(data.created_at))\n      }, {\n        data: data => {\n          return $('<div />', {\n            class: 'd-flex'\n          }).append([$('<button />', {\n            class: 'btn btn-xs btn-transparent me-2',\n            type: 'buttom',\n            title: 'Carregar dados do cliente',\n            'data-id': data.id,\n            'data-name': data.name\n          }).append($('<i />', {\n            class: 'heroicon heroicon-arrow-path-square'\n          })), $('<div />', {\n            class: 'dropdown clearfix'\n          }).append([$('<a />', {\n            class: 'btn btn-outline-gray-200 btn-xs dropdown-toggle text-tertiary',\n            href: '#',\n            role: 'button',\n            'data-bs-toggle': 'dropdown',\n            'aria-expanded': 'false'\n          }).append([$('<i />', {\n            class: 'heroicon heroicon-horizontal-elipsis'\n          })]), $('<ul />', {\n            class: 'dropdown-menu'\n          }).append($('<li />').append([$('<a />', {\n            class: 'dropdown-item d-flex text-primary',\n            href: '#',\n            'data-id': data.id\n          }).append([$('<i />', {\n            class: 'heroicon heroicon-lock-closed me-2'\n          }), $('<span />').html('Bloquear')])]), $('<li />').append([$('<a />', {\n            class: 'dropdown-item d-flex text-tertiary',\n            href: '#',\n            'data-id': data.id\n          }).append([$('<i />', {\n            class: 'heroicon heroicon-pencil me-2'\n          }), $('<span />').html('Editar')])]), $('<li />').append([$('<a />', {\n            class: 'dropdown-item d-flex text-danger',\n            href: '#',\n            'data-id': data.id\n          }).append([$('<i />', {\n            class: 'heroicon heroicon-trash me-2'\n          }), $('<span />').html('Excluir')])]))])]).prop('outerHTML');\n        }\n      }],\n      columnDefs: [{\n        targets: [1, 2, 3],\n        orderable: false\n      }],\n      ajax: (data, callback, settings) => {\n        fetch('/api/v1/licensed', {\n          method: 'GET',\n          credentials: 'include'\n        }).then(response => response.json()).then(data => {\n          const dataTable = [];\n          data.forEach(item => {\n            dataTable.push({\n              id: item.id,\n              name: item.name,\n              created_at: item.created_at,\n              active: item.active\n            });\n          });\n          callback({\n            data: dataTable\n          });\n        });\n      }\n    });\n  });\n}\n\n//# sourceURL=webpack://access-control/./resources/js/licensed.js?");

/***/ }),

/***/ "./resources/js/users.js":
/*!*******************************!*\
  !*** ./resources/js/users.js ***!
  \*******************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   init: () => (/* binding */ init),\n/* harmony export */   loadFilters: () => (/* binding */ loadFilters),\n/* harmony export */   loadTable: () => (/* binding */ loadTable)\n/* harmony export */ });\n/* provided dependency */ var $ = __webpack_require__(/*! jquery */ \"jquery\");\n/**\r\n * Modulo de usuarios\r\n */\n\n\nfunction init() {\n  loadFilters();\n  loadTable();\n  $('#users-table').on('click', '#check-all', function () {\n    $('#users-table tbody input[type=\"checkbox\"]').prop('checked', $(this).is(':checked'));\n  });\n  $('#new-user').on('click', function () {\n    if (!$('#role_id option').length) {\n      fetch('/api/v1/roles', {\n        method: 'GET',\n        headers: {\n          'Content-Type': 'application/json'\n        },\n        credentials: 'include'\n      }).then(response => response.json()).then(json => {\n        const roles = json.map(role => `<option value=\"${role.id}\">${role.name}</option>`);\n        roles.unshift('<option selected >Selecione um perfil</option>');\n        $('#role_id').html(roles.join(''));\n      });\n    }\n    if (!$('#licensed_id option').length) {\n      fetch('/api/v1/licensed', {\n        method: 'GET',\n        headers: {\n          'Content-Type': 'application/json'\n        },\n        credentials: 'include'\n      }).then(response => response.json()).then(json => {\n        const licensed = json.map(licensed => `<option value=\"${licensed.id}\">${licensed.name}</option>`);\n        licensed.unshift('<option selected >Selecione um licenciado</option>');\n        $('#licensed_id').html(licensed.join(''));\n      });\n    }\n  });\n}\nfunction loadTable() {\n  $('#users-table').DataTable({\n    ajax: function (data, callback, settings) {\n      fetch('/api/v1/users', {\n        method: 'GET',\n        headers: {\n          'Content-Type': 'application/json'\n        },\n        credentials: 'include'\n      }).then(response => response.json()).then(json => {\n        callback({\n          data: json\n        });\n      }).catch(error => {\n        console.error('Erro ao carregar os dados:', error);\n      });\n    },\n    columns: [{\n      data: data => $('<input />', {\n        type: 'checkbox',\n        class: 'form-check-input',\n        id: `user-${data.id}`,\n        value: data.id\n      }).prop('outerHTML')\n    }, {\n      data: data => {\n        return $('<div />', {\n          class: 'd-flex'\n        }).append([$('<img />', {\n          class: 'rounded-circle avatar bg-light me-3',\n          src: data.person.photo ?? '/img/user.png'\n        }), $('<div />').append([$('<h1 />', {\n          class: 'h5 mb-0 font-size-14'\n        }).text(data.person.name), $('<p />', {\n          class: 'text-muted font-size-12 mb-0'\n        }).append($('<i />', {\n          class: 'heroicon heroicon-envelope mt-1 me-1 float-start'\n        }), data.email)])]).prop('outerHTML');\n      }\n    }, {\n      data: 'person.role_name'\n    }, {\n      data: data => data.active ? $('<span />', {\n        class: 'text-success'\n      }).text('Ativo').prop('outerHTML') : $('<span />', {\n        class: 'text-danger'\n      }).text('Inativo').prop('outerHTML')\n    }, {\n      data: data => new Date(data.created_at).toLocaleDateString('pt-BR', {\n        year: 'numeric',\n        month: '2-digit',\n        day: '2-digit'\n      })\n    }, {\n      data: data => $('<div />').append([$('<button />', {\n        class: 'btn btn-link btn-transparent text-dark dropdown-toggle dropdown-toggle-split m-0 p-0',\n        type: 'button',\n        'data-bs-toggle': 'dropdown',\n        'aria-expanded': false,\n        'aria-haspopup': true\n      }).append($('<i />', {\n        class: 'heroicon heroicon-horizontal-elipsis float-start'\n      })), $('<div />', {\n        class: 'dropdown-menu dashboard-dropdown dropdown-menu-start mt-2 py-1'\n      }).append($('<a />', {\n        class: 'dropdown-item text-info',\n        href: `/api/v1/users/${data.id}`\n      }).append($('<i />', {\n        class: 'heroicon heroicon-eye me-2'\n      }), 'Ver'), $('<a />', {\n        class: 'dropdown-item text-primary',\n        href: `/api/v1/users/${data.id}/edit`\n      }).append($('<i />', {\n        class: 'heroicon heroicon-pencil-square me-2'\n      }), 'Editar'), $('<a />', {\n        class: 'dropdown-item text-danger',\n        href: `/api/v1/users/${data.id}/delete`\n      }).append($('<i />', {\n        class: 'heroicon heroicon-trash me-2'\n      }), 'Excluir'))]).prop('innerHTML')\n    }],\n    columnDefs: [{\n      targets: [0, 2, 3, 4, 5],\n      orderable: false\n    }, {\n      targets: [0, 4, 5],\n      searchable: false\n    }]\n  });\n}\nfunction loadFilters() {\n  $('#search-users').on('keyup', function () {\n    const value = $(this).val();\n    if (value.length < 3) {\n      $('#users-table').DataTable().column(1).search('').draw();\n      return;\n    }\n    $('#users-table').DataTable().column(1).search(value).draw();\n  });\n  $('#filter-perfil').on('change', function () {\n    const value = $(this).val();\n    if (value == 'todos') {\n      $('#users-table').DataTable().column(2).search('').draw();\n      return;\n    }\n    $('#users-table').DataTable().column(2).search(value).draw();\n  });\n  $('#filter-status').on('change', function () {\n    const value = $(this).val();\n    if (value == 'todos') {\n      $('#users-table').DataTable().column(3).search('').draw();\n      return;\n    }\n    $('#users-table').DataTable().column(3).search(value).draw();\n  });\n  $('#clear-user-filters').on('click', function () {\n    $('#search-users').val('').trigger('keyup');\n    $('#filter-perfil').val('todos').trigger('change');\n    $('#filter-status').val('todos').trigger('change');\n  });\n}\n\n//# sourceURL=webpack://access-control/./resources/js/users.js?");

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
/******/ 	var __webpack_exports__ = __webpack_require__("./resources/js/admin.js");
/******/ 	
/******/ })()
;