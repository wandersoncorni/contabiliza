/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./resources/js/public/autenticacao.js":
/*!*********************************************!*\
  !*** ./resources/js/public/autenticacao.js ***!
  \*********************************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   setAlert: () => (/* binding */ setAlert),
/* harmony export */   setErrorMessage: () => (/* binding */ setErrorMessage),
/* harmony export */   switchLoader: () => (/* binding */ switchLoader)
/* harmony export */ });
/**
 * Scripts para autenticacao (login, registro e recuperacao de senha)
 */


/**
 * Exibe mensagens de erro dos campos
 */
function setErrorMessage(el, message) {
  var div = document.createElement('div');
  el.classList.add('is-invalid');
  div.classList.add('invalid-feedback');
  div.textContent = message;
  el.insertAdjacentElement('afterend', div);
}
;
/**
 * Exibe mensagens de erro do servidor
 */
var iconClass = {
  success: 'bi-check-circle-fill',
  warning: 'bi-exclamation-triangle-fill',
  danger: 'bi-dash-circle-fill'
};
function setAlert(message) {
  var type = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 'success';
  var alerts = document.querySelectorAll('.alert');
  alerts.forEach(function (el) {
    return el.remove();
  });
  var icon = document.createElement('i');
  icon.classList.add('bi', iconClass[type]);
  var alert = document.createElement('div');
  alert.classList.add('alert', "alert-".concat(type));
  alert.setAttribute('role', 'alert');
  alert.append(icon);
  alert.append(" ".concat(message));
  var card = document.querySelector('.card-body');
  card.append(alert);
}
function switchLoader() {
  var show = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : true;
  var loader = document.querySelector('#loader');
  if (show) {
    loader.classList.remove('d-none');
    loader.classList.add('d-flex');
  } else {
    loader.classList.remove('d-flex');
    loader.classList.add('d-none');
  }
}

/***/ }),

/***/ "./resources/js/public/register.js":
/*!*****************************************!*\
  !*** ./resources/js/public/register.js ***!
  \*****************************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   enviarDados: () => (/* binding */ enviarDados),
/* harmony export */   exibirModal: () => (/* binding */ exibirModal),
/* harmony export */   setarErro: () => (/* binding */ setarErro),
/* harmony export */   validarForm: () => (/* binding */ validarForm)
/* harmony export */ });
/* harmony import */ var _autenticacao_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./autenticacao.js */ "./resources/js/public/autenticacao.js");
/* harmony import */ var _utils_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../utils.js */ "./resources/js/utils.js");
function _slicedToArray(r, e) { return _arrayWithHoles(r) || _iterableToArrayLimit(r, e) || _unsupportedIterableToArray(r, e) || _nonIterableRest(); }
function _nonIterableRest() { throw new TypeError("Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }
function _unsupportedIterableToArray(r, a) { if (r) { if ("string" == typeof r) return _arrayLikeToArray(r, a); var t = {}.toString.call(r).slice(8, -1); return "Object" === t && r.constructor && (t = r.constructor.name), "Map" === t || "Set" === t ? Array.from(r) : "Arguments" === t || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(t) ? _arrayLikeToArray(r, a) : void 0; } }
function _arrayLikeToArray(r, a) { (null == a || a > r.length) && (a = r.length); for (var e = 0, n = Array(a); e < a; e++) n[e] = r[e]; return n; }
function _iterableToArrayLimit(r, l) { var t = null == r ? null : "undefined" != typeof Symbol && r[Symbol.iterator] || r["@@iterator"]; if (null != t) { var e, n, i, u, a = [], f = !0, o = !1; try { if (i = (t = t.call(r)).next, 0 === l) { if (Object(t) !== t) return; f = !1; } else for (; !(f = (e = i.call(t)).done) && (a.push(e.value), a.length !== l); f = !0); } catch (r) { o = !0, n = r; } finally { try { if (!f && null != t["return"] && (u = t["return"](), Object(u) !== u)) return; } finally { if (o) throw n; } } return a; } }
function _arrayWithHoles(r) { if (Array.isArray(r)) return r; }
/**
 * Scripts para registro
 */


/**
 * Valida os campos do form
 * @param {*} elements 
 * @returns boolean
 */
var passwordPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
function validarForm(elements) {
  var isValid = true;
  elements.forEach(function (el) {
    var name = el.getAttribute('name');
    var parent = el.parentElement;
    var confirm = name == 'password' ? document.querySelector('[name=password_confirmation]') : null;
    if (!el.value) {
      _autenticacao_js__WEBPACK_IMPORTED_MODULE_0__.setErrorMessage(parent.nextElementSibling, 'Campo obrigatório');
      el.classList.add('is-invalid');
      isValid = false;
    } else if (name == 'email' && !(0,_utils_js__WEBPACK_IMPORTED_MODULE_1__.validateEmail)(el.value)) {
      _autenticacao_js__WEBPACK_IMPORTED_MODULE_0__.setErrorMessage(parent.nextElementSibling, 'Por favor, insira um endereço de email válido.');
      el.classList.add('is-invalid');
      isValid = false;
    } else if (name == "password" && !passwordPattern.test(el.value)) {
      _autenticacao_js__WEBPACK_IMPORTED_MODULE_0__.setErrorMessage(parent.nextElementSibling, 'A senha deve ter no mínimo 8 caracteres, incluindo pelo menos uma letra maiúscula, uma letra minúscula, um número e um caractere especial.');
      el.classList.add('is-invalid');
      isValid = false;
    } else if (name == "password" && el.value !== confirm.value) {
      _autenticacao_js__WEBPACK_IMPORTED_MODULE_0__.setErrorMessage(parent.nextElementSibling, 'A confirmação de senha não corresponde.');
      el.classList.add('is-invalid');
      isValid = false;
    }
  });
  var termos = document.querySelector('.form-check-input');
  if (termos.checked == false) {
    var parent = termos.parentElement;
    _autenticacao_js__WEBPACK_IMPORTED_MODULE_0__.setAlert('Você deve aceitar os termos de uso!', 'warning');
    isValid = false;
  }
  return isValid;
}
/**
 * Envia o formulario
 * @params formData O Objeto com os dados do formulario
 */
function enviarDados(formData) {
  var statusText = 'success';
  var message = null;
  _autenticacao_js__WEBPACK_IMPORTED_MODULE_0__.switchLoader();
  fetch('register', {
    method: 'POST',
    body: formData,
    headers: {
      'Accept': 'application/json'
    }
  }).then(function (response) {
    if (!response.ok) {
      var _setarErro = setarErro(response.status, [statusText, message]);
      var _setarErro2 = _slicedToArray(_setarErro, 2);
      statusText = _setarErro2[0];
      message = _setarErro2[1];
    }
    return response.json();
  }).then(function (data) {
    //Fecha o loader
    _autenticacao_js__WEBPACK_IMPORTED_MODULE_0__.switchLoader(false);
    if (statusText == 'success') {
      exibirModal();
      return;
    }
    if (data.errors != null) {
      Object.keys(data.errors).map(function (key) {
        var el = document.querySelector("[name=".concat(key, "]"));
        var parent = el.parentElement;
        data.errors[key].map(function (msg) {
          el.classList.add('is-invalid');
          _autenticacao_js__WEBPACK_IMPORTED_MODULE_0__.setErrorMessage(parent.nextElementSibling, msg);
        });
      });
      return;
    }
    _autenticacao_js__WEBPACK_IMPORTED_MODULE_0__.setAlert(message !== null && message !== void 0 ? message : data.message, statusText);
  })["catch"](function (error) {
    _autenticacao_js__WEBPACK_IMPORTED_MODULE_0__.switchLoader(false);
    _autenticacao_js__WEBPACK_IMPORTED_MODULE_0__.setAlert('Erro de solicitação desconhecido', 'danger');
  });
}
/**
 * Retorna o erro da requisicao
 * @params statusText
 */
function setarErro(status, _ref) {
  var _ref2 = _slicedToArray(_ref, 2),
    statusText = _ref2[0],
    message = _ref2[1];
  switch (status) {
    case 400:
      statusText = 'danger';
      break;
    case 401:
      statusText = 'danger';
      break;
    case 419:
      message = 'O tempo do formulário expirou! Recarregue a página e tente de novo.', 'danger';
      statusText = 'warning';
      break;
    case 500:
      message = 'Erro interno do servidor! Informe o administrador.', 'danger';
      statusText = 'danger';
      break;
    default:
      message = 'Erro interno desconhecido';
      statusText = 'danger';
  }
  return [statusText, message];
}
/**
 * Exibe o modal com a informcao sobre a aprovacao
 */
function exibirModal() {
  var registerModal = document.getElementById('registerModal');
  var modal = new bootstrap.Modal(registerModal, {
    backdrop: 'static'
  });
  modal.show();
  registerModal.addEventListener('hidden.bs.modal', function (event) {
    window.location.href = '/login';
  });
}

/***/ }),

/***/ "./resources/js/utils.js":
/*!*******************************!*\
  !*** ./resources/js/utils.js ***!
  \*******************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   capitalize: () => (/* binding */ capitalize),
/* harmony export */   fillTableWithPlaceholders: () => (/* binding */ fillTableWithPlaceholders),
/* harmony export */   formatDate: () => (/* binding */ formatDate),
/* harmony export */   getDatatableObject: () => (/* binding */ getDatatableObject),
/* harmony export */   timeElapsed: () => (/* binding */ timeElapsed),
/* harmony export */   validateEmail: () => (/* binding */ validateEmail)
/* harmony export */ });
/**
 * Modulo com funcoes de uso geral
 */
/**
 * Padrao da senha para validacao
 */
var passwordPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
/**
 * Valida um endereco de email
 * @param {string} email
 * @return boolean
 */
function validateEmail(email) {
  var emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
  return emailPattern.test(email);
}
/**
 * Formata uma string no padrao 'String'
 * @param {string} str 
 * @returns 
 */
function capitalize(str) {
  return str.charAt(0) + str.slice(1).toLowerCase();
}
/**
 * Formata uma data no padro local (pt-BR)
 * @param {string} dateString 
 * @returns 
 */
function formatDate(dateString) {
  var date = new Date(dateString.replace(' ', 'T'));
  var formatter = new Intl.DateTimeFormat('pt-BR', {
    year: 'numeric',
    month: '2-digit',
    day: '2-digit',
    hour: '2-digit',
    minute: '2-digit'
  });
  return formatter.format(date);
}
/**
 * Calcula o tempo passado a partir de um dado momento
 * @param {string} dateString 
 * @returns 
 */
function timeElapsed(dateString) {
  var date = new Date(dateString.replace(" ", "T"));
  var now = new Date();

  // Calcula a diferenca em milisegundos
  var diffInMs = now - date;

  // converte os milisegundos
  var seconds = diffInMs / 1000;
  var minutes = seconds / 60;
  var hours = minutes / 60;
  var days = hours / 24;
  var weeks = days / 7;
  var months = days / 30;

  // Cria uma instancia de RelativeTimeFormat
  var rtf = new Intl.RelativeTimeFormat('en', {
    numeric: 'auto'
  });

  // Retorna o tempo com base no claculo
  if (Math.abs(minutes) < 60) {
    return "".concat(Math.round(minutes), " minuto").concat(Math.round(minutes) !== 1 ? 's' : '');
  } else if (Math.abs(hours) < 14) {
    return "".concat(Math.round(hours), " hora").concat(Math.round(hours) !== 1 ? 's' : '');
  } else if (Math.abs(days) < 30) {
    return "".concat(Math.round(days), " dia").concat(Math.round(days) !== 1 ? 's' : '');
  } else if (Math.abs(weeks) < 4) {
    return "".concat(Math.round(weeks), " semana").concat(Math.round(weeks) !== 1 ? 's' : '');
  } else {
    return "".concat(Math.round(months), " ").concat(Math.round(months) === 1 ? 'mês' : 'meses');
  }
}
/**
 * Preenche uma tabela com linhas preenchidas com placeholders
 * @param {string} tableId 
 * @param {numeric} numRows 
 * @param {numeric} numCols 
 * @returns 
 */
function fillTableWithPlaceholders(tableId, numRows, numCols) {
  // Pega a tabela
  var table = document.getElementById(tableId);

  // Retorna erro se não existir
  if (!table) {
    console.error('Tabela não encontrada!');
    return;
  }
  var lines = [];
  // Cria as linhas
  for (var i = 0; i < numRows; i++) {
    var tr = document.createElement('tr');

    // Cria a celula (coluna)
    for (var j = 0; j < numCols; j++) {
      var td = document.createElement('td');

      // Cria o placeholder
      var placeholder = document.createElement('div');
      placeholder.classList.add('placeholder', 'glow');
      placeholder.innerHTML = '<span class="visually-hidden">Loading...</span>';

      // insere na celula
      td.append(placeholder);
      lines.push(td);
    }
  }
  return lines;
}
/**
 * Retorna uma instancia da tabela htmls
 * @param {string} id 
 */
function getDatatableObject(id) {
  return new simpleDatatables.DataTable("#".concat(id), {
    labels: pt_BR
  });
}

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
var __webpack_exports__ = {};
// This entry needs to be wrapped in an IIFE because it needs to be isolated against other modules in the chunk.
(() => {
/*!************************************!*\
  !*** ./resources/js/public/app.js ***!
  \************************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _utils_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../utils.js */ "./resources/js/utils.js");
/* harmony import */ var _autenticacao_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./autenticacao.js */ "./resources/js/public/autenticacao.js");
/* harmony import */ var _register_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./register.js */ "./resources/js/public/register.js");
/**
 * Scripts para a area publica da aplicacao
 */



/**
 * Scripts para a tela de login
 * @version 1.0
 */
document.addEventListener("DOMContentLoaded", function () {
  /*******************************************************
   * Scripts para login
   ******************************************************/
  var loginForm = document.querySelector('#login-form');
  if (loginForm !== null) {
    loginForm.addEventListener('submit', function (e) {
      e.preventDefault();
      var email = document.querySelector('[name=email]');
      var password = document.querySelector('[name=password]');
      var inputs = document.querySelectorAll('[name="email"], [name="password"]');
      var errorContainer = document.querySelectorAll('.invalid-feedback');
      var isInvalid = document.querySelectorAll('.is-invalid');
      var isValid = true;
      errorContainer.forEach(function (el) {
        return el.remove();
      });
      isInvalid.forEach(function (el) {
        return el.classList.remove('is-invalid');
      });
      inputs.forEach(function (el) {
        var name = el.getAttribute('name');
        if (el.value === '') {
          _autenticacao_js__WEBPACK_IMPORTED_MODULE_1__.setErrorMessage(el, 'Campo obrigatório');
          isValid = false;
        } else if (name == 'email' && !(0,_utils_js__WEBPACK_IMPORTED_MODULE_0__.validateEmail)(el.value)) {
          _utils_js__WEBPACK_IMPORTED_MODULE_0__.validateEmail.setErrorMessage(el, 'Por favor, insira um endereço de email válido.');
          isValid = false;
        }
      });

      // Se as validações passarem, enviar os dados via AJAX
      if (isValid) {
        var formData = new FormData();
        formData.append('email', email.value);
        formData.append('password', password.value);
        formData.append('_token', document.querySelector('[name=_token]').value);
        var statusText = 'success';
        var message = null;
        fetch('/login', {
          method: 'POST',
          body: formData,
          headers: {
            'Accept': 'application/json'
          }
        }).then(function (response) {
          if (!response.ok) {
            switch (response.status) {
              case 401:
                statusText = 'danger';
                break;
              case 419:
                message = 'O tempo do formulário venceu! Recarregue a página e tente de novo.', 'danger';
                statusText = 'warning';
                break;
              case 500:
                message = 'Erro interno do servidor! Informe o administrador.', 'danger';
                statusText = 'danger';
                break;
              default:
                message = 'Erro desconhecido';
                statusText = 'danger';
            }
          }
          return response.json();
        }).then(function (data) {
          if (statusText == 'success') {
            window.location.href = '/analysis';
            return;
          }
          _autenticacao_js__WEBPACK_IMPORTED_MODULE_1__.setAlert(message !== null && message !== void 0 ? message : data.message, statusText);
        })["catch"](function (error) {
          _autenticacao_js__WEBPACK_IMPORTED_MODULE_1__.setAlert('Erro desconhecido', 'danger');
        });
      }
    });
  }
  /*******************************************************
   * Scripts para registro
   ******************************************************/
  /**
   * Executa o registro do usuario
   */
  var registerForm = document.querySelector('#register-form');
  if (registerForm !== null) {
    registerForm.addEventListener('submit', function (e) {
      e.preventDefault();
      var inputs = document.querySelectorAll('[type=text],[type=password]');
      var isInvalid = document.querySelectorAll('.invalid-feedback');
      isInvalid.forEach(function (el) {
        return el.remove();
      });
      var alerTermos = document.querySelector('.alert');
      if (alerTermos != null) {
        alerTermos.remove();
      }
      var invalid = document.querySelectorAll('.is-invalid');
      invalid.forEach(function (el) {
        return el.classList.remove('is-invalid');
      });
      if (_register_js__WEBPACK_IMPORTED_MODULE_2__.validarForm(inputs)) {
        var formData = new FormData();
        formData.append('name', document.querySelector('[name=name]').value);
        formData.append('email', document.querySelector('[name=email]').value);
        formData.append('company', document.querySelector('[name=company]').value);
        formData.append('password', document.querySelector('[name=password]').value);
        formData.append('password_confirmation', document.querySelector('[name=password_confirmation]').value);
        formData.append('_token', document.querySelector('[name=_token]').value);
        _register_js__WEBPACK_IMPORTED_MODULE_2__.enviarDados(formData);
      }
    });
  }
  /*******************************************************
   * Scripts para recuperacao de senha
   ******************************************************/
  var resetForm = document.querySelector('#reset-form');
  if (resetForm !== null) {
    resetForm.addEventListener('submit', function (e) {
      e.preventDefault();
      var invalidFeedback = document.querySelectorAll('.invalid-feedback');
      invalidFeedback.forEach(function (el) {
        return el.remove();
      });
      var email = document.querySelector('[name=email]');
      email.classList.remove();
      var parent = email.parentElement;
      if (!(0,_utils_js__WEBPACK_IMPORTED_MODULE_0__.validateEmail)(email.value)) {
        _autenticacao_js__WEBPACK_IMPORTED_MODULE_1__.setErrorMessage(email, 'Informe um endereço de email válido.');
        return;
      }
      _autenticacao_js__WEBPACK_IMPORTED_MODULE_1__.switchLoader(true);
      var formData = new FormData();
      formData.append('email', document.querySelector('[name=email]').value);
      formData.append('_token', document.querySelector('[name=_token]').value);
      var statusText = 'success';
      var message = null;
      fetch('password-reset', {
        method: 'POST',
        body: formData,
        headers: {
          'Accept': 'application/json'
        }
      }).then(function (response) {
        if (!response.ok) {
          switch (response.status) {
            case 400:
              statusText = 'danger';
              break;
            case 401:
              statusText = 'danger';
              break;
            case 419:
              message = 'O tempo do formulário expirou! Recarregue a página e tente de novo.', 'danger';
              statusText = 'warning';
              break;
            case 500:
              message = 'Erro interno do servidor! Informe o administrador.', 'danger';
              statusText = 'danger';
              break;
            default:
              message = 'Erro interno desconhecido';
              statusText = 'danger';
          }
        }
        return response.json();
      }).then(function (data) {
        _autenticacao_js__WEBPACK_IMPORTED_MODULE_1__.switchLoader(false);
        if (statusText == 'success') {
          var resetModal = document.querySelector('#reset-modal');
          var modal = new bootstrap.Modal(resetModal, {
            backdrop: 'static'
          });
          modal.show();
          resetModal.addEventListener('hidden.bs.modal', function (event) {
            window.location.href = '/login';
          });
          return;
        }
        _autenticacao_js__WEBPACK_IMPORTED_MODULE_1__.setAlert(message !== null && message !== void 0 ? message : 'O endereço de email informado não está cadastrado!', statusText);
      })["catch"](function (error) {
        _autenticacao_js__WEBPACK_IMPORTED_MODULE_1__.setAlert('Erro de solicitação desconhecido', 'danger');
      });
    });
  }
});
})();

/******/ })()
;
//# sourceMappingURL=data:application/json;charset=utf-8;base64,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QWMsQ0FBQztVQUN6RCxJQUFNaUQsS0FBSyxHQUFHLElBQUlDLFNBQVMsQ0FBQ0MsS0FBSyxDQUFDNkUsVUFBVSxFQUFFO1lBQUU1RSxRQUFRLEVBQUU7VUFBUyxDQUFDLENBQUM7VUFDckVILEtBQUssQ0FBQy9DLElBQUksQ0FBQyxDQUFDO1VBQ1o4SCxVQUFVLENBQUMzRSxnQkFBZ0IsQ0FBQyxpQkFBaUIsRUFBRSxVQUFVQyxLQUFLLEVBQUU7WUFDNURDLE1BQU0sQ0FBQ0MsUUFBUSxDQUFDQyxJQUFJLEdBQUcsUUFBUTtVQUNuQyxDQUFDLENBQUM7VUFDRjtRQUNKO1FBQ0FyRCxzREFBYSxDQUFDL0IsT0FBTyxhQUFQQSxPQUFPLGNBQVBBLE9BQU8sR0FBSSxvREFBb0QsRUFBRWlELFVBQVUsQ0FBQztNQUM5RixDQUFDLENBQUMsU0FDSSxDQUFDLFVBQUFzQixLQUFLLEVBQUk7UUFDWnhDLHNEQUFhLENBQUMsa0NBQWtDLEVBQUUsUUFBUSxDQUFDO01BQy9ELENBQUMsQ0FBQztJQUNWLENBQUMsQ0FBQztFQUNOO0FBQ0osQ0FBQyxDQUFDLEMiLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9yZXNvdXJjZXMvanMvcHVibGljL2F1dGVudGljYWNhby5qcyIsIndlYnBhY2s6Ly8vLi9yZXNvdXJjZXMvanMvcHVibGljL3JlZ2lzdGVyLmpzIiwid2VicGFjazovLy8uL3Jlc291cmNlcy9qcy91dGlscy5qcyIsIndlYnBhY2s6Ly8vd2VicGFjay9ib290c3RyYXAiLCJ3ZWJwYWNrOi8vL3dlYnBhY2svcnVudGltZS9kZWZpbmUgcHJvcGVydHkgZ2V0dGVycyIsIndlYnBhY2s6Ly8vd2VicGFjay9ydW50aW1lL2hhc093blByb3BlcnR5IHNob3J0aGFuZCIsIndlYnBhY2s6Ly8vd2VicGFjay9ydW50aW1lL21ha2UgbmFtZXNwYWNlIG9iamVjdCIsIndlYnBhY2s6Ly8vLi9yZXNvdXJjZXMvanMvcHVibGljL2FwcC5qcyJdLCJzb3VyY2VzQ29udGVudCI6WyIvKipcclxuICogU2NyaXB0cyBwYXJhIGF1dGVudGljYWNhbyAobG9naW4sIHJlZ2lzdHJvIGUgcmVjdXBlcmFjYW8gZGUgc2VuaGEpXHJcbiAqL1xyXG4ndXNlIHN0cmljdCdcclxuXHJcbi8qKlxyXG4gKiBFeGliZSBtZW5zYWdlbnMgZGUgZXJybyBkb3MgY2FtcG9zXHJcbiAqL1xyXG5leHBvcnQgZnVuY3Rpb24gc2V0RXJyb3JNZXNzYWdlKGVsLCBtZXNzYWdlKSB7XHJcbiAgICBjb25zdCBkaXYgPSBkb2N1bWVudC5jcmVhdGVFbGVtZW50KCdkaXYnKTtcclxuICAgIGVsLmNsYXNzTGlzdC5hZGQoJ2lzLWludmFsaWQnKTtcclxuICAgIGRpdi5jbGFzc0xpc3QuYWRkKCdpbnZhbGlkLWZlZWRiYWNrJyk7XHJcbiAgICBkaXYudGV4dENvbnRlbnQgPSBtZXNzYWdlO1xyXG4gICAgZWwuaW5zZXJ0QWRqYWNlbnRFbGVtZW50KCdhZnRlcmVuZCcsIGRpdik7XHJcbn07XHJcbi8qKlxyXG4gKiBFeGliZSBtZW5zYWdlbnMgZGUgZXJybyBkbyBzZXJ2aWRvclxyXG4gKi9cclxuY29uc3QgaWNvbkNsYXNzID0ge1xyXG4gICAgc3VjY2VzczogJ2JpLWNoZWNrLWNpcmNsZS1maWxsJyxcclxuICAgIHdhcm5pbmc6ICdiaS1leGNsYW1hdGlvbi10cmlhbmdsZS1maWxsJyxcclxuICAgIGRhbmdlcjogJ2JpLWRhc2gtY2lyY2xlLWZpbGwnLFxyXG59XHJcbmV4cG9ydCBmdW5jdGlvbiAgc2V0QWxlcnQobWVzc2FnZSwgdHlwZSA9ICdzdWNjZXNzJykge1xyXG4gICAgY29uc3QgYWxlcnRzID0gZG9jdW1lbnQucXVlcnlTZWxlY3RvckFsbCgnLmFsZXJ0Jyk7XHJcbiAgICBhbGVydHMuZm9yRWFjaChlbCA9PiBlbC5yZW1vdmUoKSk7XHJcbiAgICBsZXQgaWNvbiA9IGRvY3VtZW50LmNyZWF0ZUVsZW1lbnQoJ2knKTtcclxuICAgIGljb24uY2xhc3NMaXN0LmFkZCgnYmknLCBpY29uQ2xhc3NbdHlwZV0pO1xyXG4gICAgY29uc3QgYWxlcnQgPSBkb2N1bWVudC5jcmVhdGVFbGVtZW50KCdkaXYnKTtcclxuICAgIGFsZXJ0LmNsYXNzTGlzdC5hZGQoJ2FsZXJ0JywgYGFsZXJ0LSR7dHlwZX1gKTtcclxuICAgIGFsZXJ0LnNldEF0dHJpYnV0ZSgncm9sZScsICdhbGVydCcpO1xyXG4gICAgYWxlcnQuYXBwZW5kKGljb24pO1xyXG4gICAgYWxlcnQuYXBwZW5kKGAgJHttZXNzYWdlfWApO1xyXG4gICAgY29uc3QgY2FyZCA9IGRvY3VtZW50LnF1ZXJ5U2VsZWN0b3IoJy5jYXJkLWJvZHknKTtcclxuICAgIGNhcmQuYXBwZW5kKGFsZXJ0KTtcclxufVxyXG5cclxuZXhwb3J0IGZ1bmN0aW9uICBzd2l0Y2hMb2FkZXIoc2hvdyA9IHRydWUpIHtcclxuICAgIGNvbnN0IGxvYWRlciA9IGRvY3VtZW50LnF1ZXJ5U2VsZWN0b3IoJyNsb2FkZXInKTtcclxuICAgIGlmIChzaG93KSB7XHJcbiAgICAgICAgbG9hZGVyLmNsYXNzTGlzdC5yZW1vdmUoJ2Qtbm9uZScpO1xyXG4gICAgICAgIGxvYWRlci5jbGFzc0xpc3QuYWRkKCdkLWZsZXgnKTtcclxuICAgIH0gZWxzZSB7XHJcbiAgICAgICAgbG9hZGVyLmNsYXNzTGlzdC5yZW1vdmUoJ2QtZmxleCcpO1xyXG4gICAgICAgIGxvYWRlci5jbGFzc0xpc3QuYWRkKCdkLW5vbmUnKTtcclxuICAgIH1cclxufSIsIi8qKlxyXG4gKiBTY3JpcHRzIHBhcmEgcmVnaXN0cm9cclxuICovXHJcbmltcG9ydCAqIGFzIGF1dGggZnJvbSAnLi9hdXRlbnRpY2FjYW8uanMnO1xyXG5pbXBvcnR7dmFsaWRhdGVFbWFpbH0gZnJvbSAnLi4vdXRpbHMuanMnO1xyXG4vKipcclxuICogVmFsaWRhIG9zIGNhbXBvcyBkbyBmb3JtXHJcbiAqIEBwYXJhbSB7Kn0gZWxlbWVudHMgXHJcbiAqIEByZXR1cm5zIGJvb2xlYW5cclxuICovXHJcbmNvbnN0IHBhc3N3b3JkUGF0dGVybiA9IC9eKD89LipbYS16XSkoPz0uKltBLVpdKSg/PS4qXFxkKSg/PS4qW0AkISUqPyZdKVtBLVphLXpcXGRAJCElKj8mXXs4LH0kLztcclxuZXhwb3J0IGZ1bmN0aW9uIHZhbGlkYXJGb3JtKGVsZW1lbnRzKSB7XHJcbiAgICBsZXQgaXNWYWxpZCA9IHRydWU7XHJcbiAgICBlbGVtZW50cy5mb3JFYWNoKChlbCkgPT4ge1xyXG4gICAgICAgIGNvbnN0IG5hbWUgPSBlbC5nZXRBdHRyaWJ1dGUoJ25hbWUnKTtcclxuICAgICAgICBjb25zdCBwYXJlbnQgPSBlbC5wYXJlbnRFbGVtZW50O1xyXG4gICAgICAgIGNvbnN0IGNvbmZpcm0gPSBuYW1lID09ICdwYXNzd29yZCcgPyBkb2N1bWVudC5xdWVyeVNlbGVjdG9yKCdbbmFtZT1wYXNzd29yZF9jb25maXJtYXRpb25dJykgOiBudWxsO1xyXG4gICAgICAgIGlmICghZWwudmFsdWUpIHtcclxuICAgICAgICAgICAgYXV0aC5zZXRFcnJvck1lc3NhZ2UocGFyZW50Lm5leHRFbGVtZW50U2libGluZywgJ0NhbXBvIG9icmlnYXTDs3JpbycpO1xyXG4gICAgICAgICAgICBlbC5jbGFzc0xpc3QuYWRkKCdpcy1pbnZhbGlkJyk7XHJcbiAgICAgICAgICAgIGlzVmFsaWQgPSBmYWxzZTtcclxuICAgICAgICB9XHJcbiAgICAgICAgZWxzZSBpZiAobmFtZSA9PSAnZW1haWwnICYmICF2YWxpZGF0ZUVtYWlsKGVsLnZhbHVlKSkge1xyXG4gICAgICAgICAgICBhdXRoLnNldEVycm9yTWVzc2FnZShwYXJlbnQubmV4dEVsZW1lbnRTaWJsaW5nLCAnUG9yIGZhdm9yLCBpbnNpcmEgdW0gZW5kZXJlw6dvIGRlIGVtYWlsIHbDoWxpZG8uJyk7XHJcbiAgICAgICAgICAgIGVsLmNsYXNzTGlzdC5hZGQoJ2lzLWludmFsaWQnKTtcclxuICAgICAgICAgICAgaXNWYWxpZCA9IGZhbHNlO1xyXG4gICAgICAgIH1cclxuICAgICAgICBlbHNlIGlmIChuYW1lID09IFwicGFzc3dvcmRcIiAmJiAhcGFzc3dvcmRQYXR0ZXJuLnRlc3QoZWwudmFsdWUpKSB7XHJcbiAgICAgICAgICAgIGF1dGguc2V0RXJyb3JNZXNzYWdlKHBhcmVudC5uZXh0RWxlbWVudFNpYmxpbmcsICdBIHNlbmhhIGRldmUgdGVyIG5vIG3DrW5pbW8gOCBjYXJhY3RlcmVzLCBpbmNsdWluZG8gcGVsbyBtZW5vcyB1bWEgbGV0cmEgbWFpw7pzY3VsYSwgdW1hIGxldHJhIG1pbsO6c2N1bGEsIHVtIG7Dum1lcm8gZSB1bSBjYXJhY3RlcmUgZXNwZWNpYWwuJyk7XHJcbiAgICAgICAgICAgIGVsLmNsYXNzTGlzdC5hZGQoJ2lzLWludmFsaWQnKTtcclxuICAgICAgICAgICAgaXNWYWxpZCA9IGZhbHNlO1xyXG4gICAgICAgIH1cclxuICAgICAgICBlbHNlIGlmIChuYW1lID09IFwicGFzc3dvcmRcIiAmJiBlbC52YWx1ZSAhPT0gY29uZmlybS52YWx1ZSkge1xyXG4gICAgICAgICAgICBhdXRoLnNldEVycm9yTWVzc2FnZShwYXJlbnQubmV4dEVsZW1lbnRTaWJsaW5nLCAnQSBjb25maXJtYcOnw6NvIGRlIHNlbmhhIG7Do28gY29ycmVzcG9uZGUuJyk7XHJcbiAgICAgICAgICAgIGVsLmNsYXNzTGlzdC5hZGQoJ2lzLWludmFsaWQnKTtcclxuICAgICAgICAgICAgaXNWYWxpZCA9IGZhbHNlO1xyXG4gICAgICAgIH1cclxuICAgIH0pO1xyXG4gICAgY29uc3QgdGVybW9zID0gZG9jdW1lbnQucXVlcnlTZWxlY3RvcignLmZvcm0tY2hlY2staW5wdXQnKTtcclxuICAgIGlmICh0ZXJtb3MuY2hlY2tlZCA9PSBmYWxzZSkge1xyXG4gICAgICAgIGNvbnN0IHBhcmVudCA9IHRlcm1vcy5wYXJlbnRFbGVtZW50O1xyXG4gICAgICAgIGF1dGguc2V0QWxlcnQoJ1ZvY8OqIGRldmUgYWNlaXRhciBvcyB0ZXJtb3MgZGUgdXNvIScsICd3YXJuaW5nJyk7XHJcbiAgICAgICAgaXNWYWxpZCA9IGZhbHNlO1xyXG4gICAgfVxyXG4gICAgcmV0dXJuIGlzVmFsaWQ7XHJcbn1cclxuLyoqXHJcbiAqIEVudmlhIG8gZm9ybXVsYXJpb1xyXG4gKiBAcGFyYW1zIGZvcm1EYXRhIE8gT2JqZXRvIGNvbSBvcyBkYWRvcyBkbyBmb3JtdWxhcmlvXHJcbiAqL1xyXG5leHBvcnQgZnVuY3Rpb24gZW52aWFyRGFkb3MoZm9ybURhdGEpIHtcclxuICAgIGxldCBzdGF0dXNUZXh0ID0gJ3N1Y2Nlc3MnO1xyXG4gICAgbGV0IG1lc3NhZ2UgPSBudWxsO1xyXG4gICAgYXV0aC5zd2l0Y2hMb2FkZXIoKTtcclxuICAgIGZldGNoKCdyZWdpc3RlcicsIHtcclxuICAgICAgICBtZXRob2Q6ICdQT1NUJyxcclxuICAgICAgICBib2R5OiBmb3JtRGF0YSxcclxuICAgICAgICBoZWFkZXJzOiB7XHJcbiAgICAgICAgICAgICdBY2NlcHQnOiAnYXBwbGljYXRpb24vanNvbidcclxuICAgICAgICB9XHJcbiAgICB9KVxyXG4gICAgICAgIC50aGVuKHJlc3BvbnNlID0+IHtcclxuICAgICAgICAgICAgaWYgKCFyZXNwb25zZS5vaykge1xyXG4gICAgICAgICAgICAgICAgW3N0YXR1c1RleHQsIG1lc3NhZ2VdID0gc2V0YXJFcnJvKHJlc3BvbnNlLnN0YXR1cywgW3N0YXR1c1RleHQsIG1lc3NhZ2VdKTtcclxuICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICByZXR1cm4gcmVzcG9uc2UuanNvbigpO1xyXG4gICAgICAgIH0pXHJcbiAgICAgICAgLnRoZW4oZGF0YSA9PiB7XHJcbiAgICAgICAgICAgIC8vRmVjaGEgbyBsb2FkZXJcclxuICAgICAgICAgICAgYXV0aC5zd2l0Y2hMb2FkZXIoZmFsc2UpO1xyXG4gICAgICAgICAgICBpZiAoc3RhdHVzVGV4dCA9PSAnc3VjY2VzcycpIHtcclxuICAgICAgICAgICAgICAgIGV4aWJpck1vZGFsKCk7XHJcbiAgICAgICAgICAgICAgICByZXR1cm47XHJcbiAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgaWYgKGRhdGEuZXJyb3JzICE9IG51bGwpIHtcclxuICAgICAgICAgICAgICAgIE9iamVjdC5rZXlzKGRhdGEuZXJyb3JzKS5tYXAoKGtleSkgPT4ge1xyXG4gICAgICAgICAgICAgICAgICAgIGNvbnN0IGVsID0gZG9jdW1lbnQucXVlcnlTZWxlY3RvcihgW25hbWU9JHtrZXl9XWApO1xyXG4gICAgICAgICAgICAgICAgICAgIGNvbnN0IHBhcmVudCA9IGVsLnBhcmVudEVsZW1lbnQ7XHJcbiAgICAgICAgICAgICAgICAgICAgZGF0YS5lcnJvcnNba2V5XS5tYXAoKG1zZykgPT4ge1xyXG4gICAgICAgICAgICAgICAgICAgICAgICBlbC5jbGFzc0xpc3QuYWRkKCdpcy1pbnZhbGlkJyk7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIGF1dGguc2V0RXJyb3JNZXNzYWdlKHBhcmVudC5uZXh0RWxlbWVudFNpYmxpbmcsIG1zZyk7XHJcbiAgICAgICAgICAgICAgICAgICAgfSk7XHJcbiAgICAgICAgICAgICAgICB9KTtcclxuICAgICAgICAgICAgICAgIHJldHVybjtcclxuICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICBhdXRoLnNldEFsZXJ0KG1lc3NhZ2UgPz8gZGF0YS5tZXNzYWdlLCBzdGF0dXNUZXh0KTtcclxuICAgICAgICB9KVxyXG4gICAgICAgIC5jYXRjaChlcnJvciA9PiB7XHJcbiAgICAgICAgICAgIGF1dGguc3dpdGNoTG9hZGVyKGZhbHNlKTtcclxuICAgICAgICAgICAgYXV0aC5zZXRBbGVydCgnRXJybyBkZSBzb2xpY2l0YcOnw6NvIGRlc2NvbmhlY2lkbycsICdkYW5nZXInKTtcclxuICAgICAgICB9KTtcclxufVxyXG4vKipcclxuICogUmV0b3JuYSBvIGVycm8gZGEgcmVxdWlzaWNhb1xyXG4gKiBAcGFyYW1zIHN0YXR1c1RleHRcclxuICovXHJcbmV4cG9ydCBmdW5jdGlvbiBzZXRhckVycm8oc3RhdHVzLCBbc3RhdHVzVGV4dCwgbWVzc2FnZV0pIHtcclxuICAgIHN3aXRjaCAoc3RhdHVzKSB7XHJcbiAgICAgICAgY2FzZSA0MDA6XHJcbiAgICAgICAgICAgIHN0YXR1c1RleHQgPSAnZGFuZ2VyJztcclxuICAgICAgICAgICAgYnJlYWs7XHJcbiAgICAgICAgY2FzZSA0MDE6XHJcbiAgICAgICAgICAgIHN0YXR1c1RleHQgPSAnZGFuZ2VyJztcclxuICAgICAgICAgICAgYnJlYWs7XHJcbiAgICAgICAgY2FzZSA0MTk6XHJcbiAgICAgICAgICAgIG1lc3NhZ2UgPSAnTyB0ZW1wbyBkbyBmb3JtdWzDoXJpbyBleHBpcm91ISBSZWNhcnJlZ3VlIGEgcMOhZ2luYSBlIHRlbnRlIGRlIG5vdm8uJywgJ2Rhbmdlcic7XHJcbiAgICAgICAgICAgIHN0YXR1c1RleHQgPSAnd2FybmluZyc7XHJcbiAgICAgICAgICAgIGJyZWFrXHJcbiAgICAgICAgY2FzZSA1MDA6XHJcbiAgICAgICAgICAgIG1lc3NhZ2UgPSAnRXJybyBpbnRlcm5vIGRvIHNlcnZpZG9yISBJbmZvcm1lIG8gYWRtaW5pc3RyYWRvci4nLCAnZGFuZ2VyJztcclxuICAgICAgICAgICAgc3RhdHVzVGV4dCA9ICdkYW5nZXInO1xyXG4gICAgICAgICAgICBicmVhaztcclxuICAgICAgICBkZWZhdWx0OlxyXG4gICAgICAgICAgICBtZXNzYWdlID0gJ0Vycm8gaW50ZXJubyBkZXNjb25oZWNpZG8nO1xyXG4gICAgICAgICAgICBzdGF0dXNUZXh0ID0gJ2Rhbmdlcic7XHJcbiAgICB9XHJcbiAgICByZXR1cm4gW3N0YXR1c1RleHQsIG1lc3NhZ2VdO1xyXG59XHJcbi8qKlxyXG4gKiBFeGliZSBvIG1vZGFsIGNvbSBhIGluZm9ybWNhbyBzb2JyZSBhIGFwcm92YWNhb1xyXG4gKi9cclxuZXhwb3J0IGZ1bmN0aW9uIGV4aWJpck1vZGFsKCkge1xyXG4gICAgY29uc3QgcmVnaXN0ZXJNb2RhbCA9IGRvY3VtZW50LmdldEVsZW1lbnRCeUlkKCdyZWdpc3Rlck1vZGFsJyk7XHJcbiAgICBjb25zdCBtb2RhbCA9IG5ldyBib290c3RyYXAuTW9kYWwocmVnaXN0ZXJNb2RhbCwgeyBiYWNrZHJvcDogJ3N0YXRpYycgfSk7XHJcbiAgICBtb2RhbC5zaG93KCk7XHJcbiAgICByZWdpc3Rlck1vZGFsLmFkZEV2ZW50TGlzdGVuZXIoJ2hpZGRlbi5icy5tb2RhbCcsIGZ1bmN0aW9uIChldmVudCkge1xyXG4gICAgICAgIHdpbmRvdy5sb2NhdGlvbi5ocmVmID0gJy9sb2dpbic7XHJcbiAgICB9KTtcclxufSIsIi8qKlxyXG4gKiBNb2R1bG8gY29tIGZ1bmNvZXMgZGUgdXNvIGdlcmFsXHJcbiAqL1xyXG4vKipcclxuICogUGFkcmFvIGRhIHNlbmhhIHBhcmEgdmFsaWRhY2FvXHJcbiAqL1xyXG5jb25zdCBwYXNzd29yZFBhdHRlcm4gPSAvXig/PS4qW2Etel0pKD89LipbQS1aXSkoPz0uKlxcZCkoPz0uKltAJCElKj8mXSlbQS1aYS16XFxkQCQhJSo/Jl17OCx9JC87XHJcbi8qKlxyXG4gKiBWYWxpZGEgdW0gZW5kZXJlY28gZGUgZW1haWxcclxuICogQHBhcmFtIHtzdHJpbmd9IGVtYWlsXHJcbiAqIEByZXR1cm4gYm9vbGVhblxyXG4gKi9cclxuZXhwb3J0IGZ1bmN0aW9uIHZhbGlkYXRlRW1haWwoZW1haWwpIHtcclxuICAgIGNvbnN0IGVtYWlsUGF0dGVybiA9IC9eW2EtekEtWjAtOS5fJSstXStAW2EtekEtWjAtOS4tXStcXC5bYS16QS1aXXsyLH0kLztcclxuICAgIHJldHVybiBlbWFpbFBhdHRlcm4udGVzdChlbWFpbCk7XHJcbn1cclxuLyoqXHJcbiAqIEZvcm1hdGEgdW1hIHN0cmluZyBubyBwYWRyYW8gJ1N0cmluZydcclxuICogQHBhcmFtIHtzdHJpbmd9IHN0ciBcclxuICogQHJldHVybnMgXHJcbiAqL1xyXG5leHBvcnQgZnVuY3Rpb24gY2FwaXRhbGl6ZShzdHIpIHtcclxuICAgIHJldHVybiBzdHIuY2hhckF0KDApICsgc3RyLnNsaWNlKDEpLnRvTG93ZXJDYXNlKCk7XHJcbn1cclxuLyoqXHJcbiAqIEZvcm1hdGEgdW1hIGRhdGEgbm8gcGFkcm8gbG9jYWwgKHB0LUJSKVxyXG4gKiBAcGFyYW0ge3N0cmluZ30gZGF0ZVN0cmluZyBcclxuICogQHJldHVybnMgXHJcbiAqL1xyXG5leHBvcnQgZnVuY3Rpb24gZm9ybWF0RGF0ZShkYXRlU3RyaW5nKSB7XHJcbiAgICBjb25zdCBkYXRlID0gbmV3IERhdGUoZGF0ZVN0cmluZy5yZXBsYWNlKCcgJywgJ1QnKSlcclxuICAgIGNvbnN0IGZvcm1hdHRlciA9IG5ldyBJbnRsLkRhdGVUaW1lRm9ybWF0KCdwdC1CUicsIHsgeWVhcjogJ251bWVyaWMnLCBtb250aDogJzItZGlnaXQnLCBkYXk6ICcyLWRpZ2l0JywgaG91cjogJzItZGlnaXQnLCBtaW51dGU6ICcyLWRpZ2l0JyB9KTtcclxuICAgIHJldHVybiBmb3JtYXR0ZXIuZm9ybWF0KGRhdGUpO1xyXG59XHJcbi8qKlxyXG4gKiBDYWxjdWxhIG8gdGVtcG8gcGFzc2FkbyBhIHBhcnRpciBkZSB1bSBkYWRvIG1vbWVudG9cclxuICogQHBhcmFtIHtzdHJpbmd9IGRhdGVTdHJpbmcgXHJcbiAqIEByZXR1cm5zIFxyXG4gKi9cclxuZXhwb3J0IGZ1bmN0aW9uIHRpbWVFbGFwc2VkKGRhdGVTdHJpbmcpIHtcclxuICAgIFxyXG4gICAgY29uc3QgZGF0ZSA9IG5ldyBEYXRlKGRhdGVTdHJpbmcucmVwbGFjZShcIiBcIiwgXCJUXCIpKTtcclxuICAgIGNvbnN0IG5vdyA9IG5ldyBEYXRlKCk7XHJcblxyXG4gICAgLy8gQ2FsY3VsYSBhIGRpZmVyZW5jYSBlbSBtaWxpc2VndW5kb3NcclxuICAgIGNvbnN0IGRpZmZJbk1zID0gbm93IC0gZGF0ZTtcclxuXHJcbiAgICAvLyBjb252ZXJ0ZSBvcyBtaWxpc2VndW5kb3NcclxuICAgIGNvbnN0IHNlY29uZHMgPSBkaWZmSW5NcyAvIDEwMDA7XHJcbiAgICBjb25zdCBtaW51dGVzID0gc2Vjb25kcyAvIDYwO1xyXG4gICAgY29uc3QgaG91cnMgPSBtaW51dGVzIC8gNjA7XHJcbiAgICBjb25zdCBkYXlzID0gaG91cnMgLyAyNDtcclxuICAgIGNvbnN0IHdlZWtzID0gZGF5cyAvIDc7XHJcbiAgICBjb25zdCBtb250aHMgPSBkYXlzIC8gMzA7XHJcblxyXG4gICAgLy8gQ3JpYSB1bWEgaW5zdGFuY2lhIGRlIFJlbGF0aXZlVGltZUZvcm1hdFxyXG4gICAgY29uc3QgcnRmID0gbmV3IEludGwuUmVsYXRpdmVUaW1lRm9ybWF0KCdlbicsIHsgbnVtZXJpYzogJ2F1dG8nIH0pO1xyXG5cclxuICAgIC8vIFJldG9ybmEgbyB0ZW1wbyBjb20gYmFzZSBubyBjbGFjdWxvXHJcbiAgICBpZiAoTWF0aC5hYnMobWludXRlcykgPCA2MCkge1xyXG4gICAgICAgIHJldHVybiBgJHtNYXRoLnJvdW5kKG1pbnV0ZXMpfSBtaW51dG8ke01hdGgucm91bmQobWludXRlcykgIT09IDEgPyAncycgOiAnJ31gO1xyXG4gICAgfSBlbHNlIGlmIChNYXRoLmFicyhob3VycykgPCAxNCkge1xyXG4gICAgICAgIHJldHVybiBgJHtNYXRoLnJvdW5kKGhvdXJzKX0gaG9yYSR7TWF0aC5yb3VuZChob3VycykgIT09IDEgPyAncycgOiAnJ31gO1xyXG4gICAgfSBlbHNlIGlmIChNYXRoLmFicyhkYXlzKSA8IDMwKSB7XHJcbiAgICAgICAgcmV0dXJuIGAke01hdGgucm91bmQoZGF5cyl9IGRpYSR7TWF0aC5yb3VuZChkYXlzKSAhPT0gMSA/ICdzJyA6ICcnfWA7XHJcbiAgICB9IGVsc2UgaWYgKE1hdGguYWJzKHdlZWtzKSA8IDQpIHtcclxuICAgICAgICByZXR1cm4gYCR7TWF0aC5yb3VuZCh3ZWVrcyl9IHNlbWFuYSR7TWF0aC5yb3VuZCh3ZWVrcykgIT09IDEgPyAncycgOiAnJ31gO1xyXG4gICAgfSBlbHNlIHtcclxuICAgICAgICByZXR1cm4gYCR7TWF0aC5yb3VuZChtb250aHMpfSAke01hdGgucm91bmQobW9udGhzKSA9PT0gMSA/ICdtw6pzJyA6ICdtZXNlcyd9YDtcclxuICAgIH1cclxufVxyXG4vKipcclxuICogUHJlZW5jaGUgdW1hIHRhYmVsYSBjb20gbGluaGFzIHByZWVuY2hpZGFzIGNvbSBwbGFjZWhvbGRlcnNcclxuICogQHBhcmFtIHtzdHJpbmd9IHRhYmxlSWQgXHJcbiAqIEBwYXJhbSB7bnVtZXJpY30gbnVtUm93cyBcclxuICogQHBhcmFtIHtudW1lcmljfSBudW1Db2xzIFxyXG4gKiBAcmV0dXJucyBcclxuICovXHJcbmV4cG9ydCBmdW5jdGlvbiBmaWxsVGFibGVXaXRoUGxhY2Vob2xkZXJzKHRhYmxlSWQsIG51bVJvd3MsIG51bUNvbHMpIHtcclxuICAgIC8vIFBlZ2EgYSB0YWJlbGFcclxuICAgIGNvbnN0IHRhYmxlID0gZG9jdW1lbnQuZ2V0RWxlbWVudEJ5SWQodGFibGVJZCk7XHJcbiAgICBcclxuICAgIC8vIFJldG9ybmEgZXJybyBzZSBuw6NvIGV4aXN0aXJcclxuICAgIGlmICghdGFibGUpIHtcclxuICAgICAgICBjb25zb2xlLmVycm9yKCdUYWJlbGEgbsOjbyBlbmNvbnRyYWRhIScpO1xyXG4gICAgICAgIHJldHVybjtcclxuICAgIH1cclxuICAgIGNvbnN0IGxpbmVzID0gW107XHJcbiAgICAvLyBDcmlhIGFzIGxpbmhhc1xyXG4gICAgZm9yIChsZXQgaSA9IDA7IGkgPCBudW1Sb3dzOyBpKyspIHtcclxuICAgICAgICBjb25zdCB0ciA9IGRvY3VtZW50LmNyZWF0ZUVsZW1lbnQoJ3RyJyk7XHJcblxyXG4gICAgICAgIC8vIENyaWEgYSBjZWx1bGEgKGNvbHVuYSlcclxuICAgICAgICBmb3IgKGxldCBqID0gMDsgaiA8IG51bUNvbHM7IGorKykge1xyXG4gICAgICAgICAgICBjb25zdCB0ZCA9IGRvY3VtZW50LmNyZWF0ZUVsZW1lbnQoJ3RkJyk7XHJcblxyXG4gICAgICAgICAgICAvLyBDcmlhIG8gcGxhY2Vob2xkZXJcclxuICAgICAgICAgICAgY29uc3QgcGxhY2Vob2xkZXIgPSBkb2N1bWVudC5jcmVhdGVFbGVtZW50KCdkaXYnKTtcclxuICAgICAgICAgICAgcGxhY2Vob2xkZXIuY2xhc3NMaXN0LmFkZCgncGxhY2Vob2xkZXInLCAnZ2xvdycpO1xyXG4gICAgICAgICAgICBwbGFjZWhvbGRlci5pbm5lckhUTUwgPSAnPHNwYW4gY2xhc3M9XCJ2aXN1YWxseS1oaWRkZW5cIj5Mb2FkaW5nLi4uPC9zcGFuPic7XHJcblxyXG4gICAgICAgICAgICAvLyBpbnNlcmUgbmEgY2VsdWxhXHJcbiAgICAgICAgICAgIHRkLmFwcGVuZChwbGFjZWhvbGRlcik7XHJcblxyXG4gICAgICAgICAgICBsaW5lcy5wdXNoKHRkKVxyXG4gICAgICAgIH1cclxuICAgIH1cclxuICAgIHJldHVybiBsaW5lcztcclxufVxyXG4vKipcclxuICogUmV0b3JuYSB1bWEgaW5zdGFuY2lhIGRhIHRhYmVsYSBodG1sc1xyXG4gKiBAcGFyYW0ge3N0cmluZ30gaWQgXHJcbiAqL1xyXG5leHBvcnQgZnVuY3Rpb24gZ2V0RGF0YXRhYmxlT2JqZWN0KGlkKXtcclxuICAgIHJldHVybiBuZXcgc2ltcGxlRGF0YXRhYmxlcy5EYXRhVGFibGUoYCMke2lkfWAsIHtcclxuICAgICAgICBsYWJlbHM6IHB0X0JSXHJcbiAgICB9KTtcclxufSIsIi8vIFRoZSBtb2R1bGUgY2FjaGVcbnZhciBfX3dlYnBhY2tfbW9kdWxlX2NhY2hlX18gPSB7fTtcblxuLy8gVGhlIHJlcXVpcmUgZnVuY3Rpb25cbmZ1bmN0aW9uIF9fd2VicGFja19yZXF1aXJlX18obW9kdWxlSWQpIHtcblx0Ly8gQ2hlY2sgaWYgbW9kdWxlIGlzIGluIGNhY2hlXG5cdHZhciBjYWNoZWRNb2R1bGUgPSBfX3dlYnBhY2tfbW9kdWxlX2NhY2hlX19bbW9kdWxlSWRdO1xuXHRpZiAoY2FjaGVkTW9kdWxlICE9PSB1bmRlZmluZWQpIHtcblx0XHRyZXR1cm4gY2FjaGVkTW9kdWxlLmV4cG9ydHM7XG5cdH1cblx0Ly8gQ3JlYXRlIGEgbmV3IG1vZHVsZSAoYW5kIHB1dCBpdCBpbnRvIHRoZSBjYWNoZSlcblx0dmFyIG1vZHVsZSA9IF9fd2VicGFja19tb2R1bGVfY2FjaGVfX1ttb2R1bGVJZF0gPSB7XG5cdFx0Ly8gbm8gbW9kdWxlLmlkIG5lZWRlZFxuXHRcdC8vIG5vIG1vZHVsZS5sb2FkZWQgbmVlZGVkXG5cdFx0ZXhwb3J0czoge31cblx0fTtcblxuXHQvLyBFeGVjdXRlIHRoZSBtb2R1bGUgZnVuY3Rpb25cblx0X193ZWJwYWNrX21vZHVsZXNfX1ttb2R1bGVJZF0obW9kdWxlLCBtb2R1bGUuZXhwb3J0cywgX193ZWJwYWNrX3JlcXVpcmVfXyk7XG5cblx0Ly8gUmV0dXJuIHRoZSBleHBvcnRzIG9mIHRoZSBtb2R1bGVcblx0cmV0dXJuIG1vZHVsZS5leHBvcnRzO1xufVxuXG4iLCIvLyBkZWZpbmUgZ2V0dGVyIGZ1bmN0aW9ucyBmb3IgaGFybW9ueSBleHBvcnRzXG5fX3dlYnBhY2tfcmVxdWlyZV9fLmQgPSAoZXhwb3J0cywgZGVmaW5pdGlvbikgPT4ge1xuXHRmb3IodmFyIGtleSBpbiBkZWZpbml0aW9uKSB7XG5cdFx0aWYoX193ZWJwYWNrX3JlcXVpcmVfXy5vKGRlZmluaXRpb24sIGtleSkgJiYgIV9fd2VicGFja19yZXF1aXJlX18ubyhleHBvcnRzLCBrZXkpKSB7XG5cdFx0XHRPYmplY3QuZGVmaW5lUHJvcGVydHkoZXhwb3J0cywga2V5LCB7IGVudW1lcmFibGU6IHRydWUsIGdldDogZGVmaW5pdGlvbltrZXldIH0pO1xuXHRcdH1cblx0fVxufTsiLCJfX3dlYnBhY2tfcmVxdWlyZV9fLm8gPSAob2JqLCBwcm9wKSA9PiAoT2JqZWN0LnByb3RvdHlwZS5oYXNPd25Qcm9wZXJ0eS5jYWxsKG9iaiwgcHJvcCkpIiwiLy8gZGVmaW5lIF9fZXNNb2R1bGUgb24gZXhwb3J0c1xuX193ZWJwYWNrX3JlcXVpcmVfXy5yID0gKGV4cG9ydHMpID0+IHtcblx0aWYodHlwZW9mIFN5bWJvbCAhPT0gJ3VuZGVmaW5lZCcgJiYgU3ltYm9sLnRvU3RyaW5nVGFnKSB7XG5cdFx0T2JqZWN0LmRlZmluZVByb3BlcnR5KGV4cG9ydHMsIFN5bWJvbC50b1N0cmluZ1RhZywgeyB2YWx1ZTogJ01vZHVsZScgfSk7XG5cdH1cblx0T2JqZWN0LmRlZmluZVByb3BlcnR5KGV4cG9ydHMsICdfX2VzTW9kdWxlJywgeyB2YWx1ZTogdHJ1ZSB9KTtcbn07IiwiLyoqXHJcbiAqIFNjcmlwdHMgcGFyYSBhIGFyZWEgcHVibGljYSBkYSBhcGxpY2FjYW9cclxuICovXHJcbmltcG9ydCB7IHZhbGlkYXRlRW1haWwgfSBmcm9tICcuLi91dGlscy5qcyc7XHJcbmltcG9ydCAqIGFzIGF1dGggZnJvbSAnLi9hdXRlbnRpY2FjYW8uanMnO1xyXG5pbXBvcnQgKiBhcyByZWdpc3RlciBmcm9tICcuL3JlZ2lzdGVyLmpzJztcclxuLyoqXHJcbiAqIFNjcmlwdHMgcGFyYSBhIHRlbGEgZGUgbG9naW5cclxuICogQHZlcnNpb24gMS4wXHJcbiAqL1xyXG5kb2N1bWVudC5hZGRFdmVudExpc3RlbmVyKFwiRE9NQ29udGVudExvYWRlZFwiLCBmdW5jdGlvbiAoKSB7XHJcbiAgICAvKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKlxyXG4gICAgICogU2NyaXB0cyBwYXJhIGxvZ2luXHJcbiAgICAgKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqL1xyXG4gICAgY29uc3QgbG9naW5Gb3JtID0gZG9jdW1lbnQucXVlcnlTZWxlY3RvcignI2xvZ2luLWZvcm0nKTtcclxuICAgIGlmIChsb2dpbkZvcm0gIT09IG51bGwpIHtcclxuICAgICAgICBsb2dpbkZvcm0uYWRkRXZlbnRMaXN0ZW5lcignc3VibWl0JywgZnVuY3Rpb24gKGUpIHtcclxuICAgICAgICAgICAgZS5wcmV2ZW50RGVmYXVsdCgpO1xyXG4gICAgICAgICAgICBjb25zdCBlbWFpbCA9IGRvY3VtZW50LnF1ZXJ5U2VsZWN0b3IoJ1tuYW1lPWVtYWlsXScpO1xyXG4gICAgICAgICAgICBjb25zdCBwYXNzd29yZCA9IGRvY3VtZW50LnF1ZXJ5U2VsZWN0b3IoJ1tuYW1lPXBhc3N3b3JkXScpO1xyXG4gICAgICAgICAgICBjb25zdCBpbnB1dHMgPSBkb2N1bWVudC5xdWVyeVNlbGVjdG9yQWxsKCdbbmFtZT1cImVtYWlsXCJdLCBbbmFtZT1cInBhc3N3b3JkXCJdJyk7XHJcbiAgICAgICAgICAgIGNvbnN0IGVycm9yQ29udGFpbmVyID0gZG9jdW1lbnQucXVlcnlTZWxlY3RvckFsbCgnLmludmFsaWQtZmVlZGJhY2snKTtcclxuICAgICAgICAgICAgY29uc3QgaXNJbnZhbGlkID0gZG9jdW1lbnQucXVlcnlTZWxlY3RvckFsbCgnLmlzLWludmFsaWQnKTtcclxuXHJcbiAgICAgICAgICAgIGxldCBpc1ZhbGlkID0gdHJ1ZTtcclxuICAgICAgICAgICAgZXJyb3JDb250YWluZXIuZm9yRWFjaChlbCA9PiBlbC5yZW1vdmUoKSk7XHJcbiAgICAgICAgICAgIGlzSW52YWxpZC5mb3JFYWNoKGVsID0+IGVsLmNsYXNzTGlzdC5yZW1vdmUoJ2lzLWludmFsaWQnKSk7XHJcblxyXG4gICAgICAgICAgICBpbnB1dHMuZm9yRWFjaCgoZWwpID0+IHtcclxuICAgICAgICAgICAgICAgIGNvbnN0IG5hbWUgPSBlbC5nZXRBdHRyaWJ1dGUoJ25hbWUnKTtcclxuICAgICAgICAgICAgICAgIGlmIChlbC52YWx1ZSA9PT0gJycpIHtcclxuICAgICAgICAgICAgICAgICAgICBhdXRoLnNldEVycm9yTWVzc2FnZShlbCwgJ0NhbXBvIG9icmlnYXTDs3JpbycpO1xyXG4gICAgICAgICAgICAgICAgICAgIGlzVmFsaWQgPSBmYWxzZTtcclxuICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgICAgIGVsc2UgaWYgKG5hbWUgPT0gJ2VtYWlsJyAmJiAhdmFsaWRhdGVFbWFpbChlbC52YWx1ZSkpIHtcclxuICAgICAgICAgICAgICAgICAgICB2YWxpZGF0ZUVtYWlsLnNldEVycm9yTWVzc2FnZShlbCwgJ1BvciBmYXZvciwgaW5zaXJhIHVtIGVuZGVyZcOnbyBkZSBlbWFpbCB2w6FsaWRvLicpO1xyXG4gICAgICAgICAgICAgICAgICAgIGlzVmFsaWQgPSBmYWxzZTtcclxuICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgfSk7XHJcblxyXG4gICAgICAgICAgICAvLyBTZSBhcyB2YWxpZGHDp8O1ZXMgcGFzc2FyZW0sIGVudmlhciBvcyBkYWRvcyB2aWEgQUpBWFxyXG4gICAgICAgICAgICBpZiAoaXNWYWxpZCkge1xyXG4gICAgICAgICAgICAgICAgbGV0IGZvcm1EYXRhID0gbmV3IEZvcm1EYXRhKCk7XHJcbiAgICAgICAgICAgICAgICBmb3JtRGF0YS5hcHBlbmQoJ2VtYWlsJywgZW1haWwudmFsdWUpO1xyXG4gICAgICAgICAgICAgICAgZm9ybURhdGEuYXBwZW5kKCdwYXNzd29yZCcsIHBhc3N3b3JkLnZhbHVlKTtcclxuICAgICAgICAgICAgICAgIGZvcm1EYXRhLmFwcGVuZCgnX3Rva2VuJywgZG9jdW1lbnQucXVlcnlTZWxlY3RvcignW25hbWU9X3Rva2VuXScpLnZhbHVlKTtcclxuICAgICAgICAgICAgICAgIGxldCBzdGF0dXNUZXh0ID0gJ3N1Y2Nlc3MnO1xyXG4gICAgICAgICAgICAgICAgbGV0IG1lc3NhZ2UgPSBudWxsO1xyXG5cclxuICAgICAgICAgICAgICAgIGZldGNoKCcvbG9naW4nLCB7XHJcbiAgICAgICAgICAgICAgICAgICAgbWV0aG9kOiAnUE9TVCcsXHJcbiAgICAgICAgICAgICAgICAgICAgYm9keTogZm9ybURhdGEsXHJcbiAgICAgICAgICAgICAgICAgICAgaGVhZGVyczoge1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAnQWNjZXB0JzogJ2FwcGxpY2F0aW9uL2pzb24nXHJcbiAgICAgICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICAgICAgfSlcclxuICAgICAgICAgICAgICAgICAgICAudGhlbihyZXNwb25zZSA9PiB7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIGlmICghcmVzcG9uc2Uub2spIHtcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIHN3aXRjaCAocmVzcG9uc2Uuc3RhdHVzKSB7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgY2FzZSA0MDE6XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIHN0YXR1c1RleHQgPSAnZGFuZ2VyJztcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgYnJlYWs7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgY2FzZSA0MTk6XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIG1lc3NhZ2UgPSAnTyB0ZW1wbyBkbyBmb3JtdWzDoXJpbyB2ZW5jZXUhIFJlY2FycmVndWUgYSBww6FnaW5hIGUgdGVudGUgZGUgbm92by4nLCAnZGFuZ2VyJztcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgc3RhdHVzVGV4dCA9ICd3YXJuaW5nJztcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgYnJlYWtcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBjYXNlIDUwMDpcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgbWVzc2FnZSA9ICdFcnJvIGludGVybm8gZG8gc2Vydmlkb3IhIEluZm9ybWUgbyBhZG1pbmlzdHJhZG9yLicsICdkYW5nZXInO1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBzdGF0dXNUZXh0ID0gJ2Rhbmdlcic7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIGJyZWFrO1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIGRlZmF1bHQ6XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIG1lc3NhZ2UgPSAnRXJybyBkZXNjb25oZWNpZG8nO1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBzdGF0dXNUZXh0ID0gJ2Rhbmdlcic7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgICAgICAgICAgICAgcmV0dXJuIHJlc3BvbnNlLmpzb24oKTtcclxuICAgICAgICAgICAgICAgICAgICB9KVxyXG4gICAgICAgICAgICAgICAgICAgIC50aGVuKGRhdGEgPT4ge1xyXG4gICAgICAgICAgICAgICAgICAgICAgICBpZiAoc3RhdHVzVGV4dCA9PSAnc3VjY2VzcycpIHtcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIHdpbmRvdy5sb2NhdGlvbi5ocmVmID0gJy9hbmFseXNpcyc7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICByZXR1cm47XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIH1cclxuXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIGF1dGguc2V0QWxlcnQobWVzc2FnZSA/PyBkYXRhLm1lc3NhZ2UsIHN0YXR1c1RleHQpO1xyXG4gICAgICAgICAgICAgICAgICAgIH0pXHJcbiAgICAgICAgICAgICAgICAgICAgLmNhdGNoKGVycm9yID0+IHtcclxuICAgICAgICAgICAgICAgICAgICAgICAgYXV0aC5zZXRBbGVydCgnRXJybyBkZXNjb25oZWNpZG8nLCAnZGFuZ2VyJyk7XHJcbiAgICAgICAgICAgICAgICAgICAgfSk7XHJcbiAgICAgICAgICAgIH1cclxuICAgICAgICB9KTtcclxuICAgIH1cclxuICAgIC8qKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqXHJcbiAgICAgKiBTY3JpcHRzIHBhcmEgcmVnaXN0cm9cclxuICAgICAqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKiovXHJcbiAgICAvKipcclxuICAgICAqIEV4ZWN1dGEgbyByZWdpc3RybyBkbyB1c3VhcmlvXHJcbiAgICAgKi9cclxuICAgIGNvbnN0IHJlZ2lzdGVyRm9ybSA9IGRvY3VtZW50LnF1ZXJ5U2VsZWN0b3IoJyNyZWdpc3Rlci1mb3JtJyk7XHJcbiAgICBpZiAocmVnaXN0ZXJGb3JtICE9PSBudWxsKSB7XHJcbiAgICAgICAgcmVnaXN0ZXJGb3JtLmFkZEV2ZW50TGlzdGVuZXIoJ3N1Ym1pdCcsIGZ1bmN0aW9uIChlKSB7XHJcbiAgICAgICAgICAgIGUucHJldmVudERlZmF1bHQoKTtcclxuICAgICAgICAgICAgY29uc3QgaW5wdXRzID0gZG9jdW1lbnQucXVlcnlTZWxlY3RvckFsbCgnW3R5cGU9dGV4dF0sW3R5cGU9cGFzc3dvcmRdJyk7XHJcbiAgICAgICAgICAgIGNvbnN0IGlzSW52YWxpZCA9IGRvY3VtZW50LnF1ZXJ5U2VsZWN0b3JBbGwoJy5pbnZhbGlkLWZlZWRiYWNrJyk7XHJcblxyXG4gICAgICAgICAgICBpc0ludmFsaWQuZm9yRWFjaChlbCA9PiBlbC5yZW1vdmUoKSk7XHJcbiAgICAgICAgICAgIGNvbnN0IGFsZXJUZXJtb3MgPSBkb2N1bWVudC5xdWVyeVNlbGVjdG9yKCcuYWxlcnQnKTtcclxuICAgICAgICAgICAgaWYgKGFsZXJUZXJtb3MgIT0gbnVsbCkge1xyXG4gICAgICAgICAgICAgICAgYWxlclRlcm1vcy5yZW1vdmUoKTtcclxuICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICBjb25zdCBpbnZhbGlkID0gZG9jdW1lbnQucXVlcnlTZWxlY3RvckFsbCgnLmlzLWludmFsaWQnKTtcclxuICAgICAgICAgICAgaW52YWxpZC5mb3JFYWNoKGVsID0+IGVsLmNsYXNzTGlzdC5yZW1vdmUoJ2lzLWludmFsaWQnKSk7XHJcblxyXG4gICAgICAgICAgICBpZiAocmVnaXN0ZXIudmFsaWRhckZvcm0oaW5wdXRzKSkge1xyXG4gICAgICAgICAgICAgICAgY29uc3QgZm9ybURhdGEgPSBuZXcgRm9ybURhdGEoKTtcclxuICAgICAgICAgICAgICAgIGZvcm1EYXRhLmFwcGVuZCgnbmFtZScsIGRvY3VtZW50LnF1ZXJ5U2VsZWN0b3IoJ1tuYW1lPW5hbWVdJykudmFsdWUpO1xyXG4gICAgICAgICAgICAgICAgZm9ybURhdGEuYXBwZW5kKCdlbWFpbCcsIGRvY3VtZW50LnF1ZXJ5U2VsZWN0b3IoJ1tuYW1lPWVtYWlsXScpLnZhbHVlKTtcclxuICAgICAgICAgICAgICAgIGZvcm1EYXRhLmFwcGVuZCgnY29tcGFueScsIGRvY3VtZW50LnF1ZXJ5U2VsZWN0b3IoJ1tuYW1lPWNvbXBhbnldJykudmFsdWUpO1xyXG4gICAgICAgICAgICAgICAgZm9ybURhdGEuYXBwZW5kKCdwYXNzd29yZCcsIGRvY3VtZW50LnF1ZXJ5U2VsZWN0b3IoJ1tuYW1lPXBhc3N3b3JkXScpLnZhbHVlKTtcclxuICAgICAgICAgICAgICAgIGZvcm1EYXRhLmFwcGVuZCgncGFzc3dvcmRfY29uZmlybWF0aW9uJywgZG9jdW1lbnQucXVlcnlTZWxlY3RvcignW25hbWU9cGFzc3dvcmRfY29uZmlybWF0aW9uXScpLnZhbHVlKTtcclxuICAgICAgICAgICAgICAgIGZvcm1EYXRhLmFwcGVuZCgnX3Rva2VuJywgZG9jdW1lbnQucXVlcnlTZWxlY3RvcignW25hbWU9X3Rva2VuXScpLnZhbHVlKTtcclxuXHJcbiAgICAgICAgICAgICAgICByZWdpc3Rlci5lbnZpYXJEYWRvcyhmb3JtRGF0YSk7XHJcbiAgICAgICAgICAgIH1cclxuICAgICAgICB9KTtcclxuICAgIH0gICAgXHJcbiAgICAvKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKlxyXG4gICAgICogU2NyaXB0cyBwYXJhIHJlY3VwZXJhY2FvIGRlIHNlbmhhXHJcbiAgICAgKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqL1xyXG4gICAgY29uc3QgcmVzZXRGb3JtID0gZG9jdW1lbnQucXVlcnlTZWxlY3RvcignI3Jlc2V0LWZvcm0nKTtcclxuICAgIGlmIChyZXNldEZvcm0gIT09IG51bGwpIHtcclxuICAgICAgICByZXNldEZvcm0uYWRkRXZlbnRMaXN0ZW5lcignc3VibWl0JywgZnVuY3Rpb24gKGUpIHtcclxuICAgICAgICAgICAgZS5wcmV2ZW50RGVmYXVsdCgpO1xyXG4gICAgICAgICAgICBjb25zdCBpbnZhbGlkRmVlZGJhY2sgPSBkb2N1bWVudC5xdWVyeVNlbGVjdG9yQWxsKCcuaW52YWxpZC1mZWVkYmFjaycpO1xyXG4gICAgICAgICAgICBpbnZhbGlkRmVlZGJhY2suZm9yRWFjaChlbCA9PiBlbC5yZW1vdmUoKSk7XHJcbiAgICAgICAgICAgIGNvbnN0IGVtYWlsID0gZG9jdW1lbnQucXVlcnlTZWxlY3RvcignW25hbWU9ZW1haWxdJyk7XHJcbiAgICAgICAgICAgIGVtYWlsLmNsYXNzTGlzdC5yZW1vdmUoKTtcclxuICAgICAgICAgICAgY29uc3QgcGFyZW50ID0gZW1haWwucGFyZW50RWxlbWVudDtcclxuICAgICAgICAgICAgaWYgKCF2YWxpZGF0ZUVtYWlsKGVtYWlsLnZhbHVlKSkge1xyXG4gICAgICAgICAgICAgICAgYXV0aC5zZXRFcnJvck1lc3NhZ2UoZW1haWwsICdJbmZvcm1lIHVtIGVuZGVyZcOnbyBkZSBlbWFpbCB2w6FsaWRvLicpO1xyXG4gICAgICAgICAgICAgICAgcmV0dXJuO1xyXG4gICAgICAgICAgICB9XHJcbiAgICAgICAgICAgIGF1dGguc3dpdGNoTG9hZGVyKHRydWUpO1xyXG4gICAgICAgICAgICBjb25zdCBmb3JtRGF0YSA9IG5ldyBGb3JtRGF0YSgpO1xyXG4gICAgICAgICAgICBmb3JtRGF0YS5hcHBlbmQoJ2VtYWlsJywgZG9jdW1lbnQucXVlcnlTZWxlY3RvcignW25hbWU9ZW1haWxdJykudmFsdWUpO1xyXG4gICAgICAgICAgICBmb3JtRGF0YS5hcHBlbmQoJ190b2tlbicsIGRvY3VtZW50LnF1ZXJ5U2VsZWN0b3IoJ1tuYW1lPV90b2tlbl0nKS52YWx1ZSk7XHJcbiAgICAgICAgICAgIGxldCBzdGF0dXNUZXh0ID0gJ3N1Y2Nlc3MnO1xyXG4gICAgICAgICAgICBsZXQgbWVzc2FnZSA9IG51bGw7XHJcbiAgICAgICAgICAgIGZldGNoKCdwYXNzd29yZC1yZXNldCcsIHtcclxuICAgICAgICAgICAgICAgIG1ldGhvZDogJ1BPU1QnLFxyXG4gICAgICAgICAgICAgICAgYm9keTogZm9ybURhdGEsXHJcbiAgICAgICAgICAgICAgICBoZWFkZXJzOiB7XHJcbiAgICAgICAgICAgICAgICAgICAgJ0FjY2VwdCc6ICdhcHBsaWNhdGlvbi9qc29uJ1xyXG4gICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICB9KVxyXG4gICAgICAgICAgICAgICAgLnRoZW4ocmVzcG9uc2UgPT4ge1xyXG4gICAgICAgICAgICAgICAgICAgIGlmICghcmVzcG9uc2Uub2spIHtcclxuICAgICAgICAgICAgICAgICAgICAgICAgc3dpdGNoIChyZXNwb25zZS5zdGF0dXMpIHtcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIGNhc2UgNDAwOlxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIHN0YXR1c1RleHQgPSAnZGFuZ2VyJztcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBicmVhaztcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIGNhc2UgNDAxOlxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIHN0YXR1c1RleHQgPSAnZGFuZ2VyJztcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBicmVhaztcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIGNhc2UgNDE5OlxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIG1lc3NhZ2UgPSAnTyB0ZW1wbyBkbyBmb3JtdWzDoXJpbyBleHBpcm91ISBSZWNhcnJlZ3VlIGEgcMOhZ2luYSBlIHRlbnRlIGRlIG5vdm8uJywgJ2Rhbmdlcic7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgc3RhdHVzVGV4dCA9ICd3YXJuaW5nJztcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBicmVha1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgY2FzZSA1MDA6XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgbWVzc2FnZSA9ICdFcnJvIGludGVybm8gZG8gc2Vydmlkb3IhIEluZm9ybWUgbyBhZG1pbmlzdHJhZG9yLicsICdkYW5nZXInO1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIHN0YXR1c1RleHQgPSAnZGFuZ2VyJztcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBicmVhaztcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIGRlZmF1bHQ6XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgbWVzc2FnZSA9ICdFcnJvIGludGVybm8gZGVzY29uaGVjaWRvJztcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBzdGF0dXNUZXh0ID0gJ2Rhbmdlcic7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICAgICAgICAgcmV0dXJuIHJlc3BvbnNlLmpzb24oKTtcclxuICAgICAgICAgICAgICAgIH0pXHJcbiAgICAgICAgICAgICAgICAudGhlbihkYXRhID0+IHtcclxuICAgICAgICAgICAgICAgICAgICBhdXRoLnN3aXRjaExvYWRlcihmYWxzZSk7XHJcbiAgICAgICAgICAgICAgICAgICAgaWYgKHN0YXR1c1RleHQgPT0gJ3N1Y2Nlc3MnKSB7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIGNvbnN0IHJlc2V0TW9kYWwgPSBkb2N1bWVudC5xdWVyeVNlbGVjdG9yKCcjcmVzZXQtbW9kYWwnKTtcclxuICAgICAgICAgICAgICAgICAgICAgICAgY29uc3QgbW9kYWwgPSBuZXcgYm9vdHN0cmFwLk1vZGFsKHJlc2V0TW9kYWwsIHsgYmFja2Ryb3A6ICdzdGF0aWMnIH0pO1xyXG4gICAgICAgICAgICAgICAgICAgICAgICBtb2RhbC5zaG93KCk7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIHJlc2V0TW9kYWwuYWRkRXZlbnRMaXN0ZW5lcignaGlkZGVuLmJzLm1vZGFsJywgZnVuY3Rpb24gKGV2ZW50KSB7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICB3aW5kb3cubG9jYXRpb24uaHJlZiA9ICcvbG9naW4nO1xyXG4gICAgICAgICAgICAgICAgICAgICAgICB9KTtcclxuICAgICAgICAgICAgICAgICAgICAgICAgcmV0dXJuO1xyXG4gICAgICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgICAgICAgICBhdXRoLnNldEFsZXJ0KG1lc3NhZ2UgPz8gJ08gZW5kZXJlw6dvIGRlIGVtYWlsIGluZm9ybWFkbyBuw6NvIGVzdMOhIGNhZGFzdHJhZG8hJywgc3RhdHVzVGV4dCk7XHJcbiAgICAgICAgICAgICAgICB9KVxyXG4gICAgICAgICAgICAgICAgLmNhdGNoKGVycm9yID0+IHtcclxuICAgICAgICAgICAgICAgICAgICBhdXRoLnNldEFsZXJ0KCdFcnJvIGRlIHNvbGljaXRhw6fDo28gZGVzY29uaGVjaWRvJywgJ2RhbmdlcicpO1xyXG4gICAgICAgICAgICAgICAgfSk7XHJcbiAgICAgICAgfSk7XHJcbiAgICB9XHJcbn0pOyJdLCJuYW1lcyI6WyJzZXRFcnJvck1lc3NhZ2UiLCJlbCIsIm1lc3NhZ2UiLCJkaXYiLCJkb2N1bWVudCIsImNyZWF0ZUVsZW1lbnQiLCJjbGFzc0xpc3QiLCJhZGQiLCJ0ZXh0Q29udGVudCIsImluc2VydEFkamFjZW50RWxlbWVudCIsImljb25DbGFzcyIsInN1Y2Nlc3MiLCJ3YXJuaW5nIiwiZGFuZ2VyIiwic2V0QWxlcnQiLCJ0eXBlIiwiYXJndW1lbnRzIiwibGVuZ3RoIiwidW5kZWZpbmVkIiwiYWxlcnRzIiwicXVlcnlTZWxlY3RvckFsbCIsImZvckVhY2giLCJyZW1vdmUiLCJpY29uIiwiYWxlcnQiLCJjb25jYXQiLCJzZXRBdHRyaWJ1dGUiLCJhcHBlbmQiLCJjYXJkIiwicXVlcnlTZWxlY3RvciIsInN3aXRjaExvYWRlciIsInNob3ciLCJsb2FkZXIiLCJhdXRoIiwidmFsaWRhdGVFbWFpbCIsInBhc3N3b3JkUGF0dGVybiIsInZhbGlkYXJGb3JtIiwiZWxlbWVudHMiLCJpc1ZhbGlkIiwibmFtZSIsImdldEF0dHJpYnV0ZSIsInBhcmVudCIsInBhcmVudEVsZW1lbnQiLCJjb25maXJtIiwidmFsdWUiLCJuZXh0RWxlbWVudFNpYmxpbmciLCJ0ZXN0IiwidGVybW9zIiwiY2hlY2tlZCIsImVudmlhckRhZG9zIiwiZm9ybURhdGEiLCJzdGF0dXNUZXh0IiwiZmV0Y2giLCJtZXRob2QiLCJib2R5IiwiaGVhZGVycyIsInRoZW4iLCJyZXNwb25zZSIsIm9rIiwiX3NldGFyRXJybyIsInNldGFyRXJybyIsInN0YXR1cyIsIl9zZXRhckVycm8yIiwiX3NsaWNlZFRvQXJyYXkiLCJqc29uIiwiZGF0YSIsImV4aWJpck1vZGFsIiwiZXJyb3JzIiwiT2JqZWN0Iiwia2V5cyIsIm1hcCIsImtleSIsIm1zZyIsImVycm9yIiwiX3JlZiIsIl9yZWYyIiwicmVnaXN0ZXJNb2RhbCIsImdldEVsZW1lbnRCeUlkIiwibW9kYWwiLCJib290c3RyYXAiLCJNb2RhbCIsImJhY2tkcm9wIiwiYWRkRXZlbnRMaXN0ZW5lciIsImV2ZW50Iiwid2luZG93IiwibG9jYXRpb24iLCJocmVmIiwiZW1haWwiLCJlbWFpbFBhdHRlcm4iLCJjYXBpdGFsaXplIiwic3RyIiwiY2hhckF0Iiwic2xpY2UiLCJ0b0xvd2VyQ2FzZSIsImZvcm1hdERhdGUiLCJkYXRlU3RyaW5nIiwiZGF0ZSIsIkRhdGUiLCJyZXBsYWNlIiwiZm9ybWF0dGVyIiwiSW50bCIsIkRhdGVUaW1lRm9ybWF0IiwieWVhciIsIm1vbnRoIiwiZGF5IiwiaG91ciIsIm1pbnV0ZSIsImZvcm1hdCIsInRpbWVFbGFwc2VkIiwibm93IiwiZGlmZkluTXMiLCJzZWNvbmRzIiwibWludXRlcyIsImhvdXJzIiwiZGF5cyIsIndlZWtzIiwibW9udGhzIiwicnRmIiwiUmVsYXRpdmVUaW1lRm9ybWF0IiwibnVtZXJpYyIsIk1hdGgiLCJhYnMiLCJyb3VuZCIsImZpbGxUYWJsZVdpdGhQbGFjZWhvbGRlcnMiLCJ0YWJsZUlkIiwibnVtUm93cyIsIm51bUNvbHMiLCJ0YWJsZSIsImNvbnNvbGUiLCJsaW5lcyIsImkiLCJ0ciIsImoiLCJ0ZCIsInBsYWNlaG9sZGVyIiwiaW5uZXJIVE1MIiwicHVzaCIsImdldERhdGF0YWJsZU9iamVjdCIsImlkIiwic2ltcGxlRGF0YXRhYmxlcyIsIkRhdGFUYWJsZSIsImxhYmVscyIsInB0X0JSIiwicmVnaXN0ZXIiLCJsb2dpbkZvcm0iLCJlIiwicHJldmVudERlZmF1bHQiLCJwYXNzd29yZCIsImlucHV0cyIsImVycm9yQ29udGFpbmVyIiwiaXNJbnZhbGlkIiwiRm9ybURhdGEiLCJyZWdpc3RlckZvcm0iLCJhbGVyVGVybW9zIiwiaW52YWxpZCIsInJlc2V0Rm9ybSIsImludmFsaWRGZWVkYmFjayIsInJlc2V0TW9kYWwiXSwic291cmNlUm9vdCI6IiJ9