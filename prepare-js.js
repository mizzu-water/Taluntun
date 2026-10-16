const fs = require('fs');
const html = fs.readFileSync('app/Views/course-quiz.html', 'utf8');

const scriptMatch = html.match(/<script>\s*([\s\S]*?)<\/script>/);
if (!scriptMatch) {
    console.log("No script found");
    process.exit(1);
}

let jsCode = scriptMatch[1];
const vueMock = "const Vue = { createApp: (opts) => { try { opts.setup(); console.log('Setup ran ok'); } catch(e) { console.log('Setup error', e); } return { mount: () => {} }; }, ref: (val) => ({ value: val }), computed: (fn) => ({ get value() { return fn(); } }), onMounted: (fn) => { fn(); }, watch: () => {} }; const window = { location: { search: '?degree_id=5' } }; const URLSearchParams = class { constructor() {} get() { return '5'; } }; const localStorage = { getItem: () => null, setItem: () => {} }; const document = { querySelector: () => ({ style: {} }) };\n";

fs.writeFileSync('test-js-run.js', vueMock + jsCode, 'utf8');
