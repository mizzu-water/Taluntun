<?php
$file = 'app/Views/assessment.html';
$html = file_get_contents($file);

$pattern = '/<button @click="assessmentStarted = true"[^>]*>.*?<\/button>/s';

$new_button = '<div class="mb-8 text-left bg-gray-50 p-4 rounded-xl border border-gray-200">
            <label class="flex items-start gap-3 cursor-pointer">
                <input type="checkbox" v-model="privacyAgreed" class="mt-1 w-5 h-5 text-emerald-600 rounded border-gray-300 focus:ring-emerald-500">
                <span class="text-sm text-gray-700">
                    <strong>Data Privacy Consent:</strong> I agree to allow Talunton Cavite to collect and process my assessment responses for the purpose of career profiling. I understand my data will be handled securely.
                </span>
            </label>
            <p v-if="validationError" class="text-red-500 text-sm mt-2 font-bold">{{ validationError }}</p>
        </div>
        
        <button @click="tryStart" :class="{\'opacity-50\': !privacyAgreed, \'hover:bg-black hover:-translate-y-1 hover:shadow-2xl\': privacyAgreed}" class="bg-[#0e3223] text-white px-12 py-4 rounded-full font-bold text-xl transition-all duration-300 shadow-xl inline-flex items-center gap-3">
            Start Assessment
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
        </button>';

$html = preg_replace($pattern, $new_button, $html);
file_put_contents($file, $html);
echo "Added checkbox back!";
?>
