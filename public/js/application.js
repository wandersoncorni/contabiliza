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

/***/ "./resources/js/application.js":
/*!*************************************!*\
  !*** ./resources/js/application.js ***!
  \*************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   init: () => (/* binding */ init)\n/* harmony export */ });\n/* provided dependency */ var $ = __webpack_require__(/*! jquery */ \"jquery\");\n/**\r\n * Scripts para pagina padrao do sistema\r\n */\nfunction init() {\n  menuItens.forEach(item => {\n    $('#sidebarMenu ul').append($('<li />', {\n      class: 'nav-item'\n    }).append($('<a />', {\n      class: 'nav-link',\n      href: item.route ?? item.link\n    }).append([$('<i />', {\n      class: `heroicon ${item.icon} float-start me-2`\n    }), item.label])));\n  });\n  $('#sidebarMenu ul li a').on('click', function (e) {\n    e.preventDefault();\n    $('#sidebarMenu ul li').removeClass('active');\n    $(this).parent().addClass('active');\n    sessionStorage.setItem(\"sidebarMenuItem\", $(this).attr('href'));\n    fetch($(this).attr('href'), {\n      method: 'GET',\n      headers: {\n        'Content-Type': 'application/json'\n      },\n      credentials: 'include'\n    }).then(response => {\n      if (response.status === 200) {\n        return response.text();\n      }\n    }).then(html => {\n      $('#app-content').html(html);\n      $('#app-content').find('script').each(function () {\n        const src = $(this).attr('src');\n        $(this).remove();\n        if (!$(`script[src=\"${src}\"]`).length) {\n          const newScript = document.createElement('script');\n          newScript.src = src;\n          newScript.type = 'text/javascript';\n          newScript.async = false;\n          document.body.appendChild(newScript);\n        }\n      });\n    });\n  });\n  $(`#sidebarMenu ul li a[href=\"${sessionStorage.getItem(\"sidebarMenuItem\") ?? \"/painel\"}\"]`).trigger('click');\n  // Implementa o evento de clique para o botão de logout\n  $(\".btn-logout\").on(\"click\", function (e) {\n    e.preventDefault();\n    fetch('/api/v1/logout', {\n      method: 'POST',\n      headers: {\n        'Content-Type': 'application/json'\n      },\n      credentials: 'include'\n    }).then(response => {\n      window.location.href = '/';\n    });\n  });\n}\n;\n\n//# sourceURL=webpack://access-control/./resources/js/application.js?");

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
/******/ 	var __webpack_exports__ = __webpack_require__("./resources/js/application.js");
/******/ 	
/******/ })()
;