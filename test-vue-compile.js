const fs = require('fs');
const compiler = require('@vue/compiler-dom');
const html = fs.readFileSync('app/Views/course-quiz.html', 'utf8');

// Extract #app
const match = html.match(/<div id="app"[\s\S]*?(<script src="https:\/\/cdn\.jsdelivr\.net)/);
if (!match) {
    console.log("Could not extract #app");
    process.exit(1);
}
let template = match[0].replace('<script src="https://cdn.jsdelivr.net', '');
// Remove the extra closing tags if they are outside
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
