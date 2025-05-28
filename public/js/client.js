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

/***/ "./resources/js/client.js":
/*!********************************!*\
  !*** ./resources/js/client.js ***!
  \********************************/
/***/ ((__unused_webpack_module, __unused_webpack_exports, __webpack_require__) => {

eval("/* provided dependency */ var $ = __webpack_require__(/*! jquery */ \"jquery\");\n/**\r\n * Scripts para cliente\r\n */\n$(document).ready(function () {\n  fetch('/api/v1/plans', {\n    method: 'GET',\n    headers: {\n      'Content-Type': 'application/json'\n    },\n    credentials: 'include'\n  }).then(response => response.json()).then(json => {});\n  $('#sidebarMenu ul li a').on('click', function (e) {\n    if ($(this).attr('href') === '/agents') {\n      e.preventDefault();\n      if ($.fn.dataTable.isDataTable('#tb-agents')) $('#tb-agents').DataTable().destroy();\n      const tb = loadUsersTable('#tb-agents', '/api/v1/agents');\n    } else if ($(this).attr('href') === '/companies') {\n      e.preventDefault();\n      const tb = new DataTable('#tb-companies', '/api/v1/companies');\n    } else if ($(this).attr('href') === '/partners') {\n      e.preventDefault();\n      const tb = new DataTable('#tb-partners', '/api/v1/partners');\n    }\n  });\n});\n\n// function buildPlansCards(data) {\n//     $('<div>',{class: 'col-12 col-lg-6 col-xl-4'}).append(\n//         $('<div>',{class: 'card mb-4 mb-xl-0'}).append(\n//             $('<div>',{class: 'card-header border-gray-100 py-5 px-4'}).append(\n//                 $('<div>',{class: 'd-flex mb-3'}).append(\n//                     $('<span>',{class: 'h5 mb-0'}).text('A partir de R$'),\n//                     $('<span>',{class: 'price display-2 mb-0'}).text(data.price),\n//                     $('<span>',{class: 'h6 fw-normal align-self-end'}).text('/mês')\n//                 ),\n//                 $('<h4>',{class: 'mb-3 text-black'}).text(data.nome),\n//             ),            \n//             $('<div>',{class: 'card-body py-5 px-4'}).append(\n//                 ((data.ser)=>{\n\n//                 })()\n//                 $('<div>',{class: 'd-flex justify-content-between align-items-center mt-4'}).append(\n//                     $('<a>',{class: 'btn btn-primary', href: '/plans/' + data.id}).text('Assinar')\n//                 )\n//     )\n// }\n\n//# sourceURL=webpack://access-control/./resources/js/client.js?");

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
/******/ 	var __webpack_exports__ = __webpack_require__("./resources/js/client.js");
/******/ 	
/******/ })()
;