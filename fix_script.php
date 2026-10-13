<?php

$profiles = [
    'cvsu-profile.html' => 'CvSU',
    'dlsu-profile.html' => 'DLSU-D',
    'eac-profile.html' => 'EAC-C',
    'ncst-profile.html' => 'NCST',
    'pcu-profile.html' => 'PCU',
    'tup-profile.html' => 'TUP',
    'school-profile.html' => null
];

foreach ($profiles as $file => $shortNameVal) {
    $path = __DIR__ . '/app/Views/' . $file;
    if (!file_exists($path)) continue;
    $content = file_get_contents($path);
    
    // Find everything up to <script>
    $script_pos = strpos($content, "<script>");
    if ($script_pos === false) continue;
    
    $html_part = substr($content, 0, $script_pos);
    
    $fallback = $shortNameVal ? " || '$shortNameVal'" : "";

    $clean_script = <<<JS
<script>
document.addEventListener('DOMContentLoaded', async () => {
    const urlParams = new URLSearchParams(window.location.search);
    const shortName = urlParams.get('id')$fallback;
    
    if (!shortName) {
        document.getElementById('college-name').textContent = "University Not Found";
        document.getElementById('programs-list').innerHTML = '<div class="text-red-500 py-4">Invalid university ID.</div>';
        return;
    }

    try {
        const res = await fetch(`/riasec/api/get_college?id=\${encodeURIComponent(shortName)}`);
        if (!res.ok) throw new Error('Failed to fetch college');
        const college = await res.json();
        
        if (college.error) {
            document.getElementById('college-name').textContent = "University Not Found";
            document.getElementById('programs-list').innerHTML = `<div class="text-red-500 py-4">\${college.error}</div>`;
            return;
        }

        document.getElementById('college-name').textContent = college.name;
        if (document.getElementById('college-about')) document.getElementById('college-about').textContent = college.about || 'Providing quality education to students.';
        document.getElementById('college-address').textContent = college.address || "Dasmariñas City, Cavite";
        document.getElementById('college-type').textContent = college.type || "Private";
        if (document.getElementById('college-type-badge')) document.getElementById('college-type-badge').textContent = college.type || "Private";
        if (document.getElementById('college-uni-type')) document.getElementById('college-uni-type').textContent = (college.type && college.type.toLowerCase().includes('public')) ? 'Public University' : 'Private University';
        if (document.getElementById('college-banner-img') && college.image_url) document.getElementById('college-banner-img').src = college.image_url;
        
        document.title = `\${college.name} - Talunton Cavite`;
        
        if (college.map_query) {
            document.getElementById('map-section').classList.remove('hidden');
            document.getElementById('college-map-address').textContent = college.address || "Cavite, Philippines";
            document.getElementById('college-map-link').href = "https://www.google.com/maps/search/" + encodeURIComponent(college.map_query);
        }
        
        const saveBtn = document.getElementById('save-school-btn');
        if (window.saveCollege) {
            saveBtn.onclick = function() { window.saveCollege(this, college.id); };
        } else {
            saveBtn.onclick = function() {
                this.innerHTML='<svg class="w-4 h-4" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24"><path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg> Saved!'; 
                this.classList.remove('bg-emerald-600', 'hover:bg-emerald-700'); 
                this.classList.add('bg-gray-800', 'hover:bg-gray-900'); 
                alert('School successfully saved to your favorites!');
            };
        }

        const programsList = document.getElementById('programs-list');
        if (college.degrees && college.degrees.length > 0) {
            let html = '';
            college.degrees.forEach((deg, index) => {
                const isHidden = index >= 4;
                const displayStyle = isHidden ? 'style="display: none;"' : '';
                html += `
                <a href="/riasec/degree-profile?id=\${deg.id}" \${displayStyle} class="program-card border border-gray-200 p-5 rounded-2xl bg-white shadow-sm hover:border-emerald-500 hover:shadow-md transition flex flex-col h-full group">
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
                let btnContainer = document.getElementById('toggle-programs-container');
                if (!btnContainer) {
                    btnContainer = document.createElement('div');
                    btnContainer.id = 'toggle-programs-container';
                    btnContainer.className = 'mt-4 text-center col-span-1 sm:col-span-2';
                    btnContainer.innerHTML = `<button id="toggle-programs-btn" class="bg-gray-50 hover:bg-gray-100 border border-gray-200 text-gray-700 text-sm font-bold py-2.5 px-6 rounded-full transition shadow-sm">See More</button>`;
                    programsList.parentNode.insertBefore(btnContainer, programsList.nextSibling);
                    
                    let isExpanded = false;
                    document.getElementById('toggle-programs-btn').addEventListener('click', function(e) {
                        e.preventDefault();
                        isExpanded = !isExpanded;
                        const cards = programsList.querySelectorAll('.program-card');
                        cards.forEach((card, idx) => {
                            if (idx >= 4) {
                                card.style.display = isExpanded ? 'flex' : 'none';
                            }
                        });
                        this.textContent = isExpanded ? 'See Less' : 'See More';
                    });
                }
            }
        } else {
            programsList.innerHTML = '<div class="text-gray-500 py-4 col-span-2">No degree programs currently listed for this campus.</div>';
        }

    } catch (e) {
        console.error(e);
        document.getElementById('programs-list').innerHTML = '<div class="text-red-500 py-4">Failed to load data. Please try again.</div>';
    }
});
</script>
</div>
JS;

    file_put_contents($path, $html_part . $clean_script);
    echo "Fixed syntax in $file\n";
}
