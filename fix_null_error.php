<?php

$profiles = [
    'cvsu-profile.html',
    'dlsu-profile.html',
    'eac-profile.html',
    'ncst-profile.html',
    'pcu-profile.html',
    'tup-profile.html',
    'school-profile.html'
];

$section_html = <<<HTML
              <section id="admission-requirements-section" class="hidden mt-12">
                  <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
                      <div class="flex items-center gap-3">
                          <h2 class="text-2xl font-bold text-gray-900 font-serif-heading">Admission Requirements & Process</h2>
                          <span class="bg-emerald-600 text-white text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider">AY 2025–2026</span>
                      </div>
                      <button class="flex items-center gap-2 text-emerald-700 bg-emerald-50 hover:bg-emerald-100 border border-emerald-200 text-sm font-bold py-2 px-4 rounded-lg transition">
                          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                          Download Checklist PDF
                      </button>
                  </div>
                  
                  <div class="bg-white border border-gray-100 rounded-2xl p-6 sm:p-8 shadow-sm">
                      <div class="flex justify-between items-center mb-4">
                          <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                              <div class="w-6 h-6 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600">
                                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                              </div>
                              Document Requirements Checklist
                          </h3>
                          <span id="req-count" class="text-xs font-bold text-gray-500 bg-gray-50 px-3 py-1 rounded-full border border-gray-200"></span>
                      </div>
                      
                      <p class="text-sm text-gray-600 mb-6">Prepare all original documents along with clear photocopies inside a long brown envelope for in-person document screening at the Registrar's Office.</p>
                      
                      <div id="requirements-list" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                          <!-- Requirements will go here -->
                      </div>
                  </div>
              </section>
HTML;

foreach ($profiles as $file) {
    $path = __DIR__ . '/app/Views/' . $file;
    if (!file_exists($path)) continue;
    $content = file_get_contents($path);
    
    // 1. Fix the null check in JS
    $content = str_replace(
        "if (college.requirements && college.requirements.length > 0) {\n            reqSection.classList.remove('hidden');",
        "if (college.requirements && college.requirements.length > 0 && reqSection) {\n            reqSection.classList.remove('hidden');",
        $content
    );
    
    // Also handle \r\n
    $content = str_replace(
        "if (college.requirements && college.requirements.length > 0) {\r\n            reqSection.classList.remove('hidden');",
        "if (college.requirements && college.requirements.length > 0 && reqSection) {\r\n            reqSection.classList.remove('hidden');",
        $content
    );
    
    // 2. Inject HTML if missing
    if (strpos($content, 'id="admission-requirements-section"') === false) {
        // We look for </section> followed by </div> inside lg:col-span-2 space-y-12
        // A simple regex to insert before the last </div> in that block
        $pattern = '#(</section>\s+</div>\s+<div class="space-y-6">)#i';
        $replacement = "</section>\n\n" . $section_html . "\n          </div>\n          \n          <div class=\"space-y-6\">";
        
        // Wait, the structure is:
        // </section>
        // </div>
        // <div class="space-y-6">
        $content = preg_replace($pattern, $replacement, $content);
    }
    
    file_put_contents($path, $content);
    echo "Fixed $file\n";
}
