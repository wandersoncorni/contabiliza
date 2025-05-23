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

eval("/* provided dependency */ var $ = __webpack_require__(/*! jquery */ \"jquery\");\n/**\r\n * Scripts para cliente\r\n */\n$(document).ready(function () {\n  $('#sidebarMenu ul li a').on('click', function (e) {\n    if ($(this).attr('href') === '/agents') {\n      e.preventDefault();\n      if ($.fn.dataTable.isDataTable('#tb-agents')) $('#tb-agents').DataTable().destroy();\n      const tb = loadUsersTable('#tb-agents', '/api/v1/agents');\n    } else if ($(this).attr('href') === '/companies') {\n      e.preventDefault();\n      const tb = new DataTable('#tb-companies', '/api/v1/companies');\n    } else if ($(this).attr('href') === '/partners') {\n      e.preventDefault();\n      const tb = new DataTable('#tb-partners', '/api/v1/partners');\n    }\n  });\n  // const db = new DataTable('#tb-agents', {\n  //     ajax: (data, callback) => fetch('/api/v1/agents',{\n  //         method: 'GET',\n  //         credentials: 'include'\n  //     }).then(response => response.json())\n  //     .then(data => {\n  //         return data;\n  //     })\n  // })\n});\n\n//# sourceURL=webpack://access-control/./resources/js/client.js?");

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