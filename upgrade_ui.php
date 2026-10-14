<?php
$file = 'app/Views/assessment.html';
$html = file_get_contents($file);

// 1. Remove the Vue <transition> wrapper and replace it with a standard div with custom CSS class
// This guarantees the animation works natively via CSS without Vue transition bugs
$pattern_transition_start = '/<transition name="slide-fade" mode="out-in">\s*<div :key="currentQuestionIndex".*?>/s';
$html = preg_replace($pattern_transition_start, '<div :key="currentQuestionIndex" class="w-full question-card mb-8">', $html);

$pattern_transition_end = '/<\/div>\s*<\/transition>/s';
$html = preg_replace($pattern_transition_end, '</div>', $html);

// 2. Redesign the Rating Scale to use Interactive Emojis
$rating_pattern = '/<!-- Rating Scale -->.*?<\/div>\s*<\/div>/s';
$new_rating = '<!-- Rating Scale -->
                        <div class="mt-8 mb-4 max-w-2xl mx-auto w-full">
                            <div class="flex justify-center gap-3 sm:gap-6 px-2">
                                <button v-for="(emoji, index) in [\'😡\', \'☹️\', \'😐\', \'🙂\', \'😍\']" :key="index"
                                        @click="selectRating(index + 1)"
                                        class="group flex flex-col items-center justify-center w-16 h-20 sm:w-24 sm:h-28 rounded-3xl border-2 transition-all duration-300 focus:outline-none relative overflow-hidden"
                                        :class="selectedRating === (index + 1) ? \'border-emerald-500 bg-emerald-50 shadow-lg scale-110 z-10\' : \'border-gray-200 bg-white hover:border-emerald-300 hover:bg-emerald-50/50 hover:-translate-y-1\'">
                                    <span class="text-4xl sm:text-5xl mb-2 transition-transform duration-300" :class="selectedRating === (index + 1) ? \'scale-110\' : \'group-hover:scale-110\'">{{ emoji }}</span>
                                    <span class="text-[10px] sm:text-xs font-extrabold uppercase tracking-widest transition-colors" :class="selectedRating === (index + 1) ? \'text-emerald-700\' : \'text-gray-400 group-hover:text-emerald-600\'">
                                        {{ index === 0 ? \'NO\' : (index === 4 ? \'YES\' : \' \') }}
                                    </span>
                                </button>
                            </div>
                        </div>';
$html = preg_replace($rating_pattern, $new_rating, $html);

file_put_contents($file, $html);

// 3. Inject the unbreakable CSS into style.css
$css = "
/* Premium Animated Card */
@keyframes slideInRight {
    0% { transform: translateX(60px) scale(0.98); opacity: 0; }
    100% { transform: translateX(0) scale(1); opacity: 1; }
}

.question-card {
    background: #ffffff;
    border-radius: 2.5rem;
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.08), 0 0 0 1px rgba(0, 0, 0, 0.02);
    padding: 3rem;
    animation: slideInRight 0.35s cubic-bezier(0.2, 0.8, 0.2, 1) forwards;
}

@media (max-width: 640px) {
    .question-card {
        padding: 1.5rem;
        border-radius: 1.5rem;
    }
}
";
file_put_contents('style.css', $css, FILE_APPEND);

echo "Premium UI and native animation applied!";
?>
