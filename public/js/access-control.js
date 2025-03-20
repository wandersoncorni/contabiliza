/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./app/access-control/resources/js/login.js":
/*!**************************************************!*\
  !*** ./app/access-control/resources/js/login.js ***!
  \**************************************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/**
 * Script for login page
 * @version 1.0
 */
$(function () {
  // Login form submit
  $('#loginForm').submit(function (e) {
    e.preventDefault();
    var form = $(this);
    var url = form.attr('action');
    var data = form.serialize();
    $.post(url, data, function (response) {
      if (response.status == 'error') {
        $('#message').html(response.message).addClass('alert alert-danger');
      } else {
        $('#message').html(response.message).addClass('alert alert-success');
        window.location.href = response.redirect;
      }
    }, 'json');
  });
});

/***/ }),

/***/ "./app/access-control/resources/js/register.js":
/*!*****************************************************!*\
  !*** ./app/access-control/resources/js/register.js ***!
  \*****************************************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/**
 * Scripts para o registro de usuários
 */
$(function () {
  $('#form-register').submit(function (e) {
    e.preventDefault();
    e.stopPropagation();
    // Limpar mensagens de erro anteriores
    $('.invalid-feedback').remove();

    // Validação dos campos de email e senha
    var name = $('[name=name]').val();
    var email = $('[name=email]').val();
    var password = $('[name=password]').val();
    var passwordConfirmation = $('[name=password_confirmation]').val();
    var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
    var passwordPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
    var hasError = false;
    if (!name.length) {
      setErrorMessage('[name=name]', 'O campo nome é obrigatório.');
      hasError = true;
    }
    if (!emailPattern.test(email)) {
      setErrorMessage('[name=email]', 'Por favor, insira um endereço de email válido.');
      hasError = true;
    }
    if (!passwordPattern.test(password)) {
      setErrorMessage('[name=password]', 'A senha deve ter no mínimo 8 caracteres, incluindo pelo menos uma letra maiúscula, uma letra minúscula, um número e um caractere especial.');
      hasError = true;
    }
    if (password !== passwordConfirmation) {
      setErrorMessage('[name=password_confirmation]', 'A confirmação de senha não corresponde.');
      hasError = true;
    }
    if (hasError) {
      return;
    }
    var form = $(this);
    var url = form.attr('action');
    var data = form.serialize();
    $.ajax({
      url: url,
      type: 'POST',
      data: data,
      dataType: 'json',
      beforeSend: function beforeSend() {
        $('#loader').removeClass('d-done').addClass('d-flex');
      },
      success: function success(resp) {
        $('#modal-success').modal('show');
      },
      error: function error(resp) {
        var errors = resp.responseJSON.errors;
        Object.keys(errors).map(function (name) {
          errors[name].map(function (message) {
            setErrorMessage("[name=".concat(name, "]"), message);
          });
        });
      },
      always: function always() {
        $('#loader').removeClass('d-flex').addClass('d-done');
      }
    });
  });
  $('#modal-success').on('hidden.coreui.modal', function (e) {
    window.location.href = window.location.origin + '/login';
  });
});
var setErrorMessage = function setErrorMessage(field, message) {
  $(field).after($('<div />', {
    "class": 'invalid-feedback',
    style: 'display:block'
  }).html(message));
};

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
var __webpack_exports__ = {};
// This entry needs to be wrapped in an IIFE because it needs to be isolated against other modules in the chunk.
(() => {
/*!************************************************!*\
  !*** ./app/access-control/resources/js/app.js ***!
  \************************************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _login_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./login.js */ "./app/access-control/resources/js/login.js");
/* harmony import */ var _register_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./register.js */ "./app/access-control/resources/js/register.js");


})();

/******/ })()
;