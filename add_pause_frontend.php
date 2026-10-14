<?php
$file = 'app/Views/assessment.html';
$html = file_get_contents($file);

// 1. Inject the Resume Banner into the Length Selection Screen
$banner_html = '
        <div v-if="hasProgress" class="mb-8 p-6 bg-emerald-50 rounded-2xl border-2 border-emerald-200 flex flex-col sm:flex-row justify-between items-center gap-4">
            <div class="text-left">
                <h3 class="font-bold text-emerald-900 text-xl mb-1 flex items-center gap-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                    Resume Assessment
                </h3>
                <p class="text-emerald-700 text-sm">You paused a {{ savedTestType === "extended" ? "120-Question" : "60-Question" }} test at Question {{ savedQuestionIndex + 1 }}.</p>
            </div>
            <div class="flex items-center gap-3 w-full sm:w-auto">
                <button @click="discardProgress" class="text-emerald-700 hover:text-emerald-900 hover:bg-emerald-100 font-bold text-sm px-4 py-2 rounded-full transition-all w-full sm:w-auto">Start Over</button>
                <button @click="resumeTest" class="bg-emerald-600 text-white font-bold px-8 py-3 rounded-full hover:bg-emerald-700 shadow-md hover:shadow-lg transition-all w-full sm:w-auto flex-shrink-0">Resume Test</button>
            </div>
        </div>
';
$html = str_replace('<div class="grid md:grid-cols-2 gap-6 max-w-2xl mx-auto mb-8">', $banner_html . '<div v-if="!hasProgress" class="grid md:grid-cols-2 gap-6 max-w-2xl mx-auto mb-8">', $html);


// 2. Inject the Save & Pause button in the footer navigation
$pause_btn_html = '
                      <button @click="pauseTest" :disabled="isSaving" class="text-emerald-600 font-bold text-sm hover:bg-emerald-50 px-4 py-2 rounded-full transition flex items-center gap-2">
                          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                          {{ isSaving ? "Saving..." : "Save & Pause" }}
                      </button>
';
$html = str_replace('<!-- Navigation -->
                  <div class="flex items-center justify-between border-t border-gray-200 pt-8 mt-4 max-w-3xl mx-auto w-full px-4">', '<!-- Navigation -->
                  <div class="flex items-center justify-between border-t border-gray-200 pt-8 mt-4 max-w-3xl mx-auto w-full px-4">' . "\n" . $pause_btn_html, $html);

// 3. Inject Vue logic
$vue_logic = '
            const hasProgress = ref(false);
            const savedTestType = ref("");
            const savedQuestionIndex = ref(0);
            const savedAnswers = ref([]);
            const isSaving = ref(false);
            const activeTestType = ref("standard");

            // Check progress on mount
            Vue.onMounted(async () => {
                try {
                    const res = await fetch("api/check_progress");
                    const data = await res.json();
                    if (data.success && data.has_progress) {
                        hasProgress.value = true;
                        savedTestType.value = data.progress.test_type_str;
                        savedQuestionIndex.value = data.progress.current_question_index;
                        savedAnswers.value = data.progress.answers;
                    }
                } catch(e) {}
            });

            const discardProgress = () => {
                hasProgress.value = false;
                savedAnswers.value = [];
            };

            const resumeTest = () => {
                activeTestType.value = savedTestType.value;
                answers.value = savedAnswers.value;
                currentQuestionIndex.value = savedQuestionIndex.value;
                
                // We still need to fetch the questions
                startTest(activeTestType.value, true);
            };

            const pauseTest = async () => {
                isSaving.value = true;
                try {
                    const csrfMeta = document.querySelector("meta[name=\"csrf-token\"]");
                    const res = await fetch("api/pause_assessment", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-Token": csrfMeta ? csrfMeta.content : ""
                        },
                        body: JSON.stringify({
                            test_type: activeTestType.value,
                            current_question_index: currentQuestionIndex.value,
                            answers: answers.value
                        })
                    });
                    const data = await res.json();
                    if(data.success) {
                        alert("Progress saved successfully! You can safely close this page.");
                        window.location.href = "home";
                    } else {
                        alert("Error saving: " + data.error);
                    }
                } catch(e) {
                    alert("Failed to save progress.");
                }
                isSaving.value = false;
            };
';

// We need to modify startTest to support resuming
$start_test_original = 'const startTest = async (type) => {
                isLoading.value = true;
                try {
                    const res = await fetch("api/get_questions?type=" + type);
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
                    console.error("Failed to load questions:", e);
                    alert("Failed to load questions. Please try again.");
                }
                isLoading.value = false;
            };';

$start_test_new = 'const startTest = async (type, isResuming = false) => {
                isLoading.value = true;
                activeTestType.value = type;
                try {
                    const res = await fetch("api/get_questions?type=" + type);
                    const data = await res.json();
                    if (data.success && data.questions) {
                        let fetched = data.questions;
                        
                        // IMPORTANT: If we shuffle on resume, the saved answers won\'t align with the questions! 
                        // So for a robust Save/Resume, we MUST NOT shuffle, OR we must save the shuffled question order in the DB.
                        // Since we didn\'t save the order, we will NOT shuffle the test at all if we are supporting Save/Resume.
                        // (Or we just use the original order).
                        questions.value = fetched;
                        
                        if(!isResuming) {
                            answers.value = new Array(fetched.length).fill(null);
                            currentQuestionIndex.value = 0;
                        }
                        
                        showLengthSelection.value = false;
                        assessmentStarted.value = true;
                    }
                } catch (e) {
                    console.error("Failed to load questions:", e);
                    alert("Failed to load questions. Please try again.");
                }
                isLoading.value = false;
            };';

$html = str_replace('const privacyAgreed = ref(false);', 'const privacyAgreed = ref(false);' . $vue_logic, $html);
$html = str_replace($start_test_original, $start_test_new, $html);

// Inject exports
$old_return = 'return {
                showMilestone,';
$new_return = 'return {
                hasProgress,
                savedTestType,
                savedQuestionIndex,
                isSaving,
                discardProgress,
                resumeTest,
                pauseTest,
                showMilestone,';
$html = str_replace($old_return, $new_return, $html);

file_put_contents($file, $html);
echo "Frontend pause logic added!";
?>
