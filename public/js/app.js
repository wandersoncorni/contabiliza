/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./resources/css/app.css":
/*!*******************************!*\
  !*** ./resources/css/app.css ***!
  \*******************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./resources/js/private/analises.js":
/*!******************************************!*\
  !*** ./resources/js/private/analises.js ***!
  \******************************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   createAnalise: () => (/* binding */ createAnalise),
/* harmony export */   deleteAnalise: () => (/* binding */ deleteAnalise),
/* harmony export */   detalharAnalise: () => (/* binding */ detalharAnalise),
/* harmony export */   loadAnalisesData: () => (/* binding */ loadAnalisesData),
/* harmony export */   updateAnalise: () => (/* binding */ updateAnalise)
/* harmony export */ });
/* harmony import */ var _utils_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../utils.js */ "./resources/js/utils.js");
/**
 * Modulo de contrucao da tabela da pagina de analises
 */

/**
 * Retorna uma instancia da tabela htmls
 * @param {string} id 
 */
function getDatatableObject(id) {
  return new simpleDatatables.DataTable("#".concat(id), {
    labels: pt_BR
  });
}
/**
 * Retorna o conteudo da coluna analise
 * @param {object} data 
 */
function getLabel(data) {
  var _data$description, _data$user$company;
  var status = ['Falhou', 'Rodando', 'Pronto', 'Espera'];
  var content = document.createElement('div');
  var header = document.createElement('h4');
  if (data.status == 2) {
    var link = document.createElement('a');
    link.setAttribute('href', "/analysis/dashboard/id/".concat(data.id, " "));
    link.innerHTML = data.name;
    header.innerHTML = link.outerHTML;
  } else {
    header.classList.add('text-secondary');
    header.innerHTML = data.name;
  }
  var desc = document.createElement('p');
  desc.innerHTML = (_data$description = data.description) !== null && _data$description !== void 0 ? _data$description : '';
  var resumo = document.createElement('p');
  resumo.innerHTML = "<b>".concat(data.total_list, "</b> perquisadores ").concat(data.date_from, " at\xE9 ").concat(data.date_to, " ");
  var update = document.createElement('small');
  update.classList.add('float-end', 'text-primary');
  update.innerHTML = "\xDAltima atualiza\xE7\xE3o:  ".concat((0,_utils_js__WEBPACK_IMPORTED_MODULE_0__.timeElapsed)(data.updated), " atr\xE1s.");
  var company = document.createElement('small');
  company.innerHTML = "Criada por <a href=\"#\">".concat(data.user.name, "</a> ").concat((_data$user$company = data.user.company) !== null && _data$user$company !== void 0 ? _data$user$company : '', ", ").concat((0,_utils_js__WEBPACK_IMPORTED_MODULE_0__.timeElapsed)(data.created), " atr\xE1s.");
  content.append(update, header, desc, resumo, company);
  return content.outerHTML;
}
/**
 * Limpa da tabela
 * @param {*} dtb 
 */
function clearTable(dtb) {
  var numRows = dtb.data.data.length;
  var rowsToDelete = Array.from({
    length: numRows
  }, function (_, i) {
    return i;
  });
  dtb.rows.remove(rowsToDelete);
}
/**
 * Retorna o rotuelo do estado da analise
 * @param {*} status 
 * @returns 
 */
function getStatusLabel(status) {
  var statusColor = ['danger', 'warning', 'success', 'info'];
  var statusLabel = ['Falhou', 'Em processamento', 'Pronta', 'Aguardando'];
  var stLabel = document.createElement('span');
  stLabel.classList.add('badge', "bg-".concat(statusColor[status]), 'p-2');
  stLabel.innerHTML = statusLabel[status];
  return stLabel.outerHTML;
}
/**
 * Monta os botoes as acoes
 * @param {numeric} id O id do registro
 * @returns object html
 */
function getButtons(id) {
  var container = document.createElement('div');
  container.classList.add('btns-group');
  container.setAttribute('id', 'actions');
  var buttons = [{
    icon: "bi-download",
    "class": "btn-primary me-1 download",
    attr: {
      type: 'button',
      title: 'Baixar JSON'
    }
  }, {
    icon: "bi-r-circle",
    "class": "btn-secondary me-1 detalhar",
    attr: {
      type: 'button',
      title: 'Detalhes do processamento R'
    }
  }, {
    icon: "bi-pencil",
    "class": "btn-warning me-1 editar",
    attr: {
      type: 'button',
      title: 'Editar análise',
      'data-id': id
    }
  }, {
    icon: "bi-trash",
    "class": "btn-danger me-1 excluir",
    attr: {
      type: 'button',
      title: 'Excluir análise',
      'data-id': id
    }
  }];
  buttons.forEach(function (btn) {
    var button = document.createElement("button");
    Object.keys(btn.attr).map(function (name) {
      return button.setAttribute(name, btn.attr[name]);
    });
    button.className = "btn btn-sm ".concat(btn["class"]);
    button.innerHTML = "<i class=\"".concat(btn.icon, "\"></i>");
    container.appendChild(button);
  });
  return container.outerHTML;
}
/**
 * Seta as linhas da tabela
 * @param {object} data Os dados
 * @param {object} dtb1 A tabela permanente
 * @param {object} dtb2 A tabela temporaria
 */
function setDataTable(data, dtb1, dtb2) {
  var dadosPermanentes = [];
  var dadosTemporarios = [];
  data.map(function (dt) {
    if (dt.state) {
      dadosPermanentes.push({
        "Análises": getLabel(dt),
        "Situação": getStatusLabel(dt.status),
        "Ações": getButtons(dt.id)
      });
    } else {
      dadosTemporarios.push({
        "Análises": getLabel(dt),
        "Situação": getStatusLabel(dt.status),
        "Ações": getButtons()
      });
    }
  });
  clearTable(dtb1);
  dtb1.insert(dadosPermanentes);
  clearTable(dtb2);
  dtb2.insert(dadosTemporarios);
}
/**
 * Requisita os dados e insere nas tabelas
 * @param {object} dtb1 O objeto simpleDatatables
 * @param {object} dtb2 O objeto simpleDatatables
 */
function loadAnalisesData(dtb1, dtb2) {
  (0,_utils_js__WEBPACK_IMPORTED_MODULE_0__.fillTableWithPlaceholders)('tab-permanente', 9, 3);
  fetch('/analises', {
    method: 'get',
    headers: {
      'Accept': 'application/json'
    }
  }).then(function (response) {
    return response.json();
  }).then(function (data) {
    if (data.length) {
      setDataTable(data, dtb1, dtb2);
      return;
    }
    clearTable(dtb1);
    clearTable(dtb2);
  })["catch"](function (error) {});
}
function createAnalise() {}
/**
 * Atualiza uma analise
 */
function updateAnalise() {}
/**
 * Exlui a analise
 * @param {numeric} id O id da analise
 * @return boolean
 */
function deleteAnalise(id) {
  console.log(id);
}
function detalharAnalise() {}

/***/ }),

/***/ "./resources/js/private/app.js":
/*!*************************************!*\
  !*** ./resources/js/private/app.js ***!
  \*************************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _utils_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../utils.js */ "./resources/js/utils.js");
/* harmony import */ var _analises_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./analises.js */ "./resources/js/private/analises.js");
/* harmony import */ var _config_user_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./config-user.js */ "./resources/js/private/config-user.js");
/* harmony import */ var _log_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./log.js */ "./resources/js/private/log.js");
/* harmony import */ var _config_app_js__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./config-app.js */ "./resources/js/private/config-app.js");





/**
 * Excuta a aplicacao
 */
document.addEventListener("DOMContentLoaded", function () {
  // Inicia carregando os dados da primeira pagina que eh analises
  var tbPermanente = (0,_utils_js__WEBPACK_IMPORTED_MODULE_0__.getDatatableObject)('tab-permanente');
  var tbTemporaria = (0,_utils_js__WEBPACK_IMPORTED_MODULE_0__.getDatatableObject)('tab-temporaria');
  (0,_analises_js__WEBPACK_IMPORTED_MODULE_1__.loadAnalisesData)(tbPermanente, tbTemporaria);
  // Adiciona eventos aos itens do menu lateral
  document.querySelector('#analises-item').addEventListener('click', function () {
    if (tbPermanente != null && tbPermanente.initialized) {
      tbPermanente.destroy();
      tbTemporaria.destroy();
    }
    tbPermanente = (0,_utils_js__WEBPACK_IMPORTED_MODULE_0__.getDatatableObject)('tab-permanente');
    tbTemporaria = (0,_utils_js__WEBPACK_IMPORTED_MODULE_0__.getDatatableObject)('tab-temporaria');
    (0,_analises_js__WEBPACK_IMPORTED_MODULE_1__.loadAnalisesData)(tbPermanente, tbTemporaria);
  });
  document.querySelector('#config-item').addEventListener('click', function () {
    (0,_config_app_js__WEBPACK_IMPORTED_MODULE_4__.setConfigFormValues)();
  });

  /****************************************************************
   * Scripts da pagina analises
   ***************************************************************/
  document.querySelectorAll('#tab-permanente, #tab-temporaria').forEach(function (tab) {
    tab.addEventListener("click", function (e) {
      var target = e.target.closest("#actions button");
      if (target) {
        var classes = target.getAttribute('class').split(" ");
        if (classes.includes('download')) {
          console.log('download');
          return;
        }
        if (classes.includes('detalhar')) {
          console.log('detalhar');
          return;
        }
        if (classes.includes('editar')) {
          editAnalise(target.getAttribute('data-id'));
          return;
        }
        if (classes.includes('excluir')) {
          (0,_analises_js__WEBPACK_IMPORTED_MODULE_1__.deleteAnalise)(target.getAttribute('data-id'));
          return;
        }
      }
    });
  });

  /****************************************************************
   * Scripts da pagina configuracoes
   ***************************************************************/
  /**
   * Secao aplicacao
   */
  document.querySelectorAll('#aplicacao form input', '#aplicacao form select').forEach(function (el) {
    el.addEventListener('change', function () {
      var data = {};
      var elName = this.attributes.name.value;
      data[elName] = this.attributes.type.value == 'checkbox' ? this.checked : this.value;
      console.log(data);
      fetch('/configuracao', {
        method: 'PATCH',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
      }).then(function (response) {
        return response.json();
      }).then(function (data) {
        console.log(data);
      });
    });
  });
  /**
   * Secao usuario
   */
  var uid = document.querySelector('#exclusaoModal .modal-body #uid');
  var userTable = null;
  document.querySelector('#usuarios-tab').addEventListener('click', function (e) {
    if (userTable != null && userTable.initialized) {
      userTable.destroy();
    }
    userTable = (0,_utils_js__WEBPACK_IMPORTED_MODULE_0__.getDatatableObject)('users-table');
    (0,_config_user_js__WEBPACK_IMPORTED_MODULE_2__.loadUserData)(userTable);
  });
  document.querySelector('#users-table').addEventListener('click', function (e) {
    var target = e.target.closest(".delete");
    if (target) {
      uid.setAttribute('value', target.parentElement.getAttribute('aria-uid'));
    }
  });
  document.querySelector('#exclusaoModal').addEventListener('hidden.bs.modal', function (event) {
    excluirUsuario(uid.getAttribute('value'));
    uid.setAttribute('value', '');
  });
  // document.querySelector('.block').addEventListener('click', function(e){

  // });
  document.querySelector('#btn-delete').addEventListener('click', function (e) {});
  // Carrega a tabela ao clicar na aba de logs
  var logsTable = null;
  document.querySelector('#config-logs-tab').addEventListener('click', function (e) {
    // if (logsTable !== null && logsTable.initialized) {
    //     logsTable.destroy();
    // }
    // logsTable = getDatatableObject('logs-table');
    (0,_log_js__WEBPACK_IMPORTED_MODULE_3__.loadLogData)(logsTable);
  });
});

/***/ }),

/***/ "./resources/js/private/config-app.js":
/*!********************************************!*\
  !*** ./resources/js/private/config-app.js ***!
  \********************************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   setConfigFormValues: () => (/* binding */ setConfigFormValues)
/* harmony export */ });
/**
 * Scripts para o tab "Aplicacao" do item de menu configuracoes
 */
function setConfigFormValues() {
  fetch('/configuracao').then(function (response) {
    return response.json();
  }).then(function (data) {
    Object.keys(data).map(function (name) {
      var form = document.querySelector('#aplicacao form');
      var field = form.querySelector("#".concat(name));
      if (field !== null) {
        var type = field.getAttribute('type');
        if (type == 'checkbox') {
          field.checked = data[name];
        } else if (name == 'service_collector') {
          field.value = data[name];
        }
      }
    });
  });
}

/***/ }),

/***/ "./resources/js/private/config-user.js":
/*!*********************************************!*\
  !*** ./resources/js/private/config-user.js ***!
  \*********************************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   excluirUsuario: () => (/* binding */ excluirUsuario),
/* harmony export */   loadUserData: () => (/* binding */ loadUserData)
/* harmony export */ });
/* harmony import */ var _utils_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../utils.js */ "./resources/js/utils.js");
/**
 * Scripts para o item configuracoes
 */

/**
 * Carrega os dados
 * @param {object} userTable
 */
function loadUserData(userTable) {
  (0,_utils_js__WEBPACK_IMPORTED_MODULE_0__.fillTableWithPlaceholders)('users-table', 10, 2);
  fetch("/usuarios?fields=".concat(encodeURIComponent('id,name,email,active,profile_id,photo')), {
    method: 'get',
    headers: {
      'Accept': 'application/json'
    }
  }).then(function (response) {
    return response.json();
  }).then(function (data) {
    var numRows = userTable.data.data.length;
    var rowsToDelete = Array.from({
      length: numRows
    }, function (_, i) {
      return i;
    });
    userTable.rows.remove(rowsToDelete);
    if (data.length) {
      var dt = setDataTable(data);
      userTable.insert(dt);
    }
  })["catch"](function (error) {});
}
/**
 * Formata a coluna dos dados do usuario
 * @param {object} data Os dados da requisicao
 * @return ObjectHTML
 */
function getUserData(data) {
  var _data$photo;
  var container = document.createElement('div');
  var header = document.createElement('h5');
  header.innerHTML = data.name;
  var avatar = document.createElement('img');
  avatar.setAttribute('src', '/usuario/avatar/' + ((_data$photo = data.photo) !== null && _data$photo !== void 0 ? _data$photo : 'default.png'));
  avatar.classList.add('avatar');
  var info = document.createElement('p');
  info.innerHTML = data.email;
  container.append(avatar, header, info);
  return container.outerHTML;
}
/**
 * Monta os botoes as acoes
 * @returns object html
 */
function getButtons(data) {
  var container = document.createElement('div');
  container.classList.add('btns-group');
  container.setAttribute('id', 'actions');
  container.setAttribute('aria-uid', data.id);
  var buttons = [{
    icon: "bi-person-lock",
    "class": "btn-warning me-1 block",
    attr: {
      type: 'button',
      title: 'Bloquear'
    }
  }, {
    icon: "bi-person-dash",
    "class": "btn-danger me-1 delete",
    attr: {
      type: 'button',
      title: 'Excluir',
      'data-bs-toggle': 'modal',
      'data-bs-target': '#exclusaoModal'
    }
  }];
  buttons.forEach(function (btn) {
    var button = document.createElement("button");
    Object.keys(btn.attr).map(function (name) {
      return button.setAttribute(name, btn.attr[name]);
    });
    button.className = "btn ".concat(btn["class"]);
    button.innerHTML = "<i class=\"".concat(btn.icon, "\"></i>");
    container.appendChild(button);
  });
  return container.outerHTML;
}
/**
 * Configura o conteudo da tabela
 * @param {object} data 
 * @returns 
 */
function setDataTable(data) {
  var lns = [];
  data.map(function (data) {
    lns.push({
      'Usuários': getUserData(data),
      'Ações': getButtons(data)
    });
  });
  return lns;
}
;
function excluirUsuario(uid) {
  fetch('/usuario/123', {
    method: 'DELETE',
    headers: {
      'Content-Type': 'application/json'
      //'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
    },
    body: JSON.stringify({
      confirmacao: true
    })
  }).then(function (response) {
    return response.json();
  }).then(function (data) {
    return console.log(data);
  });
}

/***/ }),

/***/ "./resources/js/private/log.js":
/*!*************************************!*\
  !*** ./resources/js/private/log.js ***!
  \*************************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   loadLogData: () => (/* binding */ loadLogData)
/* harmony export */ });
/* harmony import */ var _utils_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../utils.js */ "./resources/js/utils.js");
/**
 * Scripts para configuracao/logs
 */

/**
 * Carrega os dados da tabela
 */
function loadLogData(table) {
  (0,_utils_js__WEBPACK_IMPORTED_MODULE_0__.fillTableWithPlaceholders)('logs-table', 10, 3);
  fetch("/logs?fields=".concat(encodeURIComponent('user.name,action,orign,datetime')), {
    method: 'get',
    headers: {
      'Accept': 'application/json'
    }
  }).then(function (response) {
    return response.json();
  }).then(function (data) {
    var numRows = userTable.data.data.length;
    var rowsToDelete = Array.from({
      length: numRows
    }, function (_, i) {
      return i;
    });
    userTable.rows.remove(rowsToDelete);
    if (data.length) {
      var dt = setDataTable(data);
      userTable.insert(dt);
    }
  })["catch"](function (error) {});
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
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = __webpack_modules__;
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/chunk loaded */
/******/ 	(() => {
/******/ 		var deferred = [];
/******/ 		__webpack_require__.O = (result, chunkIds, fn, priority) => {
/******/ 			if(chunkIds) {
/******/ 				priority = priority || 0;
/******/ 				for(var i = deferred.length; i > 0 && deferred[i - 1][2] > priority; i--) deferred[i] = deferred[i - 1];
/******/ 				deferred[i] = [chunkIds, fn, priority];
/******/ 				return;
/******/ 			}
/******/ 			var notFulfilled = Infinity;
/******/ 			for (var i = 0; i < deferred.length; i++) {
/******/ 				var [chunkIds, fn, priority] = deferred[i];
/******/ 				var fulfilled = true;
/******/ 				for (var j = 0; j < chunkIds.length; j++) {
/******/ 					if ((priority & 1 === 0 || notFulfilled >= priority) && Object.keys(__webpack_require__.O).every((key) => (__webpack_require__.O[key](chunkIds[j])))) {
/******/ 						chunkIds.splice(j--, 1);
/******/ 					} else {
/******/ 						fulfilled = false;
/******/ 						if(priority < notFulfilled) notFulfilled = priority;
/******/ 					}
/******/ 				}
/******/ 				if(fulfilled) {
/******/ 					deferred.splice(i--, 1)
/******/ 					var r = fn();
/******/ 					if (r !== undefined) result = r;
/******/ 				}
/******/ 			}
/******/ 			return result;
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
/******/ 	/* webpack/runtime/jsonp chunk loading */
/******/ 	(() => {
/******/ 		// no baseURI
/******/ 		
/******/ 		// object to store loaded and loading chunks
/******/ 		// undefined = chunk not loaded, null = chunk preloaded/prefetched
/******/ 		// [resolve, reject, Promise] = chunk loading, 0 = chunk loaded
/******/ 		var installedChunks = {
/******/ 			"/js/app": 0,
/******/ 			"css/app": 0
/******/ 		};
/******/ 		
/******/ 		// no chunk on demand loading
/******/ 		
/******/ 		// no prefetching
/******/ 		
/******/ 		// no preloaded
/******/ 		
/******/ 		// no HMR
/******/ 		
/******/ 		// no HMR manifest
/******/ 		
/******/ 		__webpack_require__.O.j = (chunkId) => (installedChunks[chunkId] === 0);
/******/ 		
/******/ 		// install a JSONP callback for chunk loading
/******/ 		var webpackJsonpCallback = (parentChunkLoadingFunction, data) => {
/******/ 			var [chunkIds, moreModules, runtime] = data;
/******/ 			// add "moreModules" to the modules object,
/******/ 			// then flag all "chunkIds" as loaded and fire callback
/******/ 			var moduleId, chunkId, i = 0;
/******/ 			if(chunkIds.some((id) => (installedChunks[id] !== 0))) {
/******/ 				for(moduleId in moreModules) {
/******/ 					if(__webpack_require__.o(moreModules, moduleId)) {
/******/ 						__webpack_require__.m[moduleId] = moreModules[moduleId];
/******/ 					}
/******/ 				}
/******/ 				if(runtime) var result = runtime(__webpack_require__);
/******/ 			}
/******/ 			if(parentChunkLoadingFunction) parentChunkLoadingFunction(data);
/******/ 			for(;i < chunkIds.length; i++) {
/******/ 				chunkId = chunkIds[i];
/******/ 				if(__webpack_require__.o(installedChunks, chunkId) && installedChunks[chunkId]) {
/******/ 					installedChunks[chunkId][0]();
/******/ 				}
/******/ 				installedChunks[chunkId] = 0;
/******/ 			}
/******/ 			return __webpack_require__.O(result);
/******/ 		}
/******/ 		
/******/ 		var chunkLoadingGlobal = self["webpackChunk"] = self["webpackChunk"] || [];
/******/ 		chunkLoadingGlobal.forEach(webpackJsonpCallback.bind(null, 0));
/******/ 		chunkLoadingGlobal.push = webpackJsonpCallback.bind(null, chunkLoadingGlobal.push.bind(chunkLoadingGlobal));
/******/ 	})();
/******/ 	
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module depends on other loaded chunks and execution need to be delayed
/******/ 	__webpack_require__.O(undefined, ["css/app"], () => (__webpack_require__("./resources/js/private/app.js")))
/******/ 	var __webpack_exports__ = __webpack_require__.O(undefined, ["css/app"], () => (__webpack_require__("./resources/css/app.css")))
/******/ 	__webpack_exports__ = __webpack_require__.O(__webpack_exports__);
/******/ 	
/******/ })()
;
//# sourceMappingURL=data:application/json;charset=utf-8;base64,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QTtXQUNBO1dBQ0E7V0FDQTtXQUNBO1dBQ0E7Ozs7O1dDM0JBO1dBQ0E7V0FDQTtXQUNBO1dBQ0EseUNBQXlDLHdDQUF3QztXQUNqRjtXQUNBO1dBQ0E7Ozs7O1dDUEE7Ozs7O1dDQUE7V0FDQTtXQUNBO1dBQ0EsdURBQXVELGlCQUFpQjtXQUN4RTtXQUNBLGdEQUFnRCxhQUFhO1dBQzdEOzs7OztXQ05BOztXQUVBO1dBQ0E7V0FDQTtXQUNBO1dBQ0E7V0FDQTtXQUNBOztXQUVBOztXQUVBOztXQUVBOztXQUVBOztXQUVBOztXQUVBOztXQUVBO1dBQ0E7V0FDQTtXQUNBO1dBQ0E7V0FDQTtXQUNBO1dBQ0E7V0FDQTtXQUNBO1dBQ0E7V0FDQTtXQUNBO1dBQ0E7V0FDQTtXQUNBLE1BQU0scUJBQXFCO1dBQzNCO1dBQ0E7V0FDQTtXQUNBO1dBQ0E7V0FDQTtXQUNBO1dBQ0E7O1dBRUE7V0FDQTtXQUNBOzs7OztVRWpEQTtVQUNBO1VBQ0E7VUFDQTtVQUNBO1VBQ0EiLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9yZXNvdXJjZXMvY3NzL2FwcC5jc3MiLCJ3ZWJwYWNrOi8vLy4vcmVzb3VyY2VzL2pzL3ByaXZhdGUvYW5hbGlzZXMuanMiLCJ3ZWJwYWNrOi8vLy4vcmVzb3VyY2VzL2pzL3ByaXZhdGUvYXBwLmpzIiwid2VicGFjazovLy8uL3Jlc291cmNlcy9qcy9wcml2YXRlL2NvbmZpZy1hcHAuanMiLCJ3ZWJwYWNrOi8vLy4vcmVzb3VyY2VzL2pzL3ByaXZhdGUvY29uZmlnLXVzZXIuanMiLCJ3ZWJwYWNrOi8vLy4vcmVzb3VyY2VzL2pzL3ByaXZhdGUvbG9nLmpzIiwid2VicGFjazovLy8uL3Jlc291cmNlcy9qcy91dGlscy5qcyIsIndlYnBhY2s6Ly8vd2VicGFjay9ib290c3RyYXAiLCJ3ZWJwYWNrOi8vL3dlYnBhY2svcnVudGltZS9jaHVuayBsb2FkZWQiLCJ3ZWJwYWNrOi8vL3dlYnBhY2svcnVudGltZS9kZWZpbmUgcHJvcGVydHkgZ2V0dGVycyIsIndlYnBhY2s6Ly8vd2VicGFjay9ydW50aW1lL2hhc093blByb3BlcnR5IHNob3J0aGFuZCIsIndlYnBhY2s6Ly8vd2VicGFjay9ydW50aW1lL21ha2UgbmFtZXNwYWNlIG9iamVjdCIsIndlYnBhY2s6Ly8vd2VicGFjay9ydW50aW1lL2pzb25wIGNodW5rIGxvYWRpbmciLCJ3ZWJwYWNrOi8vL3dlYnBhY2svYmVmb3JlLXN0YXJ0dXAiLCJ3ZWJwYWNrOi8vL3dlYnBhY2svc3RhcnR1cCIsIndlYnBhY2s6Ly8vd2VicGFjay9hZnRlci1zdGFydHVwIl0sInNvdXJjZXNDb250ZW50IjpbIi8vIGV4dHJhY3RlZCBieSBtaW5pLWNzcy1leHRyYWN0LXBsdWdpblxuZXhwb3J0IHt9OyIsIi8qKlxyXG4gKiBNb2R1bG8gZGUgY29udHJ1Y2FvIGRhIHRhYmVsYSBkYSBwYWdpbmEgZGUgYW5hbGlzZXNcclxuICovXHJcbmltcG9ydCB7dGltZUVsYXBzZWQsIGZpbGxUYWJsZVdpdGhQbGFjZWhvbGRlcnN9IGZyb20gJy4uL3V0aWxzLmpzJztcclxuLyoqXHJcbiAqIFJldG9ybmEgdW1hIGluc3RhbmNpYSBkYSB0YWJlbGEgaHRtbHNcclxuICogQHBhcmFtIHtzdHJpbmd9IGlkIFxyXG4gKi9cclxuZnVuY3Rpb24gZ2V0RGF0YXRhYmxlT2JqZWN0KGlkKXtcclxuICAgIHJldHVybiBuZXcgc2ltcGxlRGF0YXRhYmxlcy5EYXRhVGFibGUoYCMke2lkfWAsIHtcclxuICAgICAgICBsYWJlbHM6IHB0X0JSXHJcbiAgICB9KTtcclxufVxyXG4vKipcclxuICogUmV0b3JuYSBvIGNvbnRldWRvIGRhIGNvbHVuYSBhbmFsaXNlXHJcbiAqIEBwYXJhbSB7b2JqZWN0fSBkYXRhIFxyXG4gKi9cclxuZnVuY3Rpb24gZ2V0TGFiZWwoZGF0YSl7XHJcbiAgICBjb25zdCBzdGF0dXMgPSBbJ0ZhbGhvdScsJ1JvZGFuZG8nLCdQcm9udG8nLCdFc3BlcmEnXTtcclxuICAgIGNvbnN0IGNvbnRlbnQgPSBkb2N1bWVudC5jcmVhdGVFbGVtZW50KCdkaXYnKTtcclxuICAgIGNvbnN0IGhlYWRlciA9IGRvY3VtZW50LmNyZWF0ZUVsZW1lbnQoJ2g0Jyk7ICAgICAgICBcclxuICAgIFxyXG4gICAgaWYoZGF0YS5zdGF0dXMgPT0gMil7XHJcbiAgICAgICAgY29uc3QgbGluayA9IGRvY3VtZW50LmNyZWF0ZUVsZW1lbnQoJ2EnKTtcclxuICAgICAgICBsaW5rLnNldEF0dHJpYnV0ZSgnaHJlZicsYC9hbmFseXNpcy9kYXNoYm9hcmQvaWQvJHtkYXRhLmlkfSBgKTtcclxuICAgICAgICBsaW5rLmlubmVySFRNTCA9IGRhdGEubmFtZTtcclxuICAgICAgICBoZWFkZXIuaW5uZXJIVE1MID0gbGluay5vdXRlckhUTUw7XHJcbiAgICB9XHJcbiAgICBlbHNle1xyXG4gICAgICAgIGhlYWRlci5jbGFzc0xpc3QuYWRkKCd0ZXh0LXNlY29uZGFyeScpO1xyXG4gICAgICAgIGhlYWRlci5pbm5lckhUTUwgPSAgZGF0YS5uYW1lO1xyXG4gICAgfVxyXG4gICAgXHJcbiAgICBjb25zdCBkZXNjID0gZG9jdW1lbnQuY3JlYXRlRWxlbWVudCgncCcpO1xyXG4gICAgZGVzYy5pbm5lckhUTUwgPSBkYXRhLmRlc2NyaXB0aW9uID8/ICcnO1xyXG4gICAgXHJcbiAgICBjb25zdCByZXN1bW8gPSBkb2N1bWVudC5jcmVhdGVFbGVtZW50KCdwJyk7XHJcbiAgICByZXN1bW8uaW5uZXJIVE1MID0gYDxiPiR7ZGF0YS50b3RhbF9saXN0fTwvYj4gcGVycXVpc2Fkb3JlcyAke2RhdGEuZGF0ZV9mcm9tfSBhdMOpICR7ZGF0YS5kYXRlX3RvfSBgO1xyXG4gICAgY29uc3QgdXBkYXRlID0gZG9jdW1lbnQuY3JlYXRlRWxlbWVudCgnc21hbGwnKTtcclxuICAgIHVwZGF0ZS5jbGFzc0xpc3QuYWRkKCdmbG9hdC1lbmQnLCd0ZXh0LXByaW1hcnknKTtcclxuICAgIHVwZGF0ZS5pbm5lckhUTUwgPSBgw5psdGltYSBhdHVhbGl6YcOnw6NvOiAgJHt0aW1lRWxhcHNlZChkYXRhLnVwZGF0ZWQpfSBhdHLDoXMuYDtcclxuXHJcbiAgICBjb25zdCBjb21wYW55ID0gZG9jdW1lbnQuY3JlYXRlRWxlbWVudCgnc21hbGwnKTtcclxuICAgIGNvbXBhbnkuaW5uZXJIVE1MID0gYENyaWFkYSBwb3IgPGEgaHJlZj1cIiNcIj4ke2RhdGEudXNlci5uYW1lfTwvYT4gJHtkYXRhLnVzZXIuY29tcGFueT8/Jyd9LCAke3RpbWVFbGFwc2VkKGRhdGEuY3JlYXRlZCl9IGF0csOhcy5gOyBcclxuXHJcbiAgICBjb250ZW50LmFwcGVuZCh1cGRhdGUsIGhlYWRlciwgZGVzYywgcmVzdW1vLGNvbXBhbnkpO1xyXG4gICAgcmV0dXJuIGNvbnRlbnQub3V0ZXJIVE1MO1xyXG59XHJcbi8qKlxyXG4gKiBMaW1wYSBkYSB0YWJlbGFcclxuICogQHBhcmFtIHsqfSBkdGIgXHJcbiAqL1xyXG5mdW5jdGlvbiBjbGVhclRhYmxlKGR0Yil7XHJcbiAgICBjb25zdCBudW1Sb3dzID0gZHRiLmRhdGEuZGF0YS5sZW5ndGg7XHJcbiAgICBjb25zdCByb3dzVG9EZWxldGUgPSBBcnJheS5mcm9tKHsgbGVuZ3RoOiBudW1Sb3dzIH0sIChfLCBpKSAgPT4gaSk7XHJcbiAgICBkdGIucm93cy5yZW1vdmUocm93c1RvRGVsZXRlKTsgXHJcbn1cclxuLyoqXHJcbiAqIFJldG9ybmEgbyByb3R1ZWxvIGRvIGVzdGFkbyBkYSBhbmFsaXNlXHJcbiAqIEBwYXJhbSB7Kn0gc3RhdHVzIFxyXG4gKiBAcmV0dXJucyBcclxuICovXHJcbmZ1bmN0aW9uIGdldFN0YXR1c0xhYmVsKHN0YXR1cyl7XHJcbiAgICBjb25zdCBzdGF0dXNDb2xvciA9IFsnZGFuZ2VyJywgJ3dhcm5pbmcnLCAnc3VjY2VzcycsICdpbmZvJ107XHJcbiAgICBjb25zdCBzdGF0dXNMYWJlbCA9IFsnRmFsaG91JywgJ0VtIHByb2Nlc3NhbWVudG8nLCAnUHJvbnRhJywgJ0FndWFyZGFuZG8nXTtcclxuICAgIGNvbnN0IHN0TGFiZWwgPSBkb2N1bWVudC5jcmVhdGVFbGVtZW50KCdzcGFuJyk7XHJcbiAgICBcclxuICAgIHN0TGFiZWwuY2xhc3NMaXN0LmFkZCgnYmFkZ2UnLCBgYmctJHtzdGF0dXNDb2xvcltzdGF0dXNdfWAsICdwLTInKTtcclxuICAgIHN0TGFiZWwuaW5uZXJIVE1MID0gc3RhdHVzTGFiZWxbc3RhdHVzXTtcclxuICAgIHJldHVybiBzdExhYmVsLm91dGVySFRNTDtcclxufVxyXG4vKipcclxuICogTW9udGEgb3MgYm90b2VzIGFzIGFjb2VzXHJcbiAqIEBwYXJhbSB7bnVtZXJpY30gaWQgTyBpZCBkbyByZWdpc3Ryb1xyXG4gKiBAcmV0dXJucyBvYmplY3QgaHRtbFxyXG4gKi9cclxuZnVuY3Rpb24gZ2V0QnV0dG9ucyhpZCl7XHJcbiAgICBjb25zdCBjb250YWluZXIgPSBkb2N1bWVudC5jcmVhdGVFbGVtZW50KCdkaXYnKTtcclxuICAgIGNvbnRhaW5lci5jbGFzc0xpc3QuYWRkKCdidG5zLWdyb3VwJyk7XHJcbiAgICBjb250YWluZXIuc2V0QXR0cmlidXRlKCdpZCcsJ2FjdGlvbnMnKTtcclxuXHJcbiAgICBjb25zdCBidXR0b25zID0gW1xyXG4gICAgICAgIHsgaWNvbjogXCJiaS1kb3dubG9hZFwiLCBjbGFzczogXCJidG4tcHJpbWFyeSBtZS0xIGRvd25sb2FkXCIsIGF0dHI6e3R5cGU6ICdidXR0b24nLCB0aXRsZTogJ0JhaXhhciBKU09OJ319LFxyXG4gICAgICAgIHsgaWNvbjogXCJiaS1yLWNpcmNsZVwiLCBjbGFzczogXCJidG4tc2Vjb25kYXJ5IG1lLTEgZGV0YWxoYXJcIiwgYXR0cjp7dHlwZTogJ2J1dHRvbicsIHRpdGxlOiAnRGV0YWxoZXMgZG8gcHJvY2Vzc2FtZW50byBSJ319LFxyXG4gICAgICAgIHsgaWNvbjogXCJiaS1wZW5jaWxcIiwgY2xhc3M6IFwiYnRuLXdhcm5pbmcgbWUtMSBlZGl0YXJcIiwgYXR0cjp7dHlwZTogJ2J1dHRvbicsIHRpdGxlOiAnRWRpdGFyIGFuw6FsaXNlJywgJ2RhdGEtaWQnOiBpZH19LFxyXG4gICAgICAgIHsgaWNvbjogXCJiaS10cmFzaFwiLCBjbGFzczogXCJidG4tZGFuZ2VyIG1lLTEgZXhjbHVpclwiLCBhdHRyOnt0eXBlOiAnYnV0dG9uJywgdGl0bGU6ICdFeGNsdWlyIGFuw6FsaXNlJywgJ2RhdGEtaWQnOiBpZH19XHJcbiAgICBdO1xyXG4gICAgXHJcbiAgICBidXR0b25zLmZvckVhY2goYnRuID0+IHtcclxuICAgICAgICBjb25zdCBidXR0b24gPSBkb2N1bWVudC5jcmVhdGVFbGVtZW50KFwiYnV0dG9uXCIpO1xyXG4gICAgICAgIE9iamVjdC5rZXlzKGJ0bi5hdHRyKS5tYXAoIG5hbWUgPT4gYnV0dG9uLnNldEF0dHJpYnV0ZShuYW1lLGJ0bi5hdHRyW25hbWVdKSk7XHJcbiAgICAgICAgYnV0dG9uLmNsYXNzTmFtZSA9IGBidG4gYnRuLXNtICR7YnRuLmNsYXNzfWA7XHJcbiAgICAgICAgYnV0dG9uLmlubmVySFRNTCA9IGA8aSBjbGFzcz1cIiR7YnRuLmljb259XCI+PC9pPmA7XHJcbiAgICAgICAgY29udGFpbmVyLmFwcGVuZENoaWxkKGJ1dHRvbik7XHJcbiAgICB9KTtcclxuXHJcbiAgICByZXR1cm4gY29udGFpbmVyLm91dGVySFRNTDtcclxufVxyXG4vKipcclxuICogU2V0YSBhcyBsaW5oYXMgZGEgdGFiZWxhXHJcbiAqIEBwYXJhbSB7b2JqZWN0fSBkYXRhIE9zIGRhZG9zXHJcbiAqIEBwYXJhbSB7b2JqZWN0fSBkdGIxIEEgdGFiZWxhIHBlcm1hbmVudGVcclxuICogQHBhcmFtIHtvYmplY3R9IGR0YjIgQSB0YWJlbGEgdGVtcG9yYXJpYVxyXG4gKi9cclxuZnVuY3Rpb24gc2V0RGF0YVRhYmxlKGRhdGEsIGR0YjEsIGR0YjIpe1xyXG4gICAgY29uc3QgZGFkb3NQZXJtYW5lbnRlcyA9IFtdO1xyXG4gICAgY29uc3QgZGFkb3NUZW1wb3JhcmlvcyA9IFtdO1xyXG4gICAgZGF0YS5tYXAoKGR0KT0+e1xyXG4gICAgICAgIGlmKGR0LnN0YXRlKXtcclxuICAgICAgICAgICAgZGFkb3NQZXJtYW5lbnRlcy5wdXNoKHtcclxuICAgICAgICAgICAgICAgIFwiQW7DoWxpc2VzXCI6IGdldExhYmVsKGR0KSxcclxuICAgICAgICAgICAgICAgIFwiU2l0dWHDp8Ojb1wiOiBnZXRTdGF0dXNMYWJlbChkdC5zdGF0dXMpLFxyXG4gICAgICAgICAgICAgICAgXCJBw6fDtWVzXCI6IGdldEJ1dHRvbnMoZHQuaWQpXHJcbiAgICAgICAgICAgIH0pO1xyXG4gICAgICAgIH1cclxuICAgICAgICBlbHNle1xyXG4gICAgICAgICAgICBkYWRvc1RlbXBvcmFyaW9zLnB1c2goe1xyXG4gICAgICAgICAgICAgICAgXCJBbsOhbGlzZXNcIjogZ2V0TGFiZWwoZHQpLFxyXG4gICAgICAgICAgICAgICAgXCJTaXR1YcOnw6NvXCI6IGdldFN0YXR1c0xhYmVsKGR0LnN0YXR1cyksXHJcbiAgICAgICAgICAgICAgICBcIkHDp8O1ZXNcIjogZ2V0QnV0dG9ucygpXHJcbiAgICAgICAgICAgIH0pO1xyXG4gICAgICAgIH1cclxuICAgIH0pO1xyXG4gICAgY2xlYXJUYWJsZShkdGIxKTtcclxuICAgIGR0YjEuaW5zZXJ0KGRhZG9zUGVybWFuZW50ZXMpO1xyXG4gICAgY2xlYXJUYWJsZShkdGIyICk7XHJcbiAgICBkdGIyLmluc2VydChkYWRvc1RlbXBvcmFyaW9zKTtcclxufVxyXG4vKipcclxuICogUmVxdWlzaXRhIG9zIGRhZG9zIGUgaW5zZXJlIG5hcyB0YWJlbGFzXHJcbiAqIEBwYXJhbSB7b2JqZWN0fSBkdGIxIE8gb2JqZXRvIHNpbXBsZURhdGF0YWJsZXNcclxuICogQHBhcmFtIHtvYmplY3R9IGR0YjIgTyBvYmpldG8gc2ltcGxlRGF0YXRhYmxlc1xyXG4gKi9cclxuZXhwb3J0IGZ1bmN0aW9uIGxvYWRBbmFsaXNlc0RhdGEoZHRiMSwgZHRiMil7XHJcbiAgICBmaWxsVGFibGVXaXRoUGxhY2Vob2xkZXJzKCd0YWItcGVybWFuZW50ZScsOSwzKTtcclxuICAgIGZldGNoKCcvYW5hbGlzZXMnLCB7XHJcbiAgICAgICAgbWV0aG9kOiAnZ2V0JyxcclxuICAgICAgICBoZWFkZXJzOiB7XHJcbiAgICAgICAgICAgICdBY2NlcHQnOiAnYXBwbGljYXRpb24vanNvbidcclxuICAgICAgICB9XHJcbiAgICB9KS50aGVuKHJlc3BvbnNlID0+IHtcclxuICAgICAgICByZXR1cm4gcmVzcG9uc2UuanNvbigpO1xyXG4gICAgfSkudGhlbihkYXRhID0+IHtcclxuICAgICAgICBpZihkYXRhLmxlbmd0aCl7ICAgICAgICAgICAgICAgIFxyXG4gICAgICAgICAgICBzZXREYXRhVGFibGUoZGF0YSwgZHRiMSwgZHRiMik7XHJcbiAgICAgICAgICAgIHJldHVybjtcclxuICAgICAgICB9XHJcbiAgICAgICAgY2xlYXJUYWJsZShkdGIxKTtcclxuICAgICAgICBjbGVhclRhYmxlKGR0YjIpO1xyXG4gICAgfSlcclxuICAgIC5jYXRjaChlcnJvciA9PiB7XHJcbiAgICAgICAgXHJcbiAgICB9KTtcclxufVxyXG5cclxuZXhwb3J0IGZ1bmN0aW9uIGNyZWF0ZUFuYWxpc2UoKXtcclxuXHJcbn1cclxuLyoqXHJcbiAqIEF0dWFsaXphIHVtYSBhbmFsaXNlXHJcbiAqL1xyXG5leHBvcnQgZnVuY3Rpb24gdXBkYXRlQW5hbGlzZSgpe1xyXG4gICAgXHJcbn1cclxuLyoqXHJcbiAqIEV4bHVpIGEgYW5hbGlzZVxyXG4gKiBAcGFyYW0ge251bWVyaWN9IGlkIE8gaWQgZGEgYW5hbGlzZVxyXG4gKiBAcmV0dXJuIGJvb2xlYW5cclxuICovXHJcbmV4cG9ydCBmdW5jdGlvbiBkZWxldGVBbmFsaXNlKGlkKXtcclxuICAgIGNvbnNvbGUubG9nKGlkKVxyXG59XHJcblxyXG5leHBvcnQgZnVuY3Rpb24gZGV0YWxoYXJBbmFsaXNlKCl7XHJcbiAgICBcclxufVxyXG5cclxuIiwiaW1wb3J0IHsgZ2V0RGF0YXRhYmxlT2JqZWN0IH0gZnJvbSAnLi4vdXRpbHMuanMnO1xyXG5pbXBvcnQgeyBkZWxldGVBbmFsaXNlLCBsb2FkQW5hbGlzZXNEYXRhIH0gZnJvbSAnLi9hbmFsaXNlcy5qcyc7XHJcbmltcG9ydCB7IGxvYWRVc2VyRGF0YSB9IGZyb20gJy4vY29uZmlnLXVzZXIuanMnO1xyXG5pbXBvcnQgeyBsb2FkTG9nRGF0YSB9IGZyb20gJy4vbG9nLmpzJztcclxuaW1wb3J0IHsgc2V0Q29uZmlnRm9ybVZhbHVlcyB9IGZyb20gJy4vY29uZmlnLWFwcC5qcyc7XHJcbi8qKlxyXG4gKiBFeGN1dGEgYSBhcGxpY2FjYW9cclxuICovXHJcbmRvY3VtZW50LmFkZEV2ZW50TGlzdGVuZXIoXCJET01Db250ZW50TG9hZGVkXCIsIGZ1bmN0aW9uICgpIHtcclxuICAgIC8vIEluaWNpYSBjYXJyZWdhbmRvIG9zIGRhZG9zIGRhIHByaW1laXJhIHBhZ2luYSBxdWUgZWggYW5hbGlzZXNcclxuICAgIGxldCB0YlBlcm1hbmVudGUgPSBnZXREYXRhdGFibGVPYmplY3QoJ3RhYi1wZXJtYW5lbnRlJyk7XHJcbiAgICBsZXQgdGJUZW1wb3JhcmlhID0gZ2V0RGF0YXRhYmxlT2JqZWN0KCd0YWItdGVtcG9yYXJpYScpO1xyXG4gICAgbG9hZEFuYWxpc2VzRGF0YSh0YlBlcm1hbmVudGUsIHRiVGVtcG9yYXJpYSk7XHJcbiAgICAvLyBBZGljaW9uYSBldmVudG9zIGFvcyBpdGVucyBkbyBtZW51IGxhdGVyYWxcclxuICAgIGRvY3VtZW50LnF1ZXJ5U2VsZWN0b3IoJyNhbmFsaXNlcy1pdGVtJykuYWRkRXZlbnRMaXN0ZW5lcignY2xpY2snLCBmdW5jdGlvbiAoKSB7XHJcbiAgICAgICAgaWYgKHRiUGVybWFuZW50ZSAhPSBudWxsICYmIHRiUGVybWFuZW50ZS5pbml0aWFsaXplZCkge1xyXG4gICAgICAgICAgICB0YlBlcm1hbmVudGUuZGVzdHJveSgpO1xyXG4gICAgICAgICAgICB0YlRlbXBvcmFyaWEuZGVzdHJveSgpO1xyXG4gICAgICAgIH1cclxuICAgICAgICB0YlBlcm1hbmVudGUgPSBnZXREYXRhdGFibGVPYmplY3QoJ3RhYi1wZXJtYW5lbnRlJyk7XHJcbiAgICAgICAgdGJUZW1wb3JhcmlhID0gZ2V0RGF0YXRhYmxlT2JqZWN0KCd0YWItdGVtcG9yYXJpYScpO1xyXG4gICAgICAgIGxvYWRBbmFsaXNlc0RhdGEodGJQZXJtYW5lbnRlLCB0YlRlbXBvcmFyaWEpO1xyXG4gICAgfSk7XHJcbiAgICBkb2N1bWVudC5xdWVyeVNlbGVjdG9yKCcjY29uZmlnLWl0ZW0nKS5hZGRFdmVudExpc3RlbmVyKCdjbGljaycsIGZ1bmN0aW9uICgpIHsgICAgICAgIFxyXG4gICAgICAgIHNldENvbmZpZ0Zvcm1WYWx1ZXMoKTtcclxuICAgIH0pO1xyXG5cclxuICAgIC8qKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqXHJcbiAgICAgKiBTY3JpcHRzIGRhIHBhZ2luYSBhbmFsaXNlc1xyXG4gICAgICoqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKi9cclxuICAgIGRvY3VtZW50LnF1ZXJ5U2VsZWN0b3JBbGwoJyN0YWItcGVybWFuZW50ZSwgI3RhYi10ZW1wb3JhcmlhJykuZm9yRWFjaCh0YWIgPT4ge1xyXG4gICAgICAgIHRhYi5hZGRFdmVudExpc3RlbmVyKFwiY2xpY2tcIiwgZnVuY3Rpb24gKGUpIHtcclxuICAgICAgICAgICAgY29uc3QgdGFyZ2V0ID0gZS50YXJnZXQuY2xvc2VzdChcIiNhY3Rpb25zIGJ1dHRvblwiKTtcclxuICAgICAgICAgICAgaWYgKHRhcmdldCkge1xyXG4gICAgICAgICAgICAgICAgY29uc3QgY2xhc3NlcyA9ICh0YXJnZXQuZ2V0QXR0cmlidXRlKCdjbGFzcycpKS5zcGxpdChcIiBcIik7XHJcbiAgICAgICAgICAgICAgICBpZiAoY2xhc3Nlcy5pbmNsdWRlcygnZG93bmxvYWQnKSkge1xyXG4gICAgICAgICAgICAgICAgICAgIGNvbnNvbGUubG9nKCdkb3dubG9hZCcpXHJcbiAgICAgICAgICAgICAgICAgICAgcmV0dXJuO1xyXG4gICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICAgICAgaWYgKGNsYXNzZXMuaW5jbHVkZXMoJ2RldGFsaGFyJykpIHtcclxuICAgICAgICAgICAgICAgICAgICBjb25zb2xlLmxvZygnZGV0YWxoYXInKVxyXG4gICAgICAgICAgICAgICAgICAgIHJldHVybjtcclxuICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgICAgIGlmIChjbGFzc2VzLmluY2x1ZGVzKCdlZGl0YXInKSkge1xyXG4gICAgICAgICAgICAgICAgICAgIGVkaXRBbmFsaXNlKHRhcmdldC5nZXRBdHRyaWJ1dGUoJ2RhdGEtaWQnKSk7XHJcbiAgICAgICAgICAgICAgICAgICAgcmV0dXJuO1xyXG4gICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICAgICAgaWYgKGNsYXNzZXMuaW5jbHVkZXMoJ2V4Y2x1aXInKSkge1xyXG4gICAgICAgICAgICAgICAgICAgIGRlbGV0ZUFuYWxpc2UodGFyZ2V0LmdldEF0dHJpYnV0ZSgnZGF0YS1pZCcpKTtcclxuICAgICAgICAgICAgICAgICAgICByZXR1cm47XHJcbiAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgIH1cclxuICAgICAgICB9KTtcclxuICAgIH0pO1xyXG5cclxuICAgIC8qKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqXHJcbiAgICAgKiBTY3JpcHRzIGRhIHBhZ2luYSBjb25maWd1cmFjb2VzXHJcbiAgICAgKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqL1xyXG4gICAgLyoqXHJcbiAgICAgKiBTZWNhbyBhcGxpY2FjYW9cclxuICAgICAqL1xyXG4gICAgZG9jdW1lbnQucXVlcnlTZWxlY3RvckFsbCgnI2FwbGljYWNhbyBmb3JtIGlucHV0JywnI2FwbGljYWNhbyBmb3JtIHNlbGVjdCcpLmZvckVhY2goZWwgPT4ge1xyXG4gICAgICAgIGVsLmFkZEV2ZW50TGlzdGVuZXIoJ2NoYW5nZScsIGZ1bmN0aW9uKCkge1xyXG4gICAgICAgICAgICBjb25zdCBkYXRhID0ge307XHJcbiAgICAgICAgICAgIGNvbnN0IGVsTmFtZSA9IHRoaXMuYXR0cmlidXRlcy5uYW1lLnZhbHVlO1xyXG4gICAgICAgICAgICBkYXRhW2VsTmFtZV0gPSB0aGlzLmF0dHJpYnV0ZXMudHlwZS52YWx1ZSA9PSAnY2hlY2tib3gnID8gdGhpcy5jaGVja2VkIDogdGhpcy52YWx1ZTtcclxuICAgICAgICAgICAgXHJcbiAgICAgICAgICAgIGNvbnNvbGUubG9nKGRhdGEpXHJcbiAgICAgICAgICAgIGZldGNoKCcvY29uZmlndXJhY2FvJyx7XHJcbiAgICAgICAgICAgICAgICBtZXRob2Q6ICdQQVRDSCcsXHJcbiAgICAgICAgICAgICAgICBoZWFkZXJzOiB7XHJcbiAgICAgICAgICAgICAgICAgICAgJ0NvbnRlbnQtVHlwZSc6ICdhcHBsaWNhdGlvbi9qc29uJ1xyXG4gICAgICAgICAgICAgICAgfSxcclxuICAgICAgICAgICAgICAgIGJvZHk6IEpTT04uc3RyaW5naWZ5KGRhdGEpXHJcbiAgICAgICAgICAgIH0pLnRoZW4ocmVzcG9uc2UgPT4gcmVzcG9uc2UuanNvbigpKVxyXG4gICAgICAgICAgICAudGhlbihkYXRhID0+IHtcclxuICAgICAgICAgICAgICAgIGNvbnNvbGUubG9nKGRhdGEpXHJcbiAgICAgICAgICAgIH0pO1xyXG4gICAgICAgIH0pO1xyXG4gICAgfSk7XHJcbiAgICAvKipcclxuICAgICAqIFNlY2FvIHVzdWFyaW9cclxuICAgICAqL1xyXG4gICAgY29uc3QgdWlkID0gZG9jdW1lbnQucXVlcnlTZWxlY3RvcignI2V4Y2x1c2FvTW9kYWwgLm1vZGFsLWJvZHkgI3VpZCcpO1xyXG4gICAgbGV0IHVzZXJUYWJsZSA9IG51bGw7XHJcbiAgICBkb2N1bWVudC5xdWVyeVNlbGVjdG9yKCcjdXN1YXJpb3MtdGFiJykuYWRkRXZlbnRMaXN0ZW5lcignY2xpY2snLCBmdW5jdGlvbiAoZSkge1xyXG4gICAgICAgIGlmICh1c2VyVGFibGUgIT0gbnVsbCAmJiB1c2VyVGFibGUuaW5pdGlhbGl6ZWQpIHtcclxuICAgICAgICAgICAgdXNlclRhYmxlLmRlc3Ryb3koKTtcclxuICAgICAgICB9XHJcbiAgICAgICAgdXNlclRhYmxlID0gZ2V0RGF0YXRhYmxlT2JqZWN0KCd1c2Vycy10YWJsZScpO1xyXG4gICAgICAgIGxvYWRVc2VyRGF0YSh1c2VyVGFibGUpO1xyXG4gICAgfSk7XHJcbiAgICBkb2N1bWVudC5xdWVyeVNlbGVjdG9yKCcjdXNlcnMtdGFibGUnKS5hZGRFdmVudExpc3RlbmVyKCdjbGljaycsIGZ1bmN0aW9uIChlKSB7XHJcbiAgICAgICAgY29uc3QgdGFyZ2V0ID0gZS50YXJnZXQuY2xvc2VzdChcIi5kZWxldGVcIik7XHJcbiAgICAgICAgaWYgKHRhcmdldCkge1xyXG4gICAgICAgICAgICB1aWQuc2V0QXR0cmlidXRlKCd2YWx1ZScsIHRhcmdldC5wYXJlbnRFbGVtZW50LmdldEF0dHJpYnV0ZSgnYXJpYS11aWQnKSk7XHJcbiAgICAgICAgfVxyXG4gICAgfSk7XHJcbiAgICBkb2N1bWVudC5xdWVyeVNlbGVjdG9yKCcjZXhjbHVzYW9Nb2RhbCcpLmFkZEV2ZW50TGlzdGVuZXIoJ2hpZGRlbi5icy5tb2RhbCcsIGZ1bmN0aW9uIChldmVudCkge1xyXG4gICAgICAgIGV4Y2x1aXJVc3VhcmlvKHVpZC5nZXRBdHRyaWJ1dGUoJ3ZhbHVlJykpO1xyXG4gICAgICAgIHVpZC5zZXRBdHRyaWJ1dGUoJ3ZhbHVlJywgJycpO1xyXG4gICAgfSk7XHJcbiAgICAvLyBkb2N1bWVudC5xdWVyeVNlbGVjdG9yKCcuYmxvY2snKS5hZGRFdmVudExpc3RlbmVyKCdjbGljaycsIGZ1bmN0aW9uKGUpe1xyXG5cclxuICAgIC8vIH0pO1xyXG4gICAgZG9jdW1lbnQucXVlcnlTZWxlY3RvcignI2J0bi1kZWxldGUnKS5hZGRFdmVudExpc3RlbmVyKCdjbGljaycsIGZ1bmN0aW9uIChlKSB7XHJcblxyXG4gICAgfSk7XHJcbiAgICAvLyBDYXJyZWdhIGEgdGFiZWxhIGFvIGNsaWNhciBuYSBhYmEgZGUgbG9nc1xyXG4gICAgbGV0IGxvZ3NUYWJsZSA9IG51bGw7XHJcbiAgICBkb2N1bWVudC5xdWVyeVNlbGVjdG9yKCcjY29uZmlnLWxvZ3MtdGFiJykuYWRkRXZlbnRMaXN0ZW5lcignY2xpY2snLCBmdW5jdGlvbiAoZSkge1xyXG4gICAgICAgIC8vIGlmIChsb2dzVGFibGUgIT09IG51bGwgJiYgbG9nc1RhYmxlLmluaXRpYWxpemVkKSB7XHJcbiAgICAgICAgLy8gICAgIGxvZ3NUYWJsZS5kZXN0cm95KCk7XHJcbiAgICAgICAgLy8gfVxyXG4gICAgICAgIC8vIGxvZ3NUYWJsZSA9IGdldERhdGF0YWJsZU9iamVjdCgnbG9ncy10YWJsZScpO1xyXG4gICAgICAgIGxvYWRMb2dEYXRhKGxvZ3NUYWJsZSk7XHJcbiAgICB9KTtcclxufSk7IiwiLyoqXHJcbiAqIFNjcmlwdHMgcGFyYSBvIHRhYiBcIkFwbGljYWNhb1wiIGRvIGl0ZW0gZGUgbWVudSBjb25maWd1cmFjb2VzXHJcbiAqL1xyXG5leHBvcnQgZnVuY3Rpb24gc2V0Q29uZmlnRm9ybVZhbHVlcygpIHtcclxuICAgIGZldGNoKCcvY29uZmlndXJhY2FvJylcclxuICAgICAgICAudGhlbihyZXNwb25zZSA9PiByZXNwb25zZS5qc29uKCkpXHJcbiAgICAgICAgLnRoZW4oZGF0YSA9PiB7XHJcbiAgICAgICAgICAgIE9iamVjdC5rZXlzKGRhdGEpLm1hcChuYW1lID0+e1xyXG4gICAgICAgICAgICAgICAgY29uc3QgZm9ybSA9IGRvY3VtZW50LnF1ZXJ5U2VsZWN0b3IoJyNhcGxpY2FjYW8gZm9ybScpO1xyXG4gICAgICAgICAgICAgICAgY29uc3QgZmllbGQgPSBmb3JtLnF1ZXJ5U2VsZWN0b3IoYCMke25hbWV9YCk7XHJcblxyXG4gICAgICAgICAgICAgICAgaWYoZmllbGQgIT09IG51bGwpe1xyXG4gICAgICAgICAgICAgICAgICAgIGNvbnN0IHR5cGUgPSBmaWVsZC5nZXRBdHRyaWJ1dGUoJ3R5cGUnKTtcclxuICAgICAgICAgICAgICAgICAgICBpZih0eXBlID09ICdjaGVja2JveCcpe1xyXG4gICAgICAgICAgICAgICAgICAgICAgICBmaWVsZC5jaGVja2VkID0gZGF0YVtuYW1lXTtcclxuICAgICAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICAgICAgICAgZWxzZSBpZihuYW1lID09ICdzZXJ2aWNlX2NvbGxlY3Rvcicpe1xyXG4gICAgICAgICAgICAgICAgICAgICAgICBmaWVsZC52YWx1ZSA9IGRhdGFbbmFtZV07XHJcbiAgICAgICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICAgICAgXHJcbiAgICAgICAgICAgIH0pO1xyXG4gICAgICAgIH0pO1xyXG59IiwiLyoqXHJcbiAqIFNjcmlwdHMgcGFyYSBvIGl0ZW0gY29uZmlndXJhY29lc1xyXG4gKi9cclxuaW1wb3J0IHtmaWxsVGFibGVXaXRoUGxhY2Vob2xkZXJzfSBmcm9tICcuLi91dGlscy5qcydcclxuLyoqXHJcbiAqIENhcnJlZ2Egb3MgZGFkb3NcclxuICogQHBhcmFtIHtvYmplY3R9IHVzZXJUYWJsZVxyXG4gKi9cclxuZXhwb3J0IGZ1bmN0aW9uIGxvYWRVc2VyRGF0YSh1c2VyVGFibGUpIHtcclxuICAgIGZpbGxUYWJsZVdpdGhQbGFjZWhvbGRlcnMoJ3VzZXJzLXRhYmxlJywxMCwyKTtcclxuICAgIGZldGNoKGAvdXN1YXJpb3M/ZmllbGRzPSR7ZW5jb2RlVVJJQ29tcG9uZW50KCdpZCxuYW1lLGVtYWlsLGFjdGl2ZSxwcm9maWxlX2lkLHBob3RvJyl9YCwge1xyXG4gICAgICAgIG1ldGhvZDogJ2dldCcsXHJcbiAgICAgICAgaGVhZGVyczoge1xyXG4gICAgICAgICAgICAnQWNjZXB0JzogJ2FwcGxpY2F0aW9uL2pzb24nXHJcbiAgICAgICAgfVxyXG4gICAgfSkudGhlbihyZXNwb25zZSA9PiB7XHJcbiAgICAgICAgcmV0dXJuIHJlc3BvbnNlLmpzb24oKTtcclxuICAgIH0pLnRoZW4oZGF0YSA9PiB7XHJcbiAgICAgICAgY29uc3QgbnVtUm93cyA9IHVzZXJUYWJsZS5kYXRhLmRhdGEubGVuZ3RoO1xyXG4gICAgICAgIGNvbnN0IHJvd3NUb0RlbGV0ZSA9IEFycmF5LmZyb20oeyBsZW5ndGg6IG51bVJvd3MgfSwgKF8sIGkpID0+IGkpO1xyXG4gICAgICAgIHVzZXJUYWJsZS5yb3dzLnJlbW92ZShyb3dzVG9EZWxldGUpO1xyXG4gICAgICAgIGlmIChkYXRhLmxlbmd0aCkge1xyXG4gICAgICAgICAgICBjb25zdCBkdCA9IHNldERhdGFUYWJsZShkYXRhKTtcclxuICAgICAgICAgICAgdXNlclRhYmxlLmluc2VydChkdCk7XHJcbiAgICAgICAgfVxyXG4gICAgfSlcclxuICAgICAgICAuY2F0Y2goZXJyb3IgPT4geyB9KTtcclxufVxyXG4vKipcclxuICogRm9ybWF0YSBhIGNvbHVuYSBkb3MgZGFkb3MgZG8gdXN1YXJpb1xyXG4gKiBAcGFyYW0ge29iamVjdH0gZGF0YSBPcyBkYWRvcyBkYSByZXF1aXNpY2FvXHJcbiAqIEByZXR1cm4gT2JqZWN0SFRNTFxyXG4gKi9cclxuZnVuY3Rpb24gZ2V0VXNlckRhdGEoZGF0YSkge1xyXG4gICAgY29uc3QgY29udGFpbmVyID0gZG9jdW1lbnQuY3JlYXRlRWxlbWVudCgnZGl2Jyk7XHJcbiAgICBjb25zdCBoZWFkZXIgPSBkb2N1bWVudC5jcmVhdGVFbGVtZW50KCdoNScpO1xyXG4gICAgaGVhZGVyLmlubmVySFRNTCA9IGRhdGEubmFtZTtcclxuICAgIGNvbnN0IGF2YXRhciA9IGRvY3VtZW50LmNyZWF0ZUVsZW1lbnQoJ2ltZycpO1xyXG4gICAgYXZhdGFyLnNldEF0dHJpYnV0ZSgnc3JjJywgJy91c3VhcmlvL2F2YXRhci8nICsgKGRhdGEucGhvdG8gPz8gJ2RlZmF1bHQucG5nJykpO1xyXG4gICAgYXZhdGFyLmNsYXNzTGlzdC5hZGQoJ2F2YXRhcicpO1xyXG4gICAgY29uc3QgaW5mbyA9IGRvY3VtZW50LmNyZWF0ZUVsZW1lbnQoJ3AnKTtcclxuICAgIGluZm8uaW5uZXJIVE1MID0gZGF0YS5lbWFpbDtcclxuICAgIGNvbnRhaW5lci5hcHBlbmQoYXZhdGFyLCBoZWFkZXIsIGluZm8pO1xyXG4gICAgcmV0dXJuIGNvbnRhaW5lci5vdXRlckhUTUw7XHJcbn1cclxuLyoqXHJcbiAqIE1vbnRhIG9zIGJvdG9lcyBhcyBhY29lc1xyXG4gKiBAcmV0dXJucyBvYmplY3QgaHRtbFxyXG4gKi9cclxuZnVuY3Rpb24gZ2V0QnV0dG9ucyhkYXRhKSB7XHJcbiAgICBjb25zdCBjb250YWluZXIgPSBkb2N1bWVudC5jcmVhdGVFbGVtZW50KCdkaXYnKTtcclxuICAgIGNvbnRhaW5lci5jbGFzc0xpc3QuYWRkKCdidG5zLWdyb3VwJyk7XHJcbiAgICBjb250YWluZXIuc2V0QXR0cmlidXRlKCdpZCcsICdhY3Rpb25zJyk7XHJcbiAgICBjb250YWluZXIuc2V0QXR0cmlidXRlKCdhcmlhLXVpZCcsIGRhdGEuaWQpO1xyXG5cclxuICAgIGNvbnN0IGJ1dHRvbnMgPSBbXHJcbiAgICAgICAgeyBpY29uOiBcImJpLXBlcnNvbi1sb2NrXCIsIGNsYXNzOiBcImJ0bi13YXJuaW5nIG1lLTEgYmxvY2tcIiwgYXR0cjogeyB0eXBlOiAnYnV0dG9uJywgdGl0bGU6ICdCbG9xdWVhcicgfSB9LFxyXG4gICAgICAgIHsgaWNvbjogXCJiaS1wZXJzb24tZGFzaFwiLCBjbGFzczogXCJidG4tZGFuZ2VyIG1lLTEgZGVsZXRlXCIsIGF0dHI6IHsgdHlwZTogJ2J1dHRvbicsIHRpdGxlOiAnRXhjbHVpcicsICdkYXRhLWJzLXRvZ2dsZSc6ICdtb2RhbCcsICdkYXRhLWJzLXRhcmdldCc6ICcjZXhjbHVzYW9Nb2RhbCcgfSB9LFxyXG4gICAgXTtcclxuXHJcbiAgICBidXR0b25zLmZvckVhY2goYnRuID0+IHtcclxuICAgICAgICBjb25zdCBidXR0b24gPSBkb2N1bWVudC5jcmVhdGVFbGVtZW50KFwiYnV0dG9uXCIpO1xyXG4gICAgICAgIE9iamVjdC5rZXlzKGJ0bi5hdHRyKS5tYXAobmFtZSA9PiBidXR0b24uc2V0QXR0cmlidXRlKG5hbWUsIGJ0bi5hdHRyW25hbWVdKSk7XHJcbiAgICAgICAgYnV0dG9uLmNsYXNzTmFtZSA9IGBidG4gJHtidG4uY2xhc3N9YDtcclxuICAgICAgICBidXR0b24uaW5uZXJIVE1MID0gYDxpIGNsYXNzPVwiJHtidG4uaWNvbn1cIj48L2k+YDtcclxuICAgICAgICBjb250YWluZXIuYXBwZW5kQ2hpbGQoYnV0dG9uKTtcclxuICAgIH0pO1xyXG5cclxuICAgIHJldHVybiBjb250YWluZXIub3V0ZXJIVE1MO1xyXG59XHJcbi8qKlxyXG4gKiBDb25maWd1cmEgbyBjb250ZXVkbyBkYSB0YWJlbGFcclxuICogQHBhcmFtIHtvYmplY3R9IGRhdGEgXHJcbiAqIEByZXR1cm5zIFxyXG4gKi9cclxuZnVuY3Rpb24gc2V0RGF0YVRhYmxlKGRhdGEpIHtcclxuICAgIGNvbnN0IGxucyA9IFtdO1xyXG4gICAgZGF0YS5tYXAoKGRhdGEpID0+IHtcclxuICAgICAgICBsbnMucHVzaCh7XHJcbiAgICAgICAgICAgICdVc3XDoXJpb3MnOiBnZXRVc2VyRGF0YShkYXRhKSxcclxuICAgICAgICAgICAgJ0HDp8O1ZXMnOiBnZXRCdXR0b25zKGRhdGEpXHJcbiAgICAgICAgfSk7XHJcbiAgICB9KTtcclxuICAgIHJldHVybiBsbnM7XHJcbn07XHJcblxyXG5leHBvcnQgZnVuY3Rpb24gZXhjbHVpclVzdWFyaW8odWlkKSB7XHJcbiAgICBmZXRjaCgnL3VzdWFyaW8vMTIzJywge1xyXG4gICAgICAgIG1ldGhvZDogJ0RFTEVURScsXHJcbiAgICAgICAgaGVhZGVyczoge1xyXG4gICAgICAgICAgICAnQ29udGVudC1UeXBlJzogJ2FwcGxpY2F0aW9uL2pzb24nLFxyXG4gICAgICAgICAgICAvLydYLUNTUkYtVE9LRU4nOiBkb2N1bWVudC5xdWVyeVNlbGVjdG9yKCdtZXRhW25hbWU9XCJjc3JmLXRva2VuXCJdJykuY29udGVudFxyXG4gICAgICAgIH0sXHJcbiAgICAgICAgYm9keTogSlNPTi5zdHJpbmdpZnkoeyBjb25maXJtYWNhbzogdHJ1ZSB9KVxyXG4gICAgfSlcclxuICAgICAgICAudGhlbihyZXNwb25zZSA9PiByZXNwb25zZS5qc29uKCkpXHJcbiAgICAgICAgLnRoZW4oZGF0YSA9PiBjb25zb2xlLmxvZyhkYXRhKSk7XHJcbn0iLCIvKipcclxuICogU2NyaXB0cyBwYXJhIGNvbmZpZ3VyYWNhby9sb2dzXHJcbiAqL1xyXG5pbXBvcnQge2ZpbGxUYWJsZVdpdGhQbGFjZWhvbGRlcnN9IGZyb20gJy4uL3V0aWxzLmpzJ1xyXG4vKipcclxuICogQ2FycmVnYSBvcyBkYWRvcyBkYSB0YWJlbGFcclxuICovXHJcbmV4cG9ydCBmdW5jdGlvbiBsb2FkTG9nRGF0YSh0YWJsZSkge1xyXG4gICAgZmlsbFRhYmxlV2l0aFBsYWNlaG9sZGVycygnbG9ncy10YWJsZScsMTAsMyk7XHJcbiAgICBmZXRjaChgL2xvZ3M/ZmllbGRzPSR7ZW5jb2RlVVJJQ29tcG9uZW50KCd1c2VyLm5hbWUsYWN0aW9uLG9yaWduLGRhdGV0aW1lJyl9YCwge1xyXG4gICAgICAgIG1ldGhvZDogJ2dldCcsXHJcbiAgICAgICAgaGVhZGVyczoge1xyXG4gICAgICAgICAgICAnQWNjZXB0JzogJ2FwcGxpY2F0aW9uL2pzb24nXHJcbiAgICAgICAgfVxyXG4gICAgfSkudGhlbihyZXNwb25zZSA9PiB7XHJcbiAgICAgICAgcmV0dXJuIHJlc3BvbnNlLmpzb24oKTtcclxuICAgIH0pLnRoZW4oZGF0YSA9PiB7XHJcbiAgICAgICAgY29uc3QgbnVtUm93cyA9IHVzZXJUYWJsZS5kYXRhLmRhdGEubGVuZ3RoO1xyXG4gICAgICAgIGNvbnN0IHJvd3NUb0RlbGV0ZSA9IEFycmF5LmZyb20oeyBsZW5ndGg6IG51bVJvd3MgfSwgKF8sIGkpID0+IGkpO1xyXG4gICAgICAgIHVzZXJUYWJsZS5yb3dzLnJlbW92ZShyb3dzVG9EZWxldGUpO1xyXG4gICAgICAgIGlmIChkYXRhLmxlbmd0aCkge1xyXG4gICAgICAgICAgICBjb25zdCBkdCA9IHNldERhdGFUYWJsZShkYXRhKTtcclxuICAgICAgICAgICAgdXNlclRhYmxlLmluc2VydChkdCk7XHJcbiAgICAgICAgfVxyXG4gICAgfSkuY2F0Y2goZXJyb3IgPT4ge30pO1xyXG59IiwiLyoqXHJcbiAqIE1vZHVsbyBjb20gZnVuY29lcyBkZSB1c28gZ2VyYWxcclxuICovXHJcbi8qKlxyXG4gKiBQYWRyYW8gZGEgc2VuaGEgcGFyYSB2YWxpZGFjYW9cclxuICovXHJcbmNvbnN0IHBhc3N3b3JkUGF0dGVybiA9IC9eKD89LipbYS16XSkoPz0uKltBLVpdKSg/PS4qXFxkKSg/PS4qW0AkISUqPyZdKVtBLVphLXpcXGRAJCElKj8mXXs4LH0kLztcclxuLyoqXHJcbiAqIFZhbGlkYSB1bSBlbmRlcmVjbyBkZSBlbWFpbFxyXG4gKiBAcGFyYW0ge3N0cmluZ30gZW1haWxcclxuICogQHJldHVybiBib29sZWFuXHJcbiAqL1xyXG5leHBvcnQgZnVuY3Rpb24gdmFsaWRhdGVFbWFpbChlbWFpbCkge1xyXG4gICAgY29uc3QgZW1haWxQYXR0ZXJuID0gL15bYS16QS1aMC05Ll8lKy1dK0BbYS16QS1aMC05Li1dK1xcLlthLXpBLVpdezIsfSQvO1xyXG4gICAgcmV0dXJuIGVtYWlsUGF0dGVybi50ZXN0KGVtYWlsKTtcclxufVxyXG4vKipcclxuICogRm9ybWF0YSB1bWEgc3RyaW5nIG5vIHBhZHJhbyAnU3RyaW5nJ1xyXG4gKiBAcGFyYW0ge3N0cmluZ30gc3RyIFxyXG4gKiBAcmV0dXJucyBcclxuICovXHJcbmV4cG9ydCBmdW5jdGlvbiBjYXBpdGFsaXplKHN0cikge1xyXG4gICAgcmV0dXJuIHN0ci5jaGFyQXQoMCkgKyBzdHIuc2xpY2UoMSkudG9Mb3dlckNhc2UoKTtcclxufVxyXG4vKipcclxuICogRm9ybWF0YSB1bWEgZGF0YSBubyBwYWRybyBsb2NhbCAocHQtQlIpXHJcbiAqIEBwYXJhbSB7c3RyaW5nfSBkYXRlU3RyaW5nIFxyXG4gKiBAcmV0dXJucyBcclxuICovXHJcbmV4cG9ydCBmdW5jdGlvbiBmb3JtYXREYXRlKGRhdGVTdHJpbmcpIHtcclxuICAgIGNvbnN0IGRhdGUgPSBuZXcgRGF0ZShkYXRlU3RyaW5nLnJlcGxhY2UoJyAnLCAnVCcpKVxyXG4gICAgY29uc3QgZm9ybWF0dGVyID0gbmV3IEludGwuRGF0ZVRpbWVGb3JtYXQoJ3B0LUJSJywgeyB5ZWFyOiAnbnVtZXJpYycsIG1vbnRoOiAnMi1kaWdpdCcsIGRheTogJzItZGlnaXQnLCBob3VyOiAnMi1kaWdpdCcsIG1pbnV0ZTogJzItZGlnaXQnIH0pO1xyXG4gICAgcmV0dXJuIGZvcm1hdHRlci5mb3JtYXQoZGF0ZSk7XHJcbn1cclxuLyoqXHJcbiAqIENhbGN1bGEgbyB0ZW1wbyBwYXNzYWRvIGEgcGFydGlyIGRlIHVtIGRhZG8gbW9tZW50b1xyXG4gKiBAcGFyYW0ge3N0cmluZ30gZGF0ZVN0cmluZyBcclxuICogQHJldHVybnMgXHJcbiAqL1xyXG5leHBvcnQgZnVuY3Rpb24gdGltZUVsYXBzZWQoZGF0ZVN0cmluZykge1xyXG4gICAgXHJcbiAgICBjb25zdCBkYXRlID0gbmV3IERhdGUoZGF0ZVN0cmluZy5yZXBsYWNlKFwiIFwiLCBcIlRcIikpO1xyXG4gICAgY29uc3Qgbm93ID0gbmV3IERhdGUoKTtcclxuXHJcbiAgICAvLyBDYWxjdWxhIGEgZGlmZXJlbmNhIGVtIG1pbGlzZWd1bmRvc1xyXG4gICAgY29uc3QgZGlmZkluTXMgPSBub3cgLSBkYXRlO1xyXG5cclxuICAgIC8vIGNvbnZlcnRlIG9zIG1pbGlzZWd1bmRvc1xyXG4gICAgY29uc3Qgc2Vjb25kcyA9IGRpZmZJbk1zIC8gMTAwMDtcclxuICAgIGNvbnN0IG1pbnV0ZXMgPSBzZWNvbmRzIC8gNjA7XHJcbiAgICBjb25zdCBob3VycyA9IG1pbnV0ZXMgLyA2MDtcclxuICAgIGNvbnN0IGRheXMgPSBob3VycyAvIDI0O1xyXG4gICAgY29uc3Qgd2Vla3MgPSBkYXlzIC8gNztcclxuICAgIGNvbnN0IG1vbnRocyA9IGRheXMgLyAzMDtcclxuXHJcbiAgICAvLyBDcmlhIHVtYSBpbnN0YW5jaWEgZGUgUmVsYXRpdmVUaW1lRm9ybWF0XHJcbiAgICBjb25zdCBydGYgPSBuZXcgSW50bC5SZWxhdGl2ZVRpbWVGb3JtYXQoJ2VuJywgeyBudW1lcmljOiAnYXV0bycgfSk7XHJcblxyXG4gICAgLy8gUmV0b3JuYSBvIHRlbXBvIGNvbSBiYXNlIG5vIGNsYWN1bG9cclxuICAgIGlmIChNYXRoLmFicyhtaW51dGVzKSA8IDYwKSB7XHJcbiAgICAgICAgcmV0dXJuIGAke01hdGgucm91bmQobWludXRlcyl9IG1pbnV0byR7TWF0aC5yb3VuZChtaW51dGVzKSAhPT0gMSA/ICdzJyA6ICcnfWA7XHJcbiAgICB9IGVsc2UgaWYgKE1hdGguYWJzKGhvdXJzKSA8IDE0KSB7XHJcbiAgICAgICAgcmV0dXJuIGAke01hdGgucm91bmQoaG91cnMpfSBob3JhJHtNYXRoLnJvdW5kKGhvdXJzKSAhPT0gMSA/ICdzJyA6ICcnfWA7XHJcbiAgICB9IGVsc2UgaWYgKE1hdGguYWJzKGRheXMpIDwgMzApIHtcclxuICAgICAgICByZXR1cm4gYCR7TWF0aC5yb3VuZChkYXlzKX0gZGlhJHtNYXRoLnJvdW5kKGRheXMpICE9PSAxID8gJ3MnIDogJyd9YDtcclxuICAgIH0gZWxzZSBpZiAoTWF0aC5hYnMod2Vla3MpIDwgNCkge1xyXG4gICAgICAgIHJldHVybiBgJHtNYXRoLnJvdW5kKHdlZWtzKX0gc2VtYW5hJHtNYXRoLnJvdW5kKHdlZWtzKSAhPT0gMSA/ICdzJyA6ICcnfWA7XHJcbiAgICB9IGVsc2Uge1xyXG4gICAgICAgIHJldHVybiBgJHtNYXRoLnJvdW5kKG1vbnRocyl9ICR7TWF0aC5yb3VuZChtb250aHMpID09PSAxID8gJ23DqnMnIDogJ21lc2VzJ31gO1xyXG4gICAgfVxyXG59XHJcbi8qKlxyXG4gKiBQcmVlbmNoZSB1bWEgdGFiZWxhIGNvbSBsaW5oYXMgcHJlZW5jaGlkYXMgY29tIHBsYWNlaG9sZGVyc1xyXG4gKiBAcGFyYW0ge3N0cmluZ30gdGFibGVJZCBcclxuICogQHBhcmFtIHtudW1lcmljfSBudW1Sb3dzIFxyXG4gKiBAcGFyYW0ge251bWVyaWN9IG51bUNvbHMgXHJcbiAqIEByZXR1cm5zIFxyXG4gKi9cclxuZXhwb3J0IGZ1bmN0aW9uIGZpbGxUYWJsZVdpdGhQbGFjZWhvbGRlcnModGFibGVJZCwgbnVtUm93cywgbnVtQ29scykge1xyXG4gICAgLy8gUGVnYSBhIHRhYmVsYVxyXG4gICAgY29uc3QgdGFibGUgPSBkb2N1bWVudC5nZXRFbGVtZW50QnlJZCh0YWJsZUlkKTtcclxuICAgIFxyXG4gICAgLy8gUmV0b3JuYSBlcnJvIHNlIG7Do28gZXhpc3RpclxyXG4gICAgaWYgKCF0YWJsZSkge1xyXG4gICAgICAgIGNvbnNvbGUuZXJyb3IoJ1RhYmVsYSBuw6NvIGVuY29udHJhZGEhJyk7XHJcbiAgICAgICAgcmV0dXJuO1xyXG4gICAgfVxyXG4gICAgY29uc3QgbGluZXMgPSBbXTtcclxuICAgIC8vIENyaWEgYXMgbGluaGFzXHJcbiAgICBmb3IgKGxldCBpID0gMDsgaSA8IG51bVJvd3M7IGkrKykge1xyXG4gICAgICAgIGNvbnN0IHRyID0gZG9jdW1lbnQuY3JlYXRlRWxlbWVudCgndHInKTtcclxuXHJcbiAgICAgICAgLy8gQ3JpYSBhIGNlbHVsYSAoY29sdW5hKVxyXG4gICAgICAgIGZvciAobGV0IGogPSAwOyBqIDwgbnVtQ29sczsgaisrKSB7XHJcbiAgICAgICAgICAgIGNvbnN0IHRkID0gZG9jdW1lbnQuY3JlYXRlRWxlbWVudCgndGQnKTtcclxuXHJcbiAgICAgICAgICAgIC8vIENyaWEgbyBwbGFjZWhvbGRlclxyXG4gICAgICAgICAgICBjb25zdCBwbGFjZWhvbGRlciA9IGRvY3VtZW50LmNyZWF0ZUVsZW1lbnQoJ2RpdicpO1xyXG4gICAgICAgICAgICBwbGFjZWhvbGRlci5jbGFzc0xpc3QuYWRkKCdwbGFjZWhvbGRlcicsICdnbG93Jyk7XHJcbiAgICAgICAgICAgIHBsYWNlaG9sZGVyLmlubmVySFRNTCA9ICc8c3BhbiBjbGFzcz1cInZpc3VhbGx5LWhpZGRlblwiPkxvYWRpbmcuLi48L3NwYW4+JztcclxuXHJcbiAgICAgICAgICAgIC8vIGluc2VyZSBuYSBjZWx1bGFcclxuICAgICAgICAgICAgdGQuYXBwZW5kKHBsYWNlaG9sZGVyKTtcclxuXHJcbiAgICAgICAgICAgIGxpbmVzLnB1c2godGQpXHJcbiAgICAgICAgfVxyXG4gICAgfVxyXG4gICAgcmV0dXJuIGxpbmVzO1xyXG59XHJcbi8qKlxyXG4gKiBSZXRvcm5hIHVtYSBpbnN0YW5jaWEgZGEgdGFiZWxhIGh0bWxzXHJcbiAqIEBwYXJhbSB7c3RyaW5nfSBpZCBcclxuICovXHJcbmV4cG9ydCBmdW5jdGlvbiBnZXREYXRhdGFibGVPYmplY3QoaWQpe1xyXG4gICAgcmV0dXJuIG5ldyBzaW1wbGVEYXRhdGFibGVzLkRhdGFUYWJsZShgIyR7aWR9YCwge1xyXG4gICAgICAgIGxhYmVsczogcHRfQlJcclxuICAgIH0pO1xyXG59IiwiLy8gVGhlIG1vZHVsZSBjYWNoZVxudmFyIF9fd2VicGFja19tb2R1bGVfY2FjaGVfXyA9IHt9O1xuXG4vLyBUaGUgcmVxdWlyZSBmdW5jdGlvblxuZnVuY3Rpb24gX193ZWJwYWNrX3JlcXVpcmVfXyhtb2R1bGVJZCkge1xuXHQvLyBDaGVjayBpZiBtb2R1bGUgaXMgaW4gY2FjaGVcblx0dmFyIGNhY2hlZE1vZHVsZSA9IF9fd2VicGFja19tb2R1bGVfY2FjaGVfX1ttb2R1bGVJZF07XG5cdGlmIChjYWNoZWRNb2R1bGUgIT09IHVuZGVmaW5lZCkge1xuXHRcdHJldHVybiBjYWNoZWRNb2R1bGUuZXhwb3J0cztcblx0fVxuXHQvLyBDcmVhdGUgYSBuZXcgbW9kdWxlIChhbmQgcHV0IGl0IGludG8gdGhlIGNhY2hlKVxuXHR2YXIgbW9kdWxlID0gX193ZWJwYWNrX21vZHVsZV9jYWNoZV9fW21vZHVsZUlkXSA9IHtcblx0XHQvLyBubyBtb2R1bGUuaWQgbmVlZGVkXG5cdFx0Ly8gbm8gbW9kdWxlLmxvYWRlZCBuZWVkZWRcblx0XHRleHBvcnRzOiB7fVxuXHR9O1xuXG5cdC8vIEV4ZWN1dGUgdGhlIG1vZHVsZSBmdW5jdGlvblxuXHRfX3dlYnBhY2tfbW9kdWxlc19fW21vZHVsZUlkXShtb2R1bGUsIG1vZHVsZS5leHBvcnRzLCBfX3dlYnBhY2tfcmVxdWlyZV9fKTtcblxuXHQvLyBSZXR1cm4gdGhlIGV4cG9ydHMgb2YgdGhlIG1vZHVsZVxuXHRyZXR1cm4gbW9kdWxlLmV4cG9ydHM7XG59XG5cbi8vIGV4cG9zZSB0aGUgbW9kdWxlcyBvYmplY3QgKF9fd2VicGFja19tb2R1bGVzX18pXG5fX3dlYnBhY2tfcmVxdWlyZV9fLm0gPSBfX3dlYnBhY2tfbW9kdWxlc19fO1xuXG4iLCJ2YXIgZGVmZXJyZWQgPSBbXTtcbl9fd2VicGFja19yZXF1aXJlX18uTyA9IChyZXN1bHQsIGNodW5rSWRzLCBmbiwgcHJpb3JpdHkpID0+IHtcblx0aWYoY2h1bmtJZHMpIHtcblx0XHRwcmlvcml0eSA9IHByaW9yaXR5IHx8IDA7XG5cdFx0Zm9yKHZhciBpID0gZGVmZXJyZWQubGVuZ3RoOyBpID4gMCAmJiBkZWZlcnJlZFtpIC0gMV1bMl0gPiBwcmlvcml0eTsgaS0tKSBkZWZlcnJlZFtpXSA9IGRlZmVycmVkW2kgLSAxXTtcblx0XHRkZWZlcnJlZFtpXSA9IFtjaHVua0lkcywgZm4sIHByaW9yaXR5XTtcblx0XHRyZXR1cm47XG5cdH1cblx0dmFyIG5vdEZ1bGZpbGxlZCA9IEluZmluaXR5O1xuXHRmb3IgKHZhciBpID0gMDsgaSA8IGRlZmVycmVkLmxlbmd0aDsgaSsrKSB7XG5cdFx0dmFyIFtjaHVua0lkcywgZm4sIHByaW9yaXR5XSA9IGRlZmVycmVkW2ldO1xuXHRcdHZhciBmdWxmaWxsZWQgPSB0cnVlO1xuXHRcdGZvciAodmFyIGogPSAwOyBqIDwgY2h1bmtJZHMubGVuZ3RoOyBqKyspIHtcblx0XHRcdGlmICgocHJpb3JpdHkgJiAxID09PSAwIHx8IG5vdEZ1bGZpbGxlZCA+PSBwcmlvcml0eSkgJiYgT2JqZWN0LmtleXMoX193ZWJwYWNrX3JlcXVpcmVfXy5PKS5ldmVyeSgoa2V5KSA9PiAoX193ZWJwYWNrX3JlcXVpcmVfXy5PW2tleV0oY2h1bmtJZHNbal0pKSkpIHtcblx0XHRcdFx0Y2h1bmtJZHMuc3BsaWNlKGotLSwgMSk7XG5cdFx0XHR9IGVsc2Uge1xuXHRcdFx0XHRmdWxmaWxsZWQgPSBmYWxzZTtcblx0XHRcdFx0aWYocHJpb3JpdHkgPCBub3RGdWxmaWxsZWQpIG5vdEZ1bGZpbGxlZCA9IHByaW9yaXR5O1xuXHRcdFx0fVxuXHRcdH1cblx0XHRpZihmdWxmaWxsZWQpIHtcblx0XHRcdGRlZmVycmVkLnNwbGljZShpLS0sIDEpXG5cdFx0XHR2YXIgciA9IGZuKCk7XG5cdFx0XHRpZiAociAhPT0gdW5kZWZpbmVkKSByZXN1bHQgPSByO1xuXHRcdH1cblx0fVxuXHRyZXR1cm4gcmVzdWx0O1xufTsiLCIvLyBkZWZpbmUgZ2V0dGVyIGZ1bmN0aW9ucyBmb3IgaGFybW9ueSBleHBvcnRzXG5fX3dlYnBhY2tfcmVxdWlyZV9fLmQgPSAoZXhwb3J0cywgZGVmaW5pdGlvbikgPT4ge1xuXHRmb3IodmFyIGtleSBpbiBkZWZpbml0aW9uKSB7XG5cdFx0aWYoX193ZWJwYWNrX3JlcXVpcmVfXy5vKGRlZmluaXRpb24sIGtleSkgJiYgIV9fd2VicGFja19yZXF1aXJlX18ubyhleHBvcnRzLCBrZXkpKSB7XG5cdFx0XHRPYmplY3QuZGVmaW5lUHJvcGVydHkoZXhwb3J0cywga2V5LCB7IGVudW1lcmFibGU6IHRydWUsIGdldDogZGVmaW5pdGlvbltrZXldIH0pO1xuXHRcdH1cblx0fVxufTsiLCJfX3dlYnBhY2tfcmVxdWlyZV9fLm8gPSAob2JqLCBwcm9wKSA9PiAoT2JqZWN0LnByb3RvdHlwZS5oYXNPd25Qcm9wZXJ0eS5jYWxsKG9iaiwgcHJvcCkpIiwiLy8gZGVmaW5lIF9fZXNNb2R1bGUgb24gZXhwb3J0c1xuX193ZWJwYWNrX3JlcXVpcmVfXy5yID0gKGV4cG9ydHMpID0+IHtcblx0aWYodHlwZW9mIFN5bWJvbCAhPT0gJ3VuZGVmaW5lZCcgJiYgU3ltYm9sLnRvU3RyaW5nVGFnKSB7XG5cdFx0T2JqZWN0LmRlZmluZVByb3BlcnR5KGV4cG9ydHMsIFN5bWJvbC50b1N0cmluZ1RhZywgeyB2YWx1ZTogJ01vZHVsZScgfSk7XG5cdH1cblx0T2JqZWN0LmRlZmluZVByb3BlcnR5KGV4cG9ydHMsICdfX2VzTW9kdWxlJywgeyB2YWx1ZTogdHJ1ZSB9KTtcbn07IiwiLy8gbm8gYmFzZVVSSVxuXG4vLyBvYmplY3QgdG8gc3RvcmUgbG9hZGVkIGFuZCBsb2FkaW5nIGNodW5rc1xuLy8gdW5kZWZpbmVkID0gY2h1bmsgbm90IGxvYWRlZCwgbnVsbCA9IGNodW5rIHByZWxvYWRlZC9wcmVmZXRjaGVkXG4vLyBbcmVzb2x2ZSwgcmVqZWN0LCBQcm9taXNlXSA9IGNodW5rIGxvYWRpbmcsIDAgPSBjaHVuayBsb2FkZWRcbnZhciBpbnN0YWxsZWRDaHVua3MgPSB7XG5cdFwiL2pzL2FwcFwiOiAwLFxuXHRcImNzcy9hcHBcIjogMFxufTtcblxuLy8gbm8gY2h1bmsgb24gZGVtYW5kIGxvYWRpbmdcblxuLy8gbm8gcHJlZmV0Y2hpbmdcblxuLy8gbm8gcHJlbG9hZGVkXG5cbi8vIG5vIEhNUlxuXG4vLyBubyBITVIgbWFuaWZlc3RcblxuX193ZWJwYWNrX3JlcXVpcmVfXy5PLmogPSAoY2h1bmtJZCkgPT4gKGluc3RhbGxlZENodW5rc1tjaHVua0lkXSA9PT0gMCk7XG5cbi8vIGluc3RhbGwgYSBKU09OUCBjYWxsYmFjayBmb3IgY2h1bmsgbG9hZGluZ1xudmFyIHdlYnBhY2tKc29ucENhbGxiYWNrID0gKHBhcmVudENodW5rTG9hZGluZ0Z1bmN0aW9uLCBkYXRhKSA9PiB7XG5cdHZhciBbY2h1bmtJZHMsIG1vcmVNb2R1bGVzLCBydW50aW1lXSA9IGRhdGE7XG5cdC8vIGFkZCBcIm1vcmVNb2R1bGVzXCIgdG8gdGhlIG1vZHVsZXMgb2JqZWN0LFxuXHQvLyB0aGVuIGZsYWcgYWxsIFwiY2h1bmtJZHNcIiBhcyBsb2FkZWQgYW5kIGZpcmUgY2FsbGJhY2tcblx0dmFyIG1vZHVsZUlkLCBjaHVua0lkLCBpID0gMDtcblx0aWYoY2h1bmtJZHMuc29tZSgoaWQpID0+IChpbnN0YWxsZWRDaHVua3NbaWRdICE9PSAwKSkpIHtcblx0XHRmb3IobW9kdWxlSWQgaW4gbW9yZU1vZHVsZXMpIHtcblx0XHRcdGlmKF9fd2VicGFja19yZXF1aXJlX18ubyhtb3JlTW9kdWxlcywgbW9kdWxlSWQpKSB7XG5cdFx0XHRcdF9fd2VicGFja19yZXF1aXJlX18ubVttb2R1bGVJZF0gPSBtb3JlTW9kdWxlc1ttb2R1bGVJZF07XG5cdFx0XHR9XG5cdFx0fVxuXHRcdGlmKHJ1bnRpbWUpIHZhciByZXN1bHQgPSBydW50aW1lKF9fd2VicGFja19yZXF1aXJlX18pO1xuXHR9XG5cdGlmKHBhcmVudENodW5rTG9hZGluZ0Z1bmN0aW9uKSBwYXJlbnRDaHVua0xvYWRpbmdGdW5jdGlvbihkYXRhKTtcblx0Zm9yKDtpIDwgY2h1bmtJZHMubGVuZ3RoOyBpKyspIHtcblx0XHRjaHVua0lkID0gY2h1bmtJZHNbaV07XG5cdFx0aWYoX193ZWJwYWNrX3JlcXVpcmVfXy5vKGluc3RhbGxlZENodW5rcywgY2h1bmtJZCkgJiYgaW5zdGFsbGVkQ2h1bmtzW2NodW5rSWRdKSB7XG5cdFx0XHRpbnN0YWxsZWRDaHVua3NbY2h1bmtJZF1bMF0oKTtcblx0XHR9XG5cdFx0aW5zdGFsbGVkQ2h1bmtzW2NodW5rSWRdID0gMDtcblx0fVxuXHRyZXR1cm4gX193ZWJwYWNrX3JlcXVpcmVfXy5PKHJlc3VsdCk7XG59XG5cbnZhciBjaHVua0xvYWRpbmdHbG9iYWwgPSBzZWxmW1wid2VicGFja0NodW5rXCJdID0gc2VsZltcIndlYnBhY2tDaHVua1wiXSB8fCBbXTtcbmNodW5rTG9hZGluZ0dsb2JhbC5mb3JFYWNoKHdlYnBhY2tKc29ucENhbGxiYWNrLmJpbmQobnVsbCwgMCkpO1xuY2h1bmtMb2FkaW5nR2xvYmFsLnB1c2ggPSB3ZWJwYWNrSnNvbnBDYWxsYmFjay5iaW5kKG51bGwsIGNodW5rTG9hZGluZ0dsb2JhbC5wdXNoLmJpbmQoY2h1bmtMb2FkaW5nR2xvYmFsKSk7IiwiIiwiLy8gc3RhcnR1cFxuLy8gTG9hZCBlbnRyeSBtb2R1bGUgYW5kIHJldHVybiBleHBvcnRzXG4vLyBUaGlzIGVudHJ5IG1vZHVsZSBkZXBlbmRzIG9uIG90aGVyIGxvYWRlZCBjaHVua3MgYW5kIGV4ZWN1dGlvbiBuZWVkIHRvIGJlIGRlbGF5ZWRcbl9fd2VicGFja19yZXF1aXJlX18uTyh1bmRlZmluZWQsIFtcImNzcy9hcHBcIl0sICgpID0+IChfX3dlYnBhY2tfcmVxdWlyZV9fKFwiLi9yZXNvdXJjZXMvanMvcHJpdmF0ZS9hcHAuanNcIikpKVxudmFyIF9fd2VicGFja19leHBvcnRzX18gPSBfX3dlYnBhY2tfcmVxdWlyZV9fLk8odW5kZWZpbmVkLCBbXCJjc3MvYXBwXCJdLCAoKSA9PiAoX193ZWJwYWNrX3JlcXVpcmVfXyhcIi4vcmVzb3VyY2VzL2Nzcy9hcHAuY3NzXCIpKSlcbl9fd2VicGFja19leHBvcnRzX18gPSBfX3dlYnBhY2tfcmVxdWlyZV9fLk8oX193ZWJwYWNrX2V4cG9ydHNfXyk7XG4iLCIiXSwibmFtZXMiOlsidGltZUVsYXBzZWQiLCJmaWxsVGFibGVXaXRoUGxhY2Vob2xkZXJzIiwiZ2V0RGF0YXRhYmxlT2JqZWN0IiwiaWQiLCJzaW1wbGVEYXRhdGFibGVzIiwiRGF0YVRhYmxlIiwiY29uY2F0IiwibGFiZWxzIiwicHRfQlIiLCJnZXRMYWJlbCIsImRhdGEiLCJfZGF0YSRkZXNjcmlwdGlvbiIsIl9kYXRhJHVzZXIkY29tcGFueSIsInN0YXR1cyIsImNvbnRlbnQiLCJkb2N1bWVudCIsImNyZWF0ZUVsZW1lbnQiLCJoZWFkZXIiLCJsaW5rIiwic2V0QXR0cmlidXRlIiwiaW5uZXJIVE1MIiwibmFtZSIsIm91dGVySFRNTCIsImNsYXNzTGlzdCIsImFkZCIsImRlc2MiLCJkZXNjcmlwdGlvbiIsInJlc3VtbyIsInRvdGFsX2xpc3QiLCJkYXRlX2Zyb20iLCJkYXRlX3RvIiwidXBkYXRlIiwidXBkYXRlZCIsImNvbXBhbnkiLCJ1c2VyIiwiY3JlYXRlZCIsImFwcGVuZCIsImNsZWFyVGFibGUiLCJkdGIiLCJudW1Sb3dzIiwibGVuZ3RoIiwicm93c1RvRGVsZXRlIiwiQXJyYXkiLCJmcm9tIiwiXyIsImkiLCJyb3dzIiwicmVtb3ZlIiwiZ2V0U3RhdHVzTGFiZWwiLCJzdGF0dXNDb2xvciIsInN0YXR1c0xhYmVsIiwic3RMYWJlbCIsImdldEJ1dHRvbnMiLCJjb250YWluZXIiLCJidXR0b25zIiwiaWNvbiIsImF0dHIiLCJ0eXBlIiwidGl0bGUiLCJmb3JFYWNoIiwiYnRuIiwiYnV0dG9uIiwiT2JqZWN0Iiwia2V5cyIsIm1hcCIsImNsYXNzTmFtZSIsImFwcGVuZENoaWxkIiwic2V0RGF0YVRhYmxlIiwiZHRiMSIsImR0YjIiLCJkYWRvc1Blcm1hbmVudGVzIiwiZGFkb3NUZW1wb3JhcmlvcyIsImR0Iiwic3RhdGUiLCJwdXNoIiwiaW5zZXJ0IiwibG9hZEFuYWxpc2VzRGF0YSIsImZldGNoIiwibWV0aG9kIiwiaGVhZGVycyIsInRoZW4iLCJyZXNwb25zZSIsImpzb24iLCJlcnJvciIsImNyZWF0ZUFuYWxpc2UiLCJ1cGRhdGVBbmFsaXNlIiwiZGVsZXRlQW5hbGlzZSIsImNvbnNvbGUiLCJsb2ciLCJkZXRhbGhhckFuYWxpc2UiLCJsb2FkVXNlckRhdGEiLCJsb2FkTG9nRGF0YSIsInNldENvbmZpZ0Zvcm1WYWx1ZXMiLCJhZGRFdmVudExpc3RlbmVyIiwidGJQZXJtYW5lbnRlIiwidGJUZW1wb3JhcmlhIiwicXVlcnlTZWxlY3RvciIsImluaXRpYWxpemVkIiwiZGVzdHJveSIsInF1ZXJ5U2VsZWN0b3JBbGwiLCJ0YWIiLCJlIiwidGFyZ2V0IiwiY2xvc2VzdCIsImNsYXNzZXMiLCJnZXRBdHRyaWJ1dGUiLCJzcGxpdCIsImluY2x1ZGVzIiwiZWRpdEFuYWxpc2UiLCJlbCIsImVsTmFtZSIsImF0dHJpYnV0ZXMiLCJ2YWx1ZSIsImNoZWNrZWQiLCJib2R5IiwiSlNPTiIsInN0cmluZ2lmeSIsInVpZCIsInVzZXJUYWJsZSIsInBhcmVudEVsZW1lbnQiLCJldmVudCIsImV4Y2x1aXJVc3VhcmlvIiwibG9nc1RhYmxlIiwiZm9ybSIsImZpZWxkIiwiZW5jb2RlVVJJQ29tcG9uZW50IiwiZ2V0VXNlckRhdGEiLCJfZGF0YSRwaG90byIsImF2YXRhciIsInBob3RvIiwiaW5mbyIsImVtYWlsIiwibG5zIiwiY29uZmlybWFjYW8iLCJ0YWJsZSIsInBhc3N3b3JkUGF0dGVybiIsInZhbGlkYXRlRW1haWwiLCJlbWFpbFBhdHRlcm4iLCJ0ZXN0IiwiY2FwaXRhbGl6ZSIsInN0ciIsImNoYXJBdCIsInNsaWNlIiwidG9Mb3dlckNhc2UiLCJmb3JtYXREYXRlIiwiZGF0ZVN0cmluZyIsImRhdGUiLCJEYXRlIiwicmVwbGFjZSIsImZvcm1hdHRlciIsIkludGwiLCJEYXRlVGltZUZvcm1hdCIsInllYXIiLCJtb250aCIsImRheSIsImhvdXIiLCJtaW51dGUiLCJmb3JtYXQiLCJub3ciLCJkaWZmSW5NcyIsInNlY29uZHMiLCJtaW51dGVzIiwiaG91cnMiLCJkYXlzIiwid2Vla3MiLCJtb250aHMiLCJydGYiLCJSZWxhdGl2ZVRpbWVGb3JtYXQiLCJudW1lcmljIiwiTWF0aCIsImFicyIsInJvdW5kIiwidGFibGVJZCIsIm51bUNvbHMiLCJnZXRFbGVtZW50QnlJZCIsImxpbmVzIiwidHIiLCJqIiwidGQiLCJwbGFjZWhvbGRlciJdLCJzb3VyY2VSb290IjoiIn0=