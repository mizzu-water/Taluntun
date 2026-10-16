<?php
$file = 'c:\xampp\htdocs\riasec\app\Views\course-quiz.html';
$content = file_get_contents($file);

$content = preg_replace('/const retakeQuiz = \(\) => \{.*?\};\s*const scorePercentage/s', 'const retakeQuiz = () => {
                quizFinished.value = false;
                reviewMode.value = false;
                showSubmitWarning.value = false;
                degreeQuizPreference.value = null; // Re-select preference
                tempPreference.value = null;
                globalQuestionIndex.value = 0;
                userAnswersMap.value = {};
                shuffledOptionsMap.value = {};
                
                questions.value.forEach((q, idx) => {
                    let opts = [
                        { content: q.options.A, originalLetter: \'A\' },
                        { content: q.options.B, originalLetter: \'B\' },
                        { content: q.options.C, originalLetter: \'C\' },
                        { content: q.options.D, originalLetter: \'D\' }
                    ];
                    for (let i = opts.length - 1; i > 0; i--) {
                        const j = Math.floor(Math.random() * (i + 1));
                        [opts[i], opts[j]] = [opts[j], opts[i]];
                    }
                    const visualLetters = [\'A\', \'B\', \'C\', \'D\'];
                    shuffledOptionsMap.value[idx] = opts.map((opt, i) => ({
                        letter: visualLetters[i],
                        content: opt.content,
                        originalLetter: opt.originalLetter
                    }));
                });
                
                quizStarted.value = true;
            };
            
            const scorePercentage', $content);

// And update the buttons to call retakeQuiz instead of quizStarted = true
$content = str_replace('<button @click="quizStarted = true" class="w-full sm:w-auto bg-emerald-100', '<button @click="retakeQuiz" class="w-full sm:w-auto bg-emerald-100', $content);
$content = str_replace('<button @click="quizStarted = true" class="bg-[#0e3223]', '<button @click="retakeQuiz" class="bg-[#0e3223]', $content);

file_put_contents($file, $content);
echo "Updated retakeQuiz.\n";
