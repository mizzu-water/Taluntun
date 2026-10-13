import re

with open('app/Views/assessment.html', 'r', encoding='utf-8') as f:
    html = f.read()

# 1. Update first v-if
html = html.replace('<div v-if="!assessmentStarted"', '<div v-if="!assessmentStarted && !showLengthSelection"')

# 2. Add Privacy Checkbox and Update Start Button
old_button = """        <button @click="assessmentStarted = true" class="bg-[#0e3223] hover:bg-black text-white px-12 py-4 rounded-full font-bold text-xl transition-all duration-300 shadow-xl hover:shadow-2xl hover:-translate-y-1 inline-flex items-center gap-3">
            Start Assessment
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
        </button>"""

new_button = """        <div class="mb-8 text-left bg-gray-50 p-4 rounded-xl border border-gray-200">
            <label class="flex items-start gap-3 cursor-pointer">
                <input type="checkbox" v-model="privacyAgreed" class="mt-1 w-5 h-5 text-emerald-600 rounded border-gray-300 focus:ring-emerald-500">
                <span class="text-sm text-gray-700">
                    <strong>Data Privacy Consent:</strong> I agree to allow Talunton Cavite to collect and process my assessment responses for the purpose of career profiling. I understand my data will be handled securely.
                </span>
            </label>
            <p v-if="validationError" class="text-red-500 text-sm mt-2 font-bold">{{ validationError }}</p>
        </div>
        
        <button @click="tryStart" :class="{'opacity-50': !privacyAgreed, 'hover:bg-black hover:-translate-y-1 hover:shadow-2xl': privacyAgreed}" class="bg-[#0e3223] text-white px-12 py-4 rounded-full font-bold text-xl transition-all duration-300 shadow-xl inline-flex items-center gap-3">
            Start Assessment
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
        </button>"""
html = html.replace(old_button, new_button)

# 3. Inject Length Selection Screen
selection_screen = """
<!-- Length Selection Screen -->
<div v-if="showLengthSelection && !assessmentStarted" class="max-w-3xl mx-auto py-16 px-8 md:px-16 bg-white rounded-[2rem] shadow-xl border border-gray-100 text-center mt-12 mb-24 relative overflow-hidden">
    <div class="relative z-10">
        <h2 class="text-4xl md:text-5xl font-serif-heading font-bold text-gray-900 mb-6">Choose Your Assessment</h2>
        <p class="text-gray-500 text-lg mb-10 max-w-xl mx-auto leading-relaxed">
            Select the assessment length that best fits your schedule and goals.
        </p>
        
        <div class="grid md:grid-cols-2 gap-6 max-w-2xl mx-auto mb-8">
            <button @click="startTest('standard')" :disabled="isLoading" class="p-8 border-2 border-emerald-100 hover:border-emerald-500 rounded-2xl text-left transition-all hover:shadow-lg group bg-white relative overflow-hidden">
                <div class="absolute top-0 right-0 w-24 h-24 bg-emerald-50 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
                <div class="relative z-10">
                    <h3 class="text-2xl font-bold text-gray-900 mb-2 group-hover:text-emerald-700">Standard Test</h3>
                    <p class="text-emerald-600 font-bold mb-4">60 Q's • ~5 Minutes</p>
                    <p class="text-gray-500 text-sm">A quick, highly accurate overview of your career personality.</p>
                </div>
            </button>
            
            <button @click="startTest('extended')" :disabled="isLoading" class="p-8 border-2 border-amber-100 hover:border-amber-500 rounded-2xl text-left transition-all hover:shadow-lg group bg-white relative overflow-hidden">
                <div class="absolute top-0 right-0 w-24 h-24 bg-amber-50 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
                <div class="relative z-10">
                    <h3 class="text-2xl font-bold text-gray-900 mb-2 group-hover:text-amber-700">Deep-Dive Test</h3>
                    <p class="text-amber-600 font-bold mb-4">120 Q's • ~15 Minutes</p>
                    <p class="text-gray-500 text-sm">A comprehensive, highly detailed analysis for maximum precision.</p>
                </div>
            </button>
        </div>
        <div v-if="isLoading" class="text-emerald-600 font-bold mt-4 animate-pulse">Loading questions...</div>
    </div>
</div>

<div v-else-if="assessmentStarted">"""
html = html.replace('            <div v-else>', selection_screen)

# 4. Update Vue Setup Imports and logic
html = html.replace('const { createApp, ref, computed } = Vue;', 'const { createApp, ref, computed, watch } = Vue;')

# 5. Replace questions array and add state
start_idx = html.find('const questions = ref([')
end_idx = html.find('const answers = ref(new Array(questions.value.length).fill(null));') + len('const answers = ref(new Array(questions.value.length).fill(null));')

new_vue_logic = """const privacyAgreed = ref(false);
            const validationError = ref('');
            const showLengthSelection = ref(false);
            const isLoading = ref(false);
            const questions = ref([]);
            const answers = ref([]);
            
            const tryStart = () => {
                if(!privacyAgreed.value) {
                    validationError.value = "You must agree to the Data Privacy Consent before starting.";
                } else {
                    validationError.value = '';
                    showLengthSelection.value = true;
                }
            };

            watch(assessmentStarted, (started) => {
                const nav = document.querySelector('nav');
                const footer = document.querySelector('footer');
                if (started) {
                    if (nav) nav.style.display = 'none';
                    if (footer) footer.style.display = 'none';
                } else {
                    if (nav) nav.style.display = '';
                    if (footer) footer.style.display = '';
                }
            });

            const startTest = async (type) => {
                isLoading.value = true;
                try {
                    const res = await fetch(`api/get_questions?type=${type}`);
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
                    console.error("Failed to fetch questions:", e);
                    alert("Failed to load assessment. Please check your connection.");
                }
                isLoading.value = false;
            };

            const currentQuestion = computed(() => questions.value[currentQuestionIndex.value] || {});"""

html = html[:start_idx] + new_vue_logic + html[end_idx:]

# 6. Update Vue return block
old_return = """return {
                assessmentStarted,
                currentQuestionIndex,"""
new_return = """return {
                assessmentStarted,
                privacyAgreed,
                validationError,
                showLengthSelection,
                tryStart,
                startTest,
                isLoading,
                currentQuestionIndex,"""
html = html.replace(old_return, new_return)

with open('app/Views/assessment.html', 'w', encoding='utf-8') as f:
    f.write(html)
print("Rebuilt perfectly!")
