const fs = require('fs');
const updateJs = fs.readFileSync('update.js', 'utf8');
const match = updateJs.match(/let new_questions = \[([\s\S]*?)\];/);
if (!match) {
    console.log("Could not find questions in update.js");
    process.exit(1);
}
const questionsStr = match[0];

const vueScript = 
<script>
    const { createApp, ref, computed } = Vue;

    createApp({
        setup() {
            const assessmentStarted = ref(false);
            const currentQuestionIndex = ref(0);
            const selectedRating = ref(null);
            
            \);
            
            // Shuffle
            for (let i = questions.value.length - 1; i > 0; i--) {
                const j = Math.floor(Math.random() * (i + 1));
                const temp = questions.value[i];
                questions.value[i] = questions.value[j];
                questions.value[j] = temp;
            }

            const currentQuestion = computed(() => questions.value[currentQuestionIndex.value]);
            const answers = ref(new Array(questions.value.length).fill(null));

            const selectRating = (n) => {
                selectedRating.value = n;
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
                    if (rating !== null) {
                        scores[questions.value[index].trait] += rating;
                    }
                });

                try {
                    const csrfMeta = document.querySelector('meta[name="csrf-token"]');
                    const csrfToken = csrfMeta ? csrfMeta.content : '';
                    
                    const res = await fetch('api/save_assessment', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-Token': csrfToken
                        },
                        body: JSON.stringify({ scores })
                    });
                    
                    const data = await res.json();
                    if (data.success || data.redirect) {
                        window.location.href = data.redirect || 'results';
                    } else {
                        alert(data.message || 'Failed to save results.');
                    }
                } catch (e) {
                    console.error(e);
                    alert('Network error while saving results.');
                }
            };

            return {
                assessmentStarted,
                currentQuestionIndex,
                questions,
                currentQuestion,
                selectedRating,
                selectRating,
                nextQuestion,
                prevQuestion,
                finishAssessment
            };
        }
    }).mount('#app');
</script>
;

fs.appendFileSync('app/Views/assessment.html', vueScript);
console.log("Injected Vue script into assessment.html!");
