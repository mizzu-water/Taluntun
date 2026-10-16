const fs = require('fs');
const { JSDOM } = require('jsdom');

let html = fs.readFileSync('app/Views/course-quiz.html', 'utf8');

const fetchMock = "window.fetch = async (url) => { return { json: async () => ({ success: true, degree_title: 'Mock Degree', questions: [ { text: 'Test Q', options: {A:'A', B:'B', C:'C', D:'D'}, correct: 'A' } ] }) }; };";

const fullHtml = '<!DOCTYPE html><html><head><script src="https://unpkg.com/vue@3/dist/vue.global.js"><\/script><script>' + fetchMock + '<\/script></head><body><div id="app"><header>Head</header><main>' + html + '</main><footer>Foot</footer></div></body></html>';

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
    console.log(appDiv ? appDiv.innerHTML.substring(0, 1000) : "NO APP DIV");
    process.exit(0);
}, 3000);
