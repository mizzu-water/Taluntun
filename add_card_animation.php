<?php
$file = 'app/Views/assessment.html';
$html = file_get_contents($file);

// 1. First, fix the broken Navigation block
$nav_pattern = '/<!-- Navigation -->.*?<\/div>\s*<\/div>\s*<\/div>\s*<\/main>/s';
$correct_nav = '<!-- Navigation -->
                  <div class="flex items-center justify-between border-t border-gray-200 pt-8 mt-4 max-w-3xl mx-auto w-full px-4">
                      <button @click="prevQuestion" :disabled="currentQuestionIndex === 0" class="text-gray-500 font-bold text-sm hover:text-gray-900 transition flex items-center gap-2 disabled:opacity-30 disabled:cursor-not-allowed">
                          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                          Previous
                      </button>
                      
                      <button @click="pauseTest" :disabled="isSaving" class="text-emerald-600 font-bold text-sm hover:bg-emerald-50 px-4 py-2 rounded-full transition flex items-center gap-2">
                          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                          {{ isSaving ? "Saving..." : "Save & Pause" }}
                      </button>

                      <button v-if="currentQuestionIndex < questions.length - 1" @click="nextQuestion" :disabled="selectedRating === null" class="bg-[#0e3223] hover:bg-black text-white px-8 py-3 rounded-full font-bold text-sm transition shadow flex items-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed">
                          Next Question
                          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                      </button>
                      
                      <button v-else @click="finishAssessment" :disabled="selectedRating === null" class="bg-amber-500 hover:bg-amber-600 text-white px-8 py-3 rounded-full font-bold text-sm transition shadow flex items-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed">
                          Finish Test
                          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                      </button>
                  </div>
            </div>
        </div>
    </main>
';
$html = preg_replace($nav_pattern, $correct_nav, $html);

// 2. Wrap Question + Rating in the animated card
// We need to find the start of the Question text area and end of Rating scale area.
$card_start = '<div class="min-h-[180px] flex items-center justify-center">';
$card_end = '<!-- Navigation -->';

$pattern = '/<div class="min-h-\[180px\] flex items-center justify-center">.*?<!-- Navigation -->/s';

$animated_card_html = '
                <!-- Animated Card Wrapper -->
                <transition name="slide-fade" mode="out-in">
                    <div :key="currentQuestionIndex" class="w-full">
                        <div class="min-h-[180px] flex items-center justify-center">
                            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-serif-heading font-bold text-gray-900 leading-tight px-4">
                                "{{ currentQuestion.text }}"
                            </h1>
                        </div>
                        
                        <p class="text-center text-gray-500 text-sm mb-10 mt-2">
                            Answer based on what you genuinely enjoy doing, not what you think you <i>should</i> do.
                        </p>

                        <!-- Rating Scale -->
                        <div class="mb-16 max-w-2xl mx-auto w-full">
                            <div class="flex justify-between text-xs font-bold text-gray-400 uppercase tracking-wider mb-6 px-2">
                                <span>Strongly Disagree</span>
                                <span class="text-emerald-700">Strongly Agree</span>
                            </div>
                            
                            <div class="flex justify-between items-center gap-2 sm:gap-4 relative px-4">
                                <div class="absolute top-1/2 left-4 right-4 h-1 bg-gray-200 -z-10 -translate-y-1/2 rounded"></div>
                                
                                <button v-for="n in 5" :key="n"
                                        @click="selectRating(n)"
                                        class="rating-btn w-14 h-14 sm:w-20 sm:h-20 rounded-full bg-white border-2 border-gray-300 flex items-center justify-center text-2xl font-bold text-gray-600 transition-all duration-200 hover:border-emerald-400 focus:outline-none"
                                        :class="{ \'selected\': selectedRating === n, \'scale-90 border-emerald-500 bg-emerald-50\': selectedRating === n }">
                                    {{ n }}
                                </button>
                            </div>
                        </div>
                    </div>
                </transition>

                <!-- Navigation -->';

$html = preg_replace($pattern, $animated_card_html, $html);

// 3. Inject CSS for slide-fade animation
$css_injection = '<style>
    /* Snappy Card Slide Animation */
    .slide-fade-enter-active {
        transition: all 0.25s cubic-bezier(0.25, 0.8, 0.25, 1);
    }
    .slide-fade-leave-active {
        transition: all 0.2s cubic-bezier(0.5, 0, 0.5, 1);
    }
    .slide-fade-enter-from {
        transform: translateX(40px);
        opacity: 0;
    }
    .slide-fade-leave-to {
        transform: translateX(-40px);
        opacity: 0;
    }
</style>
</head>';

$html = str_replace('</head>', $css_injection, $html);

file_put_contents($file, $html);
echo "Card animation successfully added and Nav fixed!";
?>
