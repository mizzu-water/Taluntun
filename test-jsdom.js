const fs = require('fs');
const html = fs.readFileSync('app/Views/course-quiz.html', 'utf8');
const { JSDOM } = require('jsdom');
const dom = new JSDOM(html);
const appDiv = dom.window.document.getElementById('app');
console.log("App div exists:", !!appDiv);
if (appDiv) console.log("App div innerHTML length:", appDiv.innerHTML.length);
