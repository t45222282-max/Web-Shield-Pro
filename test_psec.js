const fs = require('fs');
const jsdom = require("jsdom");
const { JSDOM } = jsdom;

const dom = new JSDOM(`<!DOCTYPE html><html data-theme="dark"><head></head><body><canvas id="log-stats"></canvas></body></html>`, {
    url: "http://localhost/dashboard.php"
});

global.window = dom.window;
global.document = dom.window.document;

// Dummy jQuery
global.$ = function(selector) {
    if (selector === document || selector === window || typeof selector === 'function') {
        return {
            ready: function(cb) { cb(); },
            scroll: function() {},
            tooltip: function() {},
            select2: function() {},
            dataTable: function() {}
        };
    }
    return global.$({}); 
};
global.$.ajax = function(options) {
    if (options.url === "chart_dashboard.php") {
        options.success('{"SQLi":[0,0,0,0,0,0,0,0,0,0,0,43],"Bad Bot":[0,0,0,0,0,0,0,0,0,0,0,35],"Proxies":[0,0,0,0,0,0,0,0,0,0,0,32],"Spammers":[0,0,0,0,0,0,0,0,0,0,0,31]}');
    }
};
global.jQuery = global.$;

// Dummy Chart.js
global.Chart = class Chart {
    constructor(ctx, config) {
        console.log("Chart created with type:", config.type);
    }
};
global.Chart.defaults = { font: {}, plugins: { tooltip: {} }, elements: { line: {} } };

// Dummy Switchery
global.Switchery = class Switchery {};

try {
    // Include psec.js
    const psecCode = fs.readFileSync('c:/xampp/htdocs/pro1/assets/js/psec.js', 'utf8');
    eval(psecCode);
    console.log("psec.js executed successfully!");
} catch (e) {
    console.error("Error executing psec.js:", e);
}
