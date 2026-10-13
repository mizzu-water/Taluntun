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

$js_addition = <<<JS
        const reqSection = document.getElementById('admission-requirements-section');
        const reqList = document.getElementById('requirements-list');
        const reqCount = document.getElementById('req-count');
        
        if (college.requirements && college.requirements.length > 0) {
            reqSection.classList.remove('hidden');
            let reqHtml = '';
            college.requirements.forEach(req => {
                const isVerify = req.status.toLowerCase() === 'verify';
                const statusIconClass = isVerify ? 'bg-amber-500' : 'bg-emerald-600';
                const badgeClass = isVerify ? 'text-amber-700 bg-amber-50 border border-amber-200' : 'text-emerald-700 bg-emerald-50 border border-emerald-100';
                
                reqHtml += `
                <div class="border border-gray-100 p-4 rounded-xl bg-gray-50/50 hover:bg-white hover:border-emerald-200 hover:shadow-sm transition flex gap-4 group">
                    <div class="flex-shrink-0 mt-1">
                        <div class="w-5 h-5 rounded flex items-center justify-center \${statusIconClass}">
                            <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                    </div>
                    <div class="flex-grow">
                        <div class="flex justify-between items-start mb-1">
                            <h4 class="font-bold text-gray-900 text-sm group-hover:text-emerald-700 transition">\${req.title}</h4>
                            <span class="text-[10px] font-bold px-2 py-0.5 rounded \${badgeClass}">\${req.status}</span>
                        </div>
                        <p class="text-xs text-gray-500 leading-relaxed">\${req.desc}</p>
                    </div>
                </div>
                `;
            });
            reqList.innerHTML = reqHtml;
            reqCount.textContent = `\${college.requirements.length} Required Items`;
        }
JS;

foreach ($profiles as $file) {
    $path = __DIR__ . '/app/Views/' . $file;
    if (!file_exists($path)) continue;
    $content = file_get_contents($path);
    
    // Inject HTML after </section> of Programs Offered.
    // The exact string in the file:
    //                   </div>
    //               </section>
    //           </div>
    
    // So let's replace:
    $target_html = "</section>\r\n          </div>";
    if (strpos($content, $target_html) === false) {
        $target_html = "</section>\n          </div>";
    }
    
    if (strpos($content, $target_html) !== false) {
        // Only inject if not already there
        if (strpos($content, 'id="admission-requirements-section"') === false) {
            $content = str_replace($target_html, "</section>\n\n" . $section_html . "\n          </div>", $content);
        }
    }
    
    // Inject JS
    $target_js = "} else {\n            programsList.innerHTML";
    if (strpos($content, $target_js) === false) {
        $target_js = "} else {\r\n            programsList.innerHTML";
    }
    
    if (strpos($content, $target_js) !== false) {
        if (strpos($content, 'college.requirements') === false) {
            $content = str_replace($target_js, $js_addition . "\n\n        " . $target_js, $content);
        }
    }
    
    file_put_contents($path, $content);
    echo "Updated $file\n";
}
