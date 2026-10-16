const Vue = { createApp: (opts) => { try { opts.setup(); console.log('Setup ran ok'); } catch(e) { console.log('Setup error', e); } return { mount: () => {} }; }, ref: (val) => ({ value: val }), computed: (fn) => ({ get value() { return fn(); } }), onMounted: (fn) => { fn(); }, watch: () => {} }; const window = { location: { search: '?degree_id=5' } }; const URLSearchParams = class { constructor() {} get() { return '5'; } }; const localStorage = { getItem: () => null, setItem: () => {} }; const document = { querySelector: () => ({ style: {} }) };
const { createApp, ref, computed, onMounted, watch } = Vue;

    createApp({
        setup() {
            const isLoading = ref(true);
            const error = ref("");
            const degreeId = ref(null);
            const degreeTitle = ref("");
            const questions = ref([]);
            
            const quizStarted = ref(false);
            const quizFinished = ref(false);
            const reviewMode = ref(false);
            const showSubmitWarning = ref(false);
            
            const tempPreference = ref(null);
            const degreeQuizPreference = ref(null);
            
            const degreeQuizHistory = ref([]);
            const degreeQuizLatestResult = ref(null);
            const showHistory = ref(false);
            
            const globalQuestionIndex = ref(0);
            const userAnswersMap = ref({});
            const shuffledOptionsMap = ref({});

            onMounted(async () => {
                const urlParams = new URLSearchParams(window.location.search);
                const id = urlParams.get('degree_id');
                
                if (!id) {
                    error.value = "Invalid degree selected.";
                    isLoading.value = false;
                    return;
                }
                degreeId.value = id;
                
                
                // Load local storage
                try {
                    const hist = localStorage.getItem("degreeQuizHistory_" + id);
                    if (hist) degreeQuizHistory.value = JSON.parse(hist);
                    const latest = localStorage.getItem("degreeQuizLatestResult_" + id);
                    if (latest) degreeQuizLatestResult.value = JSON.parse(latest);
                    
                    const savedShuffles = localStorage.getItem("degreeQuizShuffles_" + id);
                    if (savedShuffles) {
                        shuffledOptionsMap.value = JSON.parse(savedShuffles);
                    }
                    const savedAnswers = localStorage.getItem("degreeQuizAnswers_" + id);
                    if (savedAnswers) {
                        userAnswersMap.value = JSON.parse(savedAnswers);
                    }
                    const savedPref = localStorage.getItem("degreeQuizPreference_" + id);
                    if (savedPref) {
                        degreeQuizPreference.value = savedPref;
                    }
                } catch(e) {}
                
                try {
                    const res = await fetch("api/get_course_questions?degree_id=" + id);
                    const data = await res.json();
                    if (data.success && data.questions) {
                        questions.value = data.questions;
                        degreeTitle.value = data.degree_title;
                        
                        // Pre-shuffle options if not loaded from localStorage
                        if (Object.keys(shuffledOptionsMap.value).length === 0) {
                            questions.value.forEach((q, idx) => {
                                let opts = [
                                    { content: q.options.A, originalLetter: 'A' },
                                    { content: q.options.B, originalLetter: 'B' },
                                    { content: q.options.C, originalLetter: 'C' },
                                    { content: q.options.D, originalLetter: 'D' }
                                ];
                                for (let i = opts.length - 1; i > 0; i--) {
                                    const j = Math.floor(Math.random() * (i + 1));
                                    [opts[i], opts[j]] = [opts[j], opts[i]];
                                }
                                const visualLetters = ['A', 'B', 'C', 'D'];
                                shuffledOptionsMap.value[idx] = opts.map((opt, i) => ({
                                    letter: visualLetters[i],
                                    content: opt.content,
                                    originalLetter: opt.originalLetter
                                }));
                            });
                        }
                    } else {
                        error.value = data.error || "Failed to load questions.";
                    }
                } catch (e) {
                    error.value = "A network error occurred. Please try again later.";
                }
                isLoading.value = false;
            });

            const startWithPreference = () => {
                degreeQuizPreference.value = tempPreference.value;
                globalQuestionIndex.value = 0;
            };

            const currentQuestion = computed(() => questions.value[globalQuestionIndex.value] || {});
            const shuffledOptions = computed(() => shuffledOptionsMap.value[globalQuestionIndex.value] || []);
            const currentAnswerState = computed(() => userAnswersMap.value[globalQuestionIndex.value] || {});

            const handleAnswerSelection = (letter) => {
                const isImm = degreeQuizPreference.value === 'immediate';
                if (isImm && currentAnswerState.value.locked) return; // Cannot change in immediate mode after locking

                userAnswersMap.value[globalQuestionIndex.value] = {
                    selectedLetter: letter,
                    skipped: false,
                    locked: isImm // Lock immediately if immediate mode
                };
            };

            const isOptionDisabled = computed(() => {
                if (degreeQuizPreference.value === 'immediate') {
                    return currentAnswerState.value.locked === true;
                }
                return false; // Can always click in 'after' mode
            });

            const getOptionClass = (letter) => {
                const state = currentAnswerState.value;
                const isSelected = state.selectedLetter === letter;
                
                if (degreeQuizPreference.value === 'immediate' && state.locked) {
                    if (letter === currentQuestion.value.correct) return 'correct border-emerald-500 shadow-md ring-2 ring-emerald-200';
                    if (isSelected) return 'wrong border-red-500 shadow-md ring-2 ring-red-200';
                    return 'opacity-50 grayscale';
                }
                
                return isSelected ? 'selected' : '';
            };

            const getLetterBadgeClass = (letter) => {
                const state = currentAnswerState.value;
                const isSelected = state.selectedLetter === letter;
                
                if (degreeQuizPreference.value === 'immediate' && state.locked) {
                    if (letter === currentQuestion.value.correct) return 'bg-emerald-600 text-white';
                    if (isSelected) return 'bg-red-600 text-white';
                    return 'bg-gray-100 text-gray-400';
                }
                
                return isSelected ? 'bg-emerald-600 text-white' : 'bg-gray-100 text-gray-500 group-hover:bg-blue-100 group-hover:text-blue-600';
            };

            const getOptionContent = (letter) => {
                const opt = shuffledOptions.value.find(o => o.originalLetter === letter);
                return opt ? opt.content : letter;
            };

            const getOptionContentForQ = (q, letter) => {
                if (!letter) return '';
                return q.options[letter];
            };

            // Navigation
            const previousQuestion = () => {
                if (globalQuestionIndex.value > 0) globalQuestionIndex.value--;
            };

            const skipQuestion = () => {
                userAnswersMap.value[globalQuestionIndex.value] = { skipped: true, selectedLetter: null, locked: false };
                nextQuestion();
            };

            const nextQuestion = () => {
                if (globalQuestionIndex.value < questions.value.length - 1) {
                    globalQuestionIndex.value++;
                } else {
                    // Reached end, check skips
                    if (skippedCount.value + remainingCount.value > 0) {
                        showSubmitWarning.value = true;
                    } else {
                        submitQuizFinal();
                    }
                }
            };

            const reviewSkipped = () => {
                showSubmitWarning.value = false;
                for (let i = 0; i < questions.value.length; i++) {
                    const ans = userAnswersMap.value[i];
                    if (!ans || ans.skipped || !ans.selectedLetter) {
                        globalQuestionIndex.value = i;
                        return;
                    }
                }
            };

            // Metrics
            const answeredCount = computed(() => Object.values(userAnswersMap.value).filter(a => a.selectedLetter && !a.skipped).length);
            const skippedCount = computed(() => Object.values(userAnswersMap.value).filter(a => a.skipped || (!a.skipped && !a.selectedLetter)).length);
            const remainingCount = computed(() => questions.value.length - Object.keys(userAnswersMap.value).length);
            const progressPercentage = computed(() => questions.value.length ? ((answeredCount.value + skippedCount.value) / questions.value.length) * 100 : 0);

            // Final Submit
            const totalScore = ref(0);
            const correctCount = ref(0);
            const incorrectCount = ref(0);
            const finalSkippedCount = ref(0);

            const submitQuizFinal = () => {
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
                let interp = "Level 1 � Beginner";
                if (pct >= 90) interp = "Level 4 � Advanced";
                else if (pct >= 75) interp = "Level 3 � Proficient";
                else if (pct >= 60) interp = "Level 2 � Developing";

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
                
                localStorage.setItem("degreeQuizLatestResult_" + degreeId.value, JSON.stringify(resObj));
                localStorage.setItem("degreeQuizHistory_" + degreeId.value, JSON.stringify(degreeQuizHistory.value));
                localStorage.setItem("degreeQuizAnswers_" + degreeId.value, JSON.stringify(userAnswersMap.value));
                localStorage.setItem("degreeQuizShuffles_" + degreeId.value, JSON.stringify(shuffledOptionsMap.value));
                localStorage.setItem("degreeQuizPreference_" + degreeId.value, degreeQuizPreference.value);

                if (typeof confetti === "function" && pct >= 50) {
                    confetti({ particleCount: 150, spread: 80, origin: { y: 0.5 } });
                }
            };

            const retakeQuiz = () => {
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
                        { content: q.options.A, originalLetter: 'A' },
                        { content: q.options.B, originalLetter: 'B' },
                        { content: q.options.C, originalLetter: 'C' },
                        { content: q.options.D, originalLetter: 'D' }
                    ];
                    for (let i = opts.length - 1; i > 0; i--) {
                        const j = Math.floor(Math.random() * (i + 1));
                        [opts[i], opts[j]] = [opts[j], opts[i]];
                    }
                    const visualLetters = ['A', 'B', 'C', 'D'];
                    shuffledOptionsMap.value[idx] = opts.map((opt, i) => ({
                        letter: visualLetters[i],
                        content: opt.content,
                        originalLetter: opt.originalLetter
                    }));
                });
                
                quizStarted.value = true;
            };
            
            const scorePercentage = computed(() => questions.value.length ? Math.round((totalScore.value / questions.value.length) * 100) : 0);
            const resultData = computed(() => {
                const pct = scorePercentage.value;
                if (pct >= 90) return { title: "Level 4 — Advanced", short: "Level 4", desc: "You demonstrate an advanced understanding of the concepts covered by this degree quiz. You performed strongly across the assessed topics.", color: { text: "text-emerald-600", bg: "bg-emerald-100" } };
                if (pct >= 75) return { title: "Level 3 — Proficient", short: "Level 3", desc: "You demonstrate a strong understanding of the concepts covered by this quiz. You are able to handle many questions involving understanding and application.", color: { text: "text-amber-600", bg: "bg-amber-100" } };
                if (pct >= 60) return { title: "Level 2 — Developing", short: "Level 2", desc: "You have a developing understanding of this degree. You understand many basic concepts but may need more practice with application and more difficult topics.", color: { text: "text-indigo-600", bg: "bg-indigo-100" } };
                return { title: "Level 1 — Beginner", short: "Level 1", desc: "You are still developing your foundational knowledge in this degree. Review the basic concepts and continue practicing to strengthen your understanding.", color: { text: "text-blue-600", bg: "bg-blue-100" } };
            });

            const isCorrectQ = (idx) => {
                const ans = userAnswersMap.value[idx];
                return ans && !ans.skipped && ans.selectedLetter === questions.value[idx].correct;
            };
            const isSkippedQ = (idx) => {
                const ans = userAnswersMap.value[idx];
                return !ans || ans.skipped || !ans.selectedLetter;
            };
            const shouldHideLayout = computed(() => {
                return quizStarted.value || reviewMode.value || (degreeQuizLatestResult.value !== null && !quizStarted.value);
            });

            watch(shouldHideLayout, (hide) => {
                const header = document.querySelector('header');
                const footer = document.querySelector('footer');
                if (hide) {
                    if (header) header.style.display = 'none';
                    if (footer) footer.style.display = 'none';
                } else {
                    if (header) header.style.display = '';
                    if (footer) footer.style.display = '';
                }
            }, { immediate: true });

            return {
                isLoading, error, degreeId, degreeTitle, questions,
                quizStarted, quizFinished, reviewMode, showSubmitWarning,
                tempPreference, degreeQuizPreference, startWithPreference,
                degreeQuizHistory, degreeQuizLatestResult, showHistory,
                globalQuestionIndex, currentQuestion, shuffledOptions, currentAnswerState,
                handleAnswerSelection, isOptionDisabled, getOptionClass, getLetterBadgeClass, getOptionContent,
                previousQuestion, skipQuestion, nextQuestion, reviewSkipped, submitQuizFinal, retakeQuiz,
                answeredCount, skippedCount, remainingCount, progressPercentage,
                totalScore, correctCount, incorrectCount, finalSkippedCount, scorePercentage,
                knowledgeLevelTitle: computed(() => resultData.value.title),
                knowledgeLevelShort: computed(() => resultData.value.short),
                knowledgeLevelDesc: computed(() => resultData.value.desc),
                resultColor: computed(() => resultData.value.color),
                getOptionContentForQ, isCorrectQ, isSkippedQ, userAnswersMap
            };
        }
    }).mount("#app");
