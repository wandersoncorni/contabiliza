import * as app from './application.js';

document.addEventListener("DOMContentLoaded", () => {
    const scroll = new SmoothScroll('a[href*="#"]', {
        speed: 300,
        speedAsDuration: true,
        offset: 0,
        updateURL: false,
        popstate: false,
        emitEvents: true
    });
    app.init();    
});
