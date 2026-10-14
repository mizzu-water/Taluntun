<?php
$file = 'app/Views/assessment.html';
$html = file_get_contents($file);

// 1. Inject the category logic into Vue setup
$logic_injection = "
            const traitCategories = {
                'R': { name: 'Hands-on & Technical', emoji: '&#x1F527;', color: 'text-blue-700', bg: 'bg-blue-100 border border-blue-200' },
                'I': { name: 'Science & Analysis', emoji: '&#x1F52C;', color: 'text-indigo-700', bg: 'bg-indigo-100 border border-indigo-200' },
                'A': { name: 'Arts & Design', emoji: '&#x1F3A8;', color: 'text-fuchsia-700', bg: 'bg-fuchsia-100 border border-fuchsia-200' },
                'S': { name: 'People & Helping', emoji: '&#x1F91D;', color: 'text-rose-700', bg: 'bg-rose-100 border border-rose-200' },
                'E': { name: 'Business & Leadership', emoji: '&#x1F4BC;', color: 'text-amber-700', bg: 'bg-amber-100 border border-amber-200' },
                'C': { name: 'Organization & Details', emoji: '&#x1F4CA;', color: 'text-emerald-700', bg: 'bg-emerald-100 border border-emerald-200' }
            };

            const currentCategory = computed(() => {
                if (!currentQuestion.value || !currentQuestion.value.trait) return traitCategories['R'];
                return traitCategories[currentQuestion.value.trait] || traitCategories['R'];
            });
";
$html = str_replace('const currentQuestion = computed(() => questions.value[currentQuestionIndex.value] || {text:""});', 'const currentQuestion = computed(() => questions.value[currentQuestionIndex.value] || {text:""});' . "\n" . $logic_injection, $html);

// Inject currentCategory into return block
$html = str_replace('currentQuestion,', 'currentQuestion,' . "\n" . '                currentCategory,', $html);

// 2. Replace the old Progress Header with the new Thematic Header
$old_header = '<div class="text-sm font-bold text-emerald-600 tracking-widest uppercase mb-8 flex items-center justify-center gap-2">
                      <span class="w-12 h-px bg-emerald-300"></span>
                      <span>Question {{ currentQuestionIndex + 1 }} of {{ questions.length }}</span>
                      <span class="w-12 h-px bg-emerald-300"></span>
                  </div>';

$new_header = '
                  <div class="flex flex-col items-center justify-center mb-6">
                      <transition name="fade" mode="out-in">
                          <div :key="currentCategory.name" :class="[currentCategory.bg, currentCategory.color]" class="px-6 py-2 rounded-full text-xs sm:text-sm font-black tracking-widest uppercase mb-4 flex items-center gap-3 shadow-sm">
                              <span v-html="currentCategory.emoji" class="text-lg"></span>
                              {{ currentCategory.name }}
                          </div>
                      </transition>
                      <div class="text-xs font-bold text-gray-400 tracking-widest uppercase flex items-center justify-center gap-3">
                          <span class="w-12 h-px bg-gray-200"></span>
                          <span>Question {{ currentQuestionIndex + 1 }} of {{ questions.length }}</span>
                          <span class="w-12 h-px bg-gray-200"></span>
                      </div>
                  </div>
';

$html = str_replace($old_header, $new_header, $html);

file_put_contents($file, $html);
echo "Thematic chapters and UI injected!";
?>
