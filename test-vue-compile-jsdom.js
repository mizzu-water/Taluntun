const fs = require('fs');
const compiler = require('@vue/compiler-dom');
const jsdom = require('jsdom');
const { JSDOM } = jsdom;

const html = fs.readFileSync('app/Views/course-quiz.html', 'utf8');

const dom = new JSDOM(html);
const appDiv = dom.window.document.getElementById('app');

if (!appDiv) {
    console.log("No #app found");
    process.exit(1);
}

const template = appDiv.innerHTML;

try {
    const { errors } = compiler.compile(template);
    if (errors && errors.length > 0) {
        console.log("VUE TEMPLATE ERRORS:", errors);
    } else {
        console.log("Vue template compiles successfully.");
    }
} catch (e) {
    console.log("COMPILE ERROR:", e);
}
