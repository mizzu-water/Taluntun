const fs = require("fs");

let new_questions = [
    { text: "I like to build, repair, or assemble things.", trait: "R" },
    { text: "I enjoy working outdoors or with animals.", trait: "R" },
    { text: "I like to fix electrical appliances.", trait: "R" },
    { text: "I enjoy operating heavy machinery or tools.", trait: "R" },
    { text: "I like doing hands-on physical labor.", trait: "R" },
    { text: "I prefer practical, physical tasks over abstract thinking.", trait: "R" },
    { text: "I like repairing cars or mechanical things.", trait: "R" },
    { text: "I enjoy assembling furniture or equipment.", trait: "R" },
    { text: "I am interested in building construction.", trait: "R" },
    { text: "I like working with my hands and seeing a tangible result.", trait: "R" },
    { text: "I enjoy solving math or science problems.", trait: "I" },
    { text: "I like conducting experiments or researching.", trait: "I" },
    { text: "I enjoy analyzing data to find patterns.", trait: "I" },
    { text: "I like reading scientific articles or journals.", trait: "I" },
    { text: "I am curious about how things work logically.", trait: "I" },
    { text: "I enjoy investigating mysteries or unsolved problems.", trait: "I" },
    { text: "I prefer working independently in a lab or quiet space.", trait: "I" },
    { text: "I like figuring out complex theoretical puzzles.", trait: "I" },
    { text: "I am interested in exploring new scientific theories.", trait: "I" },
    { text: "I enjoy programming computers or analyzing code.", trait: "I" },
    { text: "I like to write, draw, sing, or perform.", trait: "A" },
    { text: "I enjoy designing spaces or creating art.", trait: "A" },
    { text: "I prefer to express myself creatively rather than follow strict rules.", trait: "A" },
    { text: "I like attending concerts, theaters, or art exhibits.", trait: "A" },
    { text: "I enjoy playing a musical instrument or composing music.", trait: "A" },
    { text: "I like writing stories, poems, or scripts.", trait: "A" },
    { text: "I appreciate beautiful and unique designs.", trait: "A" },
    { text: "I enjoy performing in front of an audience.", trait: "A" },
    { text: "I like working in unstructured, creative environments.", trait: "A" },
    { text: "I am interested in photography or filmmaking.", trait: "A" },
    { text: "I enjoy helping, teaching, or counseling others.", trait: "S" },
    { text: "I like doing volunteer work in my community.", "trait": "S" },
    { text: "I enjoy working in teams and collaborating.", "trait": "S" },
    { text: "I am good at resolving conflicts between people.", trait: "S" },
    { text: "I like listening to people's problems and giving advice.", trait: "S" },
    { text: "I enjoy leading group activities or discussions.", trait: "S" },
    { text: "I prefer a workplace focused on human connection.", trait: "S" },
    { text: "I like caring for sick or elderly people.", trait: "S" },
    { text: "I am interested in psychology and human behavior.", trait: "S" },
    { text: "I enjoy training or mentoring new employees.", trait: "S" },
    { text: "I like to lead teams or start my own business.", trait: "E" },
    { text: "I am good at persuading people or selling things.", trait: "E" },
    { text: "I enjoy negotiating deals or contracts.", trait: "E" },
    { text: "I like managing projects and making decisions.", trait: "E" },
    { text: "I am comfortable speaking to large groups or taking charge.", trait: "E" },
    { text: "I enjoy taking risks for potential financial gain.", trait: "E" },
    { text: "I like networking and meeting influential people.", trait: "E" },
    { text: "I am interested in marketing and promoting ideas.", trait: "E" },
    { text: "I enjoy directing the activities of an organization.", trait: "E" },
    { text: "I am motivated by status, power, or financial success.", trait: "E" },
    { text: "I prefer working with data, records, or files.", trait: "C" },
    { text: "I like to keep my work space organized.", trait: "C" },
    { text: "I enjoy working with spreadsheets and databases.", trait: "C" },
    { text: "I like following clear instructions and established procedures.", trait: "C" },
    { text: "I am good at organizing schedules and managing logistics.", trait: "C" },
    { text: "I enjoy proofreading documents for errors.", trait: "C" },
    { text: "I like doing accounting, bookkeeping, or financial tracking.", trait: "C" },
    { text: "I prefer a highly structured and predictable work environment.", trait: "C" },
    { text: "I enjoy sorting, filing, or categorizing information.", trait: "C" },
    { text: "I am detail-oriented and careful in my work.", trait: "C" }
];

// Shuffle
for (let i = new_questions.length - 1; i > 0; i--) {
    const j = Math.floor(Math.random() * (i + 1));
    [new_questions[i], new_questions[j]] = [new_questions[j], new_questions[i]];
}

const content = fs.readFileSync("c:/xampp/htdocs/riasec/app/Views/index.html", "utf-8");

const questions_str = "[\n" + new_questions.map(q => `                        { text: "${q.text.replace(/"/g, '\\"')}", trait: "${q.trait}" }`).join(",\n") + "\n                    ]";

const new_content = content.replace(/questions:\s*\[[\s\S]*?\]/, 'questions: ' + questions_str);

fs.writeFileSync("c:/xampp/htdocs/riasec/app/Views/index.html", new_content, "utf-8");
console.log("Updated!");

