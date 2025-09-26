'use strict';

import * as accounts from './accounts.js';
import * as transactions from './transactions.js';

$(function () {
    // Desabilita o clique nos links do menu
    $('#app-content #financialMenu ~ ul li').on('click', function (e) {
        e.preventDefault();
        const path = window.location.pathname;
        if (path === '/financial/accounts') {
            accounts.init();
        } else if (path === '/financial/transactions') {
            transactions.init();
        } else {
            console.warn('Sub-módulo financeiro não encontrado:', path);
        }
    });
});