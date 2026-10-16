const fs = require('fs');
const html = fs.readFileSync('app/Views/course-quiz.html', 'utf8');
const { parse } = require('parse5');

const document = parse(html, { sourceCodeLocationInfo: true, onParseError: (err) => console.log('ERROR:', err) });
