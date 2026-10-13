<?php
$file = 'app/Views/assessment.html';
$html = file_get_contents($file);

$start = strpos($html, '<script>');
$end = strpos($html, '</script>') + 9;

$new_script = '<script>
    const { createApp, ref, computed, watch } = Vue;

    createApp({
        setup() {
            const assessmentStarted = ref(false);
            const privacyAgreed = ref(false);
            const validationError = ref("");
            const showLengthSelection = ref(false);
            const isLoading = ref(false);
            const currentQuestionIndex = ref(0);
            const selectedRating = ref(null);
            const questions = ref([]);
            const answers = ref([]);

            const tryStart = () => {
                if(!privacyAgreed.value) {
                    validationError.value = "You must agree to the Data Privacy Consent before starting.";
                } else {
                    validationError.value = "";
                    showLengthSelection.value = true;
                }
            };

            watch(assessmentStarted, (started) => {
                const nav = document.querySelector("nav");
                const footer = document.querySelector("footer");
                if (started) {
                    if (nav) nav.style.display = "none";
                    if (footer) footer.style.display = "none";
                } else {
                    if (nav) nav.style.display = "";
                    if (footer) footer.style.display = "";
                }
            });

            const startTest = async (type) => {
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
            };

            const currentQuestion = computed(() => questions.value[currentQuestionIndex.value] || {text:""});

            const selectRating = (n) => {
                selectedRating.value = n;
                setTimeout(() => {
                    if (currentQuestionIndex.value < questions.value.length - 1) {
                        nextQuestion();
                    }
                }, 350);
            };

            const nextQuestion = () => {
                if (selectedRating.value !== null) {
                    answers.value[currentQuestionIndex.value] = selectedRating.value;
                    currentQuestionIndex.value++;
                    selectedRating.value = answers.value[currentQuestionIndex.value];
                }
            };

            const prevQuestion = () => {
                if (currentQuestionIndex.value > 0) {
                    answers.value[currentQuestionIndex.value] = selectedRating.value;
                    currentQuestionIndex.value--;
                    selectedRating.value = answers.value[currentQuestionIndex.value];
                }
            };

            const finishAssessment = async () => {
                if (selectedRating.value !== null) {
                    answers.value[currentQuestionIndex.value] = selectedRating.value;
                }

                const scores = { R: 0, I: 0, A: 0, S: 0, E: 0, C: 0 };
                answers.value.forEach((rating, index) => {
                    if (rating !== null && questions.value[index]) {
                        // If it is reverse coded, invert the score (1->5, 2->4, 4->2, 5->1)
                        let final_rating = rating;
                        if (questions.value[index].is_reverse_coded === 1) {
                            final_rating = 6 - rating;
                        }
                        scores[questions.value[index].trait] += final_rating;
                    }
                });

                const sortedTraits = Object.keys(scores).sort((a, b) => scores[b] - scores[a]);
                const holland_code = sortedTraits.slice(0, 3).join("");

                localStorage.setItem("talunton_assessment_scores", JSON.stringify({ scores, holland_code }));

                try {
                    const csrfMeta = document.querySelector("meta[name=\"csrf-token\"]");
                    const csrfToken = csrfMeta ? csrfMeta.content : "";
                    
                    const res = await fetch("api/save_assessment", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-Token": csrfToken
                        },
                        body: JSON.stringify({ scores, holland_code })
                    });
                    
                    const data = await res.json();
                    window.location.href = data.redirect || "results";
                    
                } catch (e) {
                    console.error("Backend save failed, but scores are saved locally.", e);
                    window.location.href = "results";
                }
            };

            return {
                assessmentStarted,
                privacyAgreed,
                validationError,
                showLengthSelection,
                isLoading,
                questions,
                answers,
                tryStart,
                startTest,
                currentQuestionIndex,
                currentQuestion,
                selectedRating,
                selectRating,
                nextQuestion,
                prevQuestion,
                finishAssessment
            };
        }
    }).mount("#app");
</script>';

$html = substr($html, 0, $start) . $new_script . substr($html, $end);
file_put_contents($file, $html);
echo "Injected full Vue logic perfectly!";
?>
