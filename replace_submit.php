<?php
$file = 'c:\xampp\htdocs\riasec\app\Views\course-quiz.html';
$content = file_get_contents($file);

$newContent = preg_replace('/const submitQuizFinal = \(\) => \{.*?if \(typeof confetti/s', 'const submitQuizFinal = () => {
                showSubmitWarning.value = false;
                quizStarted.value = false;
                quizFinished.value = false;
                reviewMode.value = false;
                
                let s = 0, c = 0, inc = 0, skp = 0;
                questions.value.forEach((q, idx) => {
                    const ans = userAnswersMap.value[idx];
                    if (!ans || ans.skipped || !ans.selectedLetter) {
                        skp++;
                    } else if (ans.selectedLetter === q.correct) {
                        c++; s++;
                    } else {
                        inc++;
                    }
                });
                
                totalScore.value = s;
                correctCount.value = c;
                incorrectCount.value = inc;
                finalSkippedCount.value = skp;

                const pct = questions.value.length ? Math.round((s / questions.value.length) * 100) : 0;
                let interp = "Level 1 — Beginner";
                if (pct >= 90) interp = "Level 4 — Advanced";
                else if (pct >= 75) interp = "Level 3 — Proficient";
                else if (pct >= 60) interp = "Level 2 — Developing";

                const resObj = {
                    score: s,
                    percentage: pct,
                    correct: c,
                    incorrect: inc,
                    skipped: skp,
                    interpretation: interp,
                    date: new Date().toLocaleDateString()
                };

                degreeQuizLatestResult.value = resObj;
                degreeQuizHistory.value.push(resObj);
                
                localStorage.setItem(degreeQuizLatestResult_, JSON.stringify(resObj));
                localStorage.setItem(degreeQuizHistory_, JSON.stringify(degreeQuizHistory.value));
                localStorage.setItem(degreeQuizAnswers_, JSON.stringify(userAnswersMap.value));
                localStorage.setItem(degreeQuizShuffles_, JSON.stringify(shuffledOptionsMap.value));
                localStorage.setItem(degreeQuizPreference_, degreeQuizPreference.value);

                if (typeof confetti', $content);

file_put_contents($file, $newContent);
echo "Replaced submitQuizFinal.\n";
