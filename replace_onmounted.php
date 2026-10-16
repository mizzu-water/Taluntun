<?php
$file = 'c:\xampp\htdocs\riasec\app\Views\course-quiz.html';
$content = file_get_contents($file);

// Replace onMounted block
$newContent = preg_replace('/(\/\/ Load local storage.*?else \{)/s', '
                // Load local storage
                try {
                    const hist = localStorage.getItem(degreeQuizHistory_);
                    if (hist) degreeQuizHistory.value = JSON.parse(hist);
                    const latest = localStorage.getItem(degreeQuizLatestResult_);
                    if (latest) degreeQuizLatestResult.value = JSON.parse(latest);
                    
                    const savedShuffles = localStorage.getItem(degreeQuizShuffles_);
                    if (savedShuffles) {
                        shuffledOptionsMap.value = JSON.parse(savedShuffles);
                    }
                    const savedAnswers = localStorage.getItem(degreeQuizAnswers_);
                    if (savedAnswers) {
                        userAnswersMap.value = JSON.parse(savedAnswers);
                    }
                    const savedPref = localStorage.getItem(degreeQuizPreference_);
                    if (savedPref) {
                        degreeQuizPreference.value = savedPref;
                    }
                } catch(e) {}
                
                try {
                    const res = await fetch(pi/get_course_questions?degree_id=);
                    const data = await res.json();
                    if (data.success && data.questions) {
                        questions.value = data.questions;
                        degreeTitle.value = data.degree_title;
                        
                        // Pre-shuffle options if not loaded from localStorage
                        if (Object.keys(shuffledOptionsMap.value).length === 0) {
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
                        }
                    } else {', $content);

file_put_contents($file, $newContent);
echo "Replaced onMounted.\n";
