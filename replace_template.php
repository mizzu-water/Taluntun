<?php
$file = 'c:\xampp\htdocs\riasec\app\Views\course-quiz.html';
$content = file_get_contents($file);

// Add Review Answers and Back to Degree Programs inside Quiz Completed block
$replacement1 = '
                <div v-if="degreeQuizLatestResult" class="mb-10 bg-gray-50 p-6 rounded-2xl border border-gray-200 text-left max-w-2xl mx-auto">
                    <h3 class="text-xl font-bold text-gray-800 mb-4 border-b pb-2">Quiz Completed</h3>
                    <div class="grid grid-cols-2 gap-4 text-gray-700">
                        <div><strong>Previous Score:</strong> {{ degreeQuizLatestResult.score }} / {{ questions.length }}</div>
                        <div><strong>Previous Result:</strong> {{ degreeQuizLatestResult.percentage }}% ({{ degreeQuizLatestResult.interpretation }})</div>
                        <div><strong>Date Taken:</strong> {{ degreeQuizLatestResult.date }}</div>
                        <div><strong>Correct Answers:</strong> {{ degreeQuizLatestResult.correct }}</div>
                        <div><strong>Skipped Questions:</strong> {{ degreeQuizLatestResult.skipped }}</div>
                    </div>
                    
                    <div class="mt-6 pt-4 border-t border-gray-200 flex flex-col sm:flex-row gap-4 items-center justify-center">
                        <button @click="reviewMode = true" class="w-full sm:w-auto bg-blue-100 text-blue-800 px-6 py-3 rounded-full font-bold hover:bg-blue-200 transition shadow-sm">
                            Review Answers
                        </button>
                        <button @click="quizStarted = true" class="w-full sm:w-auto bg-emerald-100 text-emerald-800 px-6 py-3 rounded-full font-bold hover:bg-emerald-200 transition shadow-sm">
                            Retake Quiz
                        </button>
                        <a href="degrees" class="w-full sm:w-auto bg-gray-100 text-gray-800 px-6 py-3 rounded-full font-bold hover:bg-gray-200 transition shadow-sm text-center">
                            Back to Degree Programs
                        </a>
                    </div>
                    
                    <div class="mt-6 flex justify-center">
                        <button @click="showHistory = !showHistory" class="text-blue-600 font-bold hover:underline text-sm">
                            {{ showHistory ? \'Hide Previous Attempts\' : \'View Previous Attempts\' }}
                        </button>
                    </div>';
$content = preg_replace('/<div v-if="degreeQuizLatestResult".*?<\/button>\s*<\/div>/s', $replacement1, $content, 1);

// Remove the bottom "Start Quiz / Retake Quiz / Back to Degree Programs" buttons from the Start Screen since we moved them if completed
$content = preg_replace('/<div class="flex flex-col sm:flex-row items-center justify-center gap-4 mt-4">.*?<\/a>\s*<\/div>/s', 
    '<div class="flex flex-col sm:flex-row items-center justify-center gap-4 mt-4" v-if="!degreeQuizLatestResult">
        <button @click="quizStarted = true" class="bg-[#0e3223] text-white px-12 py-4 rounded-full font-bold text-xl transition-all shadow-xl hover:bg-black hover:-translate-y-1">
            Start Quiz
        </button>
        <a href="degrees" class="bg-gray-100 text-gray-800 px-8 py-4 rounded-full font-bold text-lg hover:bg-gray-200 transition shadow flex items-center justify-center gap-2">
            <span>&larr;</span> Back to Degree Programs
        </a>
    </div>', $content, 1);

// Remove the Results Screen
$content = preg_replace('/<!-- Results Screen -->.*?<!-- Review Answers Screen -->/s', '<!-- Review Answers Screen -->', $content);

file_put_contents($file, $content);
echo "Completed template replacements.\n";
