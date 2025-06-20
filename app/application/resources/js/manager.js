/**
 * Scripts para o modulo de gerenciamento
 */
'use strict';
import * as clients from './clients.js';
import * as consultants from './consultants.js';
import * as agents from './agents.js';
import * as companies from './companies.js';
import * as partners from './partners.js';
import * as portfolios from './portfolios.js';
import * as plans from './plans.js';

$(document).ready(function () {
    $(document).on('page:loaded', function (e) {
        const url = e.originalEvent.detail.url;
        const modules = { consultants, clients, agents, companies, partners, portfolios, plans };
        const path = url.substr(1);
        if (modules[path]) {
            modules[path].init();
        } else {
            console.warn("Módulo não encontrado:", path);
        }
    });
});