<?php
$file = 'app/Views/assessment.html';
$html = file_get_contents($file);

// 1. Clean up the horrific navigation block duplication
// I will just use regex to wipe everything between "<!-- Navigation -->" and "</main>" and rebuild it cleanly.
$nav_pattern = '/<!-- Navigation -->.*?(?=<\/div>\s*<\/div>\s*<\/main>)/s';

$clean_nav = '<!-- Navigation -->
<div class="flex items-center justify-between border-t border-gray-200 pt-8 mt-4 max-w-3xl mx-auto w-full px-4">
    <button @click="prevQuestion" :disabled="currentQuestionIndex === 0" class="text-gray-500 font-bold text-sm hover:text-gray-900 transition flex items-center gap-2 disabled:opacity-30 disabled:cursor-not-allowed w-32">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        Previous
    </button>
    
    <button @click="pauseTest" :disabled="isSaving" class="text-emerald-600 font-bold text-sm hover:bg-emerald-50 px-4 py-2 rounded-full transition flex items-center gap-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
        {{ isSaving ? "Saving..." : "Save & Pause" }}
    </button>

    <div class="w-32 flex justify-end">
        <button v-if="currentQuestionIndex < questions.length - 1" @click="nextQuestion" :disabled="selectedRating === null" class="bg-[#0e3223] hover:bg-black text-white px-6 py-3 rounded-full font-bold text-sm transition shadow flex items-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed">
            Next
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
        </button>
        
        <button v-else @click="finishAssessment" :disabled="selectedRating === null" class="bg-amber-500 hover:bg-amber-600 text-white px-6 py-3 rounded-full font-bold text-sm transition shadow flex items-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed whitespace-nowrap">
            Finish
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
        </button>
    </div>
</div>
';

$html = preg_replace($nav_pattern, $clean_nav, $html);


// 2. Add the CSS directly to the top of assessment.html
$css_block = '<style>
    /* Snappy Card Slide Animation */
    .slide-fade-enter-active {
        transition: all 0.25s cubic-bezier(0.25, 0.8, 0.25, 1);
    }
    .slide-fade-leave-active {
        transition: all 0.2s cubic-bezier(0.5, 0, 0.5, 1);
    }
    .slide-fade-enter-from {
        transform: translateX(60px);
        opacity: 0;
    }
    .slide-fade-leave-to {
        transform: translateX(-60px);
        opacity: 0;
    }
</style>
';

// Ensure we don't add it twice
if (strpos($html, '.slide-fade-enter-active') === false) {
    $html = $css_block . $html;
}

file_put_contents($file, $html);
echo "Navigation cleaned up and CSS injected successfully!";
?>
