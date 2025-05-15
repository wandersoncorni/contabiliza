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

/***/ "./resources/js/licensed.js":
/*!**********************************!*\
  !*** ./resources/js/licensed.js ***!
  \**********************************/
/***/ (() => {

eval("/**\r\n * Script for the license page\r\n */\n\n\n$(document).ready(function () {\n  const tb = new DataTable('#tb-licensed', {\n    autoWidth: false,\n    columns: [{\n      data: 'name'\n    }, {\n      data: data => data.active ? '<span class=\"text-success\">Ativo</span>' : '<span class=\"text-danger\">Inativo</span>'\n    }, {\n      data: data => new Intl.DateTimeFormat('pt-BR', {\n        day: '2-digit',\n        month: '2-digit',\n        year: 'numeric'\n      }).format(new Date(data.created_at))\n    }, {\n      data: data => {\n        return $('<div />', {\n          class: 'd-flex'\n        }).append([$('<button />', {\n          class: 'btn btn-xs btn-transparent me-2',\n          type: 'buttom',\n          title: 'Carregar dados do cliente',\n          'data-id': data.id,\n          'data-name': data.name\n        }).append($('<i />', {\n          class: 'heroicon heroicon-arrow-path-square'\n        })), $('<div />', {\n          class: 'dropdown clearfix'\n        }).append([$('<a />', {\n          class: 'btn btn-outline-gray-200 btn-xs dropdown-toggle text-tertiary',\n          href: '#',\n          role: 'button',\n          'data-bs-toggle': 'dropdown',\n          'aria-expanded': 'false'\n        }).append([$('<i />', {\n          class: 'heroicon heroicon-horizontal-elipsis'\n        })]), $('<ul />', {\n          class: 'dropdown-menu'\n        }).append($('<li />').append([$('<a />', {\n          class: 'dropdown-item d-flex text-primary',\n          href: '#',\n          'data-id': data.id\n        }).append([$('<i />', {\n          class: 'heroicon heroicon-lock-closed me-2'\n        }), $('<span />').html('Bloquear')])]), $('<li />').append([$('<a />', {\n          class: 'dropdown-item d-flex text-tertiary',\n          href: '#',\n          'data-id': data.id\n        }).append([$('<i />', {\n          class: 'heroicon heroicon-pencil me-2'\n        }), $('<span />').html('Editar')])]), $('<li />').append([$('<a />', {\n          class: 'dropdown-item d-flex text-danger',\n          href: '#',\n          'data-id': data.id\n        }).append([$('<i />', {\n          class: 'heroicon heroicon-trash me-2'\n        }), $('<span />').html('Excluir')])]))])]).prop('outerHTML');\n      }\n    }],\n    columnDefs: [{\n      targets: [1, 2, 3],\n      orderable: false\n    }]\n  });\n  // Carrega a tabela\n  fetch('/api/v1/licensed', {\n    method: 'GET',\n    credentials: 'include'\n  }).then(response => response.json()).then(data => {\n    const dataTable = [];\n    data.forEach(item => {\n      dataTable.push({\n        id: item.id,\n        name: item.name,\n        created_at: item.created_at,\n        active: item.active\n      });\n    });\n    tb.clear().rows.add(dataTable).draw();\n  });\n  $('#app-content').on('click', '#tb-licensed tbody tr td:last-child button', function () {\n    sessionStorage.setItem('licensed_context', JSON.stringify({\n      id: $(this).attr('data-id'),\n      name: $(this).attr('data-name')\n    }));\n    buildLicensedMenu();\n  });\n});\n\n//# sourceURL=webpack://access-control/./resources/js/licensed.js?");

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module can't be inlined because the eval devtool is used.
/******/ 	var __webpack_exports__ = {};
/******/ 	__webpack_modules__["./resources/js/licensed.js"]();
/******/ 	
/******/ })()
;