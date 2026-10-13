<?php
$file = 'app/Views/assessment.html';
$content = file_get_contents($file);

// Find the startTest function
$pattern = '/const startTest = async \(type\) => \{.*?\isLoading\.value = false;\s*\};/s';

$replacement = "const startTest = async (type) => {
                isLoading.value = true;
                try {
                    const res = await fetch('api/get_questions?type=' + type);
                    const data = await res.json();
                    if (data.success && data.questions) {
                        let fetched = data.questions;
                        for (let i = fetched.length - 1; i > 0; i--) {
                            const j = Math.floor(Math.random() * (i + 1));
                            const temp = fetched[i];
                            fetched[i] = fetched[j];
                            fetched[j] = temp;
                        }
                        questions.value = fetched;
                        answers.value = new Array(fetched.length).fill(null);
                        showLengthSelection.value = false;
                        assessmentStarted.value = true;
                    }
                } catch (e) {
                    console.error('Failed to load questions:', e);
                    alert('Failed to load questions. Please try again.');
                }
                isLoading.value = false;
            };";

$content = preg_replace($pattern, $replacement, $content);
file_put_contents($file, $content);
echo "Fixed JS syntax!";
?>
