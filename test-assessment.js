const fs = require('fs');
const html = fs.readFileSync('app/Views/assessment.html', 'utf8');
const { parseFragment } = require('parse5');

const htmlPart = html.substring(0, html.indexOf('<script'));
const frag = parseFragment(htmlPart, { sourceCodeLocationInfo: true });

let elementChildren = frag.childNodes.filter(n => n.nodeName !== '#text' && n.nodeName !== '#comment' && n.nodeName !== 'style');
console.log("Assessment root elements:", elementChildren.length);
