let mix = require('laravel-mix');
let fs = require('fs');
let path = require('path');

// Base paths
const modulePath = 'app/';
const outputPath = 'public/';

// Get module name from environment variable
let moduleName = process.env.MODULE;


// Function to compile assets for a given module
function compileModule(module) {
    let jsPath = path.join(modulePath, module.trim(), '/resources/js/app.js');
    let cssPath = path.join(modulePath, module, '/resources/css/app.scss');
    
    if (fs.existsSync(jsPath)) {
        mix.js(jsPath, `${outputPath}/js/${module}.js`);
    }

    if (fs.existsSync(cssPath)) {
        mix.sass(cssPath, `${outputPath}/css/${module}`);
    }

    console.log(`✅ Compiled assets for module: ${module}`);
}

// If a module is specified, compile only that module
if (moduleName) {
    compileModule(moduleName);
} else {
    // If no module is specified, compile all modules
    console.log("⚡ No module specified. Compiling all modules...");
    fs.readdirSync(modulePath).forEach(module => {
        compileModule(module);
    });
}

// Enable versioning in production
if (mix.inProduction()) {
    mix.version();
}
