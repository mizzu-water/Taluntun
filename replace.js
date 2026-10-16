const fs = require('fs');
let content = fs.readFileSync('app/Views/course-quiz.html', 'utf8');

content = content.split('<a href="degrees" class="bg-gray-100 text-gray-800 px-6 py-3 rounded-full font-bold text-base w-full sm:w-auto hover:bg-gray-200 transition shadow flex items-center justify-center gap-2">').join('<a :href="\'degree-profile?id=\' + degreeId" class="bg-gray-100 text-gray-800 px-5 py-2 rounded-full font-bold text-sm w-full sm:w-auto hover:bg-gray-200 transition shadow flex items-center justify-center gap-2">');
content = content.split('<span>&larr;</span> Back to Degree Programs').join('<span>&larr;</span> Back to Degree Details');

content = content.split('<button @click="retakeQuiz" class="bg-[#0e3223] text-white px-6 py-3 rounded-full font-bold text-base w-full sm:w-auto transition-all shadow-xl hover:bg-black hover:-translate-y-1">').join('<button @click="retakeQuiz" class="bg-[#0e3223] text-white px-5 py-2 rounded-full font-bold text-sm w-full sm:w-auto transition-all shadow-xl hover:bg-black hover:-translate-y-1">');

content = content.split('<button @click="retakeQuiz" class="w-full sm:w-auto bg-[#0e3223] text-white px-6 py-3 rounded-full font-bold hover:bg-black transition shadow-sm">').join('<button @click="retakeQuiz" class="w-full sm:w-auto bg-[#0e3223] text-white px-5 py-2 rounded-full font-bold text-sm hover:bg-black transition shadow-sm">');

content = content.split('<a href="degrees" class="w-full sm:w-auto bg-gray-100 text-gray-800 px-6 py-3 rounded-full font-bold hover:bg-gray-200 transition shadow-sm text-center">').join('<a :href="\'degree-profile?id=\' + degreeId" class="w-full sm:w-auto bg-gray-100 text-gray-800 px-5 py-2 rounded-full font-bold text-sm hover:bg-gray-200 transition shadow-sm text-center flex items-center justify-center">');

content = content.replace(/Back to Degree Programs/g, 'Back to Degree Details');

fs.writeFileSync('app/Views/course-quiz.html', content, 'utf8');
console.log('Done');
