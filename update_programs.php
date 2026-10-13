<?php

$files = glob(__DIR__ . '/app/Views/*-profile.html');

foreach ($files as $file) {
    if (basename($file) === 'degree-profile.html') {
        continue;
    }
    
    $content = file_get_contents($file);
    
    // We want to replace the programs rendering logic.
    // Let's find the start and end of the block.
    
    $start_pattern = "const programsList = document.getElementById('programs-list');";
    $end_pattern = "} else {";
    
    $start_pos = strpos($content, $start_pattern);
    $end_pos = strpos($content, $end_pattern, $start_pos);
    
    if ($start_pos !== false && $end_pos !== false) {
        $replacement = <<<JS
const programsList = document.getElementById('programs-list');
        if (college.degrees && college.degrees.length > 0) {
            let html = '';
            college.degrees.forEach((deg, index) => {
                const hiddenClass = index >= 4 ? 'hidden hidden-program' : '';
                html += `
                <a href="/riasec/degree-profile?id=\${deg.id}" class="border border-gray-200 p-5 rounded-2xl bg-white shadow-sm hover:border-emerald-500 hover:shadow-md transition block group flex flex-col h-full \${hiddenClass}">
                    <div class="font-bold text-gray-900 group-hover:text-emerald-700 transition text-lg mb-2">\${deg.title}</div>
                    <div class="text-sm text-gray-500 mb-3 flex-grow line-clamp-2">\${deg.description || 'A degree program.'}</div>
                    <div class="flex justify-between items-center mt-auto pt-3 border-t border-gray-100">
                        <span class="text-xs font-bold uppercase tracking-widest text-emerald-700 bg-emerald-50 px-3 py-1 rounded-full border border-emerald-100">\${deg.category || 'Program'}</span>
                    </div>
                </a>
                `;
            });
            programsList.innerHTML = html;
            
            if (college.degrees.length > 4) {
                // Check if btn already exists (to avoid duplicates on multiple renders, though it only runs once here)
                let btnContainer = document.getElementById('toggle-programs-container');
                if (!btnContainer) {
                    btnContainer = document.createElement('div');
                    btnContainer.id = 'toggle-programs-container';
                    btnContainer.className = 'mt-4 text-center';
                    btnContainer.innerHTML = `<button id="toggle-programs-btn" class="bg-gray-50 hover:bg-gray-100 border border-gray-200 text-gray-700 text-sm font-bold py-2.5 px-6 rounded-full transition shadow-sm">See More</button>`;
                    programsList.parentNode.insertBefore(btnContainer, programsList.nextSibling);
                    
                    let isExpanded = false;
                    document.getElementById('toggle-programs-btn').addEventListener('click', function(e) {
                        e.preventDefault();
                        isExpanded = !isExpanded;
                        const hiddenItems = programsList.querySelectorAll('.hidden-program');
                        hiddenItems.forEach(item => {
                            if (isExpanded) {
                                item.classList.remove('hidden');
                            } else {
                                item.classList.add('hidden');
                            }
                        });
                        this.textContent = isExpanded ? 'See Less' : 'See More';
                    });
                }
            }
        
JS;
        $before = substr($content, 0, $start_pos);
        $after = substr($content, $end_pos);
        $new_content = $before . $replacement . $after;
        file_put_contents($file, $new_content);
        echo "Updated " . basename($file) . "\n";
    } else {
        echo "Could not find pattern in " . basename($file) . "\n";
    }
}
