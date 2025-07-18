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

/***/ "./resources/js/app.js":
/*!*****************************!*\
  !*** ./resources/js/app.js ***!
  \*****************************/
/***/ ((__unused_webpack_module, __unused_webpack_exports, __webpack_require__) => {

eval("/* provided dependency */ var $ = __webpack_require__(/*! jquery */ \"jquery\");\n$(document).ready(function () {\n  const scroll = new SmoothScroll('a[href*=\"#\"]', {\n    speed: 300,\n    speedAsDuration: true,\n    offset: 0,\n    updateURL: false,\n    popstate: false,\n    emitEvents: true\n  });\n  menuItens.forEach(item => {\n    $('#sidebarMenu ul').append($('<li />', {\n      class: 'nav-item'\n    }).append($('<a />', {\n      class: 'nav-link',\n      href: item.route ?? item.link\n    }).append([$('<i />', {\n      class: `heroicon ${item.icon} float-start me-2`\n    }), item.label])));\n  });\n  $('#sidebarMenu ul li a').on('click', function (e) {\n    e.preventDefault();\n    fetch($(this).attr('href'), {\n      method: 'GET',\n      headers: {\n        'Content-Type': 'application/json'\n      },\n      credentials: 'include'\n    }).then(response => {\n      if (response.status === 200) {\n        return response.text();\n      } else if (response.status === 404) {\n        Swal.fire({\n          icon: 'error',\n          title: 'Página não encontrada!',\n          text: \"A página que você tentou acessar não foi encontrada.\"\n        });\n      } else if (response.status === 403) {\n        Swal.fire({\n          icon: 'error',\n          title: 'Acesso negado!',\n          text: \"Não possui permissão para acessar essa página.\"\n        });\n      } else {\n        Swal.fire({\n          icon: 'error',\n          title: 'Erro ao tentar acessar a página!',\n          text: \"Ocorreu um erro interno ao tentar acessar a página.\"\n        });\n      }\n    }).then(html => {\n      $('#sidebarMenu ul li').removeClass('active');\n      $(this).parent().addClass('active');\n      sessionStorage.setItem(\"sidebarMenuItem\", $(this).attr('href'));\n      $('#app-content').html(html);\n      const event = new CustomEvent('page:loaded', {\n        detail: {\n          url: $(this).attr('href')\n        }\n      });\n      document.dispatchEvent(event);\n    });\n  });\n  $(`#sidebarMenu ul li a[href=\"${sessionStorage.getItem(\"sidebarMenuItem\") ?? \"/painel\"}\"]`).trigger('click');\n  // Implementa o evento de clique para o botão de logout\n  $(\".btn-logout\").on(\"click\", function (e) {\n    e.preventDefault();\n    fetch('/api/v1/logout', {\n      method: 'POST',\n      headers: {\n        'Content-Type': 'application/json'\n      },\n      credentials: 'include'\n    }).then(response => {\n      window.location.href = '/';\n    });\n  });\n  const sessionTime = 15 * 60 * 1000;\n  let inativeTime = 0;\n  ['click', 'mousemove', 'keydown', 'scroll', 'touchstart'].forEach(event => {\n    $('body').on(event, function (e) {\n      inativeTime = 0;\n    });\n  });\n  setInterval(() => {\n    inativeTime += 1000;\n    if (inativeTime >= sessionTime) {\n      window.location.reload();\n    }\n  }, 1000);\n});\n/**\r\n * Constroi as tabelas de susuarios para os modulos de consultores, clientes e agentes\r\n * @param {string} container \r\n * @param {string} url \r\n * @returns \r\n */\nglobalThis.loadUsersTable = function (container, url) {\n  return new DataTable(container, {\n    ajax: function (data, callback, settings) {\n      fetch(url, {\n        method: 'GET',\n        headers: {\n          'Content-Type': 'application/json'\n        },\n        credentials: 'include'\n      }).then(response => response.json()).then(json => {\n        callback({\n          data: json\n        });\n      }).catch(error => {\n        console.error('Erro ao carregar os dados:', error);\n      });\n    },\n    columns: [{\n      data: data => {\n        return $('<div />', {\n          class: 'd-flex'\n        }).append([$('<img />', {\n          class: 'rounded-circle avatar bg-light me-3',\n          src: data.person.photo ?? '/img/user.png'\n        }), $('<div />').append([$('<h1 />', {\n          class: 'h5 mb-0 font-size-14'\n        }).text(data.person.name), $('<p />', {\n          class: 'text-muted font-size-12 mb-0'\n        }).append($('<i />', {\n          class: 'heroicon heroicon-envelope mt-1 me-1 float-start'\n        }), data.email)])]).prop('outerHTML');\n      }\n    }, {\n      data: data => data.active ? $('<span />', {\n        class: 'text-success'\n      }).text('Ativo').prop('outerHTML') : $('<span />', {\n        class: 'text-danger'\n      }).text('Inativo').prop('outerHTML')\n    }, {\n      data: data => new Date(data.created_at).toLocaleDateString('pt-BR', {\n        year: 'numeric',\n        month: '2-digit',\n        day: '2-digit'\n      })\n    }, {\n      data: data => $('<div />').append([$('<button />', {\n        class: 'btn btn-link btn-transparent text-dark dropdown-toggle dropdown-toggle-split m-0 p-0',\n        type: 'button',\n        'data-bs-toggle': 'dropdown',\n        'aria-expanded': false,\n        'aria-haspopup': true\n      }).append($('<i />', {\n        class: 'heroicon heroicon-horizontal-elipsis float-start'\n      })), $('<div />', {\n        class: 'dropdown-menu dashboard-dropdown dropdown-menu-start mt-2 py-1'\n      }).append($('<a />', {\n        class: 'dropdown-item text-primary',\n        href: `/api/v1/users/${data.id}/edit`\n      }).append($('<i />', {\n        class: 'heroicon heroicon-pencil-square me-2'\n      }), 'Editar'), $('<a />', {\n        class: 'dropdown-item text-danger',\n        href: `/api/v1/users/${data.id}/delete`\n      }).append($('<i />', {\n        class: 'heroicon heroicon-trash me-2'\n      }), 'Excluir'))]).prop('innerHTML')\n    }],\n    columnDefs: [{\n      targets: [0],\n      orderable: false\n    }, {\n      targets: [0, 1],\n      searchable: false\n    }]\n  });\n};\n\n//# sourceURL=webpack://access-control/./resources/js/app.js?");

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
/******/ 	var __webpack_exports__ = __webpack_require__("./resources/js/app.js");
/******/ 	
/******/ })()
;