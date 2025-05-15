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

/***/ "./resources/js/admin.js":
/*!*******************************!*\
  !*** ./resources/js/admin.js ***!
  \*******************************/
/***/ (() => {

eval("/**\r\n * Cria o menu de gestao para os licenciados\r\n */\nglobalThis.buildLicensedMenu = function () {\n  const licensed = JSON.parse(sessionStorage.getItem('licensed_context'));\n  if ($('#sidebarMenuLicensed').length > 0) {\n    $('#sidebarMenuLicensed').remove();\n  }\n  const menuItens = [{\n    label: 'Consultores',\n    icon: 'heroicon-users',\n    route: '/consultants'\n  }, {\n    label: 'Clientes',\n    icon: 'heroicon-users',\n    route: '/clients'\n  }, {\n    label: 'Agentes',\n    icon: 'heroicon-users',\n    route: '/agents'\n  }];\n  const menu = [$('<li />').append($('<h6 />', {\n    class: 'nav-heading'\n  }).html(`<h5>${licensed.name}</h5>`))];\n  $('#sidebarMenu .sidebar-inner').append($('<ul />', {\n    class: 'nav flex-column pt-3 pt-md-0 mt-3'\n  }).append((() => {\n    menuItens.forEach(item => {\n      menu.push($('<li />', {\n        class: 'nav-item'\n      }).append($('<a />', {\n        class: 'nav-link',\n        href: item.route\n      }).append($('<i />', {\n        class: `heroicon ${item.icon} float-start me-2`\n      }), item.label)));\n    });\n    return menu;\n  })()).prop({\n    id: 'sidebarMenuLicensed'\n  }));\n};\n$(document).ready(function () {\n  if (sessionStorage.getItem('licensed_context') !== null) {\n    buildLicensedMenu();\n  }\n  $('#sidebarMenu').on('click', '#sidebarMenuLicensed a', function (e) {\n    e.preventDefault();\n    $('#sidebarMenu ul li, #sidebarMenuLicensed ul li').removeClass('active');\n    $(this).parent().addClass('active');\n    fetch($(this).attr('href'), {\n      method: 'GET',\n      headers: {\n        'Content-Type': 'application/json'\n      },\n      credentials: 'include'\n    }).then(response => {\n      if (response.status === 200) {\n        return response.text();\n      } else if (response.status === 404) {\n        Swal.fire({\n          icon: 'error',\n          title: 'Página não encontrada!',\n          text: \"A página que você tentou acessar não foi encontrada.\"\n        });\n      } else {\n        Swal.fire({\n          icon: 'error',\n          title: 'Erro ao tentar acessar a página!',\n          text: \"Ocorreu um erro interno ao tentar acessar a página.\"\n        });\n      }\n    }).then(html => {\n      $('#app-content').html(html);\n    });\n  });\n});\n\n//# sourceURL=webpack://access-control/./resources/js/admin.js?");

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module can't be inlined because the eval devtool is used.
/******/ 	var __webpack_exports__ = {};
/******/ 	__webpack_modules__["./resources/js/admin.js"]();
/******/ 	
/******/ })()
;