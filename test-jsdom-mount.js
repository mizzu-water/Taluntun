const fs = require('fs');
const { JSDOM } = require('jsdom');

const html = fs.readFileSync('app/Views/course-quiz.html', 'utf8');

const fullHtml = '<!DOCTYPE html><html><head><script src="https://unpkg.com/vue@3/dist/vue.global.js"><\/script></head><body>' + html + '</body></html>';

const dom = new JSDOM(fullHtml, { runScripts: "dangerously", resources: "usable", url: "http://localhost/riasec/course-quiz?degree_id=5" });

dom.window.onerror = (msg, url, line, col, err) => {
    console.log("JSDOM ERROR:", msg);
};
dom.window.console.error = (...args) => {
    console.log("CONSOLE ERROR:", ...args);
};

setTimeout(() => {
    const appDiv = dom.window.document.getElementById('app');
    console.log("APP INNER HTML AFTER 3 SECONDS:");
    console.log(appDiv ? appDiv.innerHTML.substring(0, 500) : "NO APP DIV");
    process.exit(0);
}, 3000);
