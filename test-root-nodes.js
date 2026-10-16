const fs = require('fs');
const html = fs.readFileSync('app/Views/course-quiz.html', 'utf8');
const { parseFragment } = require('parse5');

// Parse only the HTML part
const htmlPart = html.substring(0, html.indexOf('<script'));
const frag = parseFragment(htmlPart, { sourceCodeLocationInfo: true });

// Check if any tag is unclosed by looking at parse errors
// Actually parse5 auto-closes. We can count the number of childNodes of the document fragment.
// If it's a single root div, it should have 1 element child.
let elementChildren = frag.childNodes.filter(n => n.nodeName !== '#text' && n.nodeName !== '#comment' && n.nodeName !== 'style');
console.log("Root elements:", elementChildren.map(n => n.nodeName));
if (elementChildren.length === 1) {
    console.log("Single root element.");
} else {
    console.log("Multiple root elements! This means a div was closed too early.");
    elementChildren.forEach(c => console.log(c.nodeName, c.attrs));
}
