<?php
$file = 'app/Views/assessment.html';
$html = file_get_contents($file);

// 1. Inject Canvas Confetti CDN before the final Vue script
$confetti_script = '<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>' . "\n" . '<script>';
$html = str_replace('<script>', $confetti_script, $html); // This replaces the first <script> which is the Vue one at the bottom

// 2. Inject Milestone Overlay HTML
$overlay_html = '
<div v-if="showMilestone" class="fixed inset-0 z-50 flex items-center justify-center bg-white/90 backdrop-blur-sm transition-all">
    <div class="text-center p-8 bg-white rounded-3xl shadow-2xl border-2 border-emerald-100 max-w-sm" style="animation: bounce 1s">
        <div class="text-7xl mb-6 drop-shadow-md">{{ milestoneEmoji }}</div>
        <h3 class="text-3xl font-serif-heading font-bold text-gray-900 mb-3">{{ milestoneTitle }}</h3>
        <p class="text-gray-600 mb-8 text-lg">{{ milestoneMessage }}</p>
        <button @click="resumeAfterMilestone" class="bg-emerald-600 text-white px-10 py-4 rounded-full font-bold text-xl shadow-xl hover:bg-emerald-700 hover:-translate-y-1 transition-all duration-300 w-full">
            Keep Going!
        </button>
    </div>
</div>
';
$html = str_replace('<div v-else-if="assessmentStarted">', '<div v-else-if="assessmentStarted">' . $overlay_html, $html);

// 3. Inject Vue setup variables
$vue_vars = '
            const showMilestone = ref(false);
            const milestoneTitle = ref("");
            const milestoneMessage = ref("");
            const milestoneEmoji = ref("");

            const resumeAfterMilestone = () => {
                showMilestone.value = false;
                selectedRating.value = answers.value[currentQuestionIndex.value];
            };
';
$html = str_replace('const privacyAgreed = ref(false);', 'const privacyAgreed = ref(false);' . $vue_vars, $html);

// 4. Update nextQuestion logic
$old_next_question = '
            const nextQuestion = () => {
                if (selectedRating.value !== null) {
                    answers.value[currentQuestionIndex.value] = selectedRating.value;
                    currentQuestionIndex.value++;
                    selectedRating.value = answers.value[currentQuestionIndex.value];
                }
            };';

$new_next_question = '
            const nextQuestion = () => {
                if (selectedRating.value !== null) {
                    answers.value[currentQuestionIndex.value] = selectedRating.value;
                    currentQuestionIndex.value++;
                    
                    let qNum = currentQuestionIndex.value;
                    let total = questions.value.length;
                    
                    // Trigger milestones at 25%, 50%, 75%
                    if (qNum > 0 && total > 0 && qNum % Math.floor(total / 4) === 0 && qNum !== total) {
                        let percent = Math.round((qNum / total) * 100);
                        if (percent === 25) {
                            milestoneTitle.value = "Great Start!";
                            milestoneMessage.value = "You\'re 25% done. Keep that momentum going!";
                            milestoneEmoji.value = "🚀";
                        } else if (percent === 50) {
                            milestoneTitle.value = "Halfway There!";
                            milestoneMessage.value = "You\'re crushing it. 50% complete!";
                            milestoneEmoji.value = "🔥";
                        } else if (percent === 75) {
                            milestoneTitle.value = "Almost Done!";
                            milestoneMessage.value = "Just the final stretch left. You got this!";
                            milestoneEmoji.value = "⭐";
                        }
                        
                        showMilestone.value = true;
                        
                        // Fire Confetti!
                        if (typeof confetti === "function") {
                            confetti({
                                particleCount: 150,
                                spread: 70,
                                origin: { y: 0.6 },
                                colors: ["#059669", "#d97706", "#2563eb", "#e11d48"]
                            });
                        }
                    } else {
                        selectedRating.value = answers.value[currentQuestionIndex.value];
                    }
                }
            };';
$html = str_replace($old_next_question, $new_next_question, $html);

// 5. Update Vue return block
$old_return = 'return {
                assessmentStarted,';
$new_return = 'return {
                showMilestone,
                milestoneTitle,
                milestoneMessage,
                milestoneEmoji,
                resumeAfterMilestone,
                assessmentStarted,';
$html = str_replace($old_return, $new_return, $html);

file_put_contents($file, $html);
echo "Gamification successfully added!";
?>
