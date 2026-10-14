<?php

$file = __DIR__ . '/app/Views/profile.html';
$content = file_get_contents($file);

if (strpos($content, '<script>') === false) {
    $script = <<<JS

    <script>
    document.addEventListener('DOMContentLoaded', async () => {
        // 1. Load User Info
        const userDataStr = localStorage.getItem('talunton_user');
        if (!userDataStr) {
            window.location.href = '/riasec/login';
            return;
        }
        
        let user;
        try {
            user = JSON.parse(userDataStr);
        } catch (e) {
            window.location.href = '/riasec/login';
            return;
        }

        const fullName = user.full_name || 'Student';
        const email = user.email || 'No email provided';
        const initial = fullName.charAt(0).toUpperCase();

        document.getElementById('profileName').textContent = fullName;
        document.getElementById('detailName').textContent = fullName;
        document.getElementById('detailEmail').textContent = email;
        document.getElementById('profileAvatarLarge').textContent = initial;

        // 2. Load Shortlisted Courses
        const shortlistContainer = document.getElementById('shortlistContainer');
        shortlistContainer.innerHTML = '<p class="text-sm text-gray-500 py-4">Loading saved courses...</p>';

        try {
            const res = await fetch('/riasec/api/get_degrees');
            if (!res.ok) throw new Error('Failed to fetch degrees');
            const degrees = await res.json();
            
            const savedDegrees = degrees.filter(d => d.is_saved == 1);
            
            if (savedDegrees.length === 0) {
                shortlistContainer.innerHTML = '<p class="text-sm text-gray-500 py-8 border border-dashed border-gray-200 rounded-xl text-center bg-gray-50">You haven\\'t shortlisted any courses yet.</p>';
            } else {
                let html = '';
                savedDegrees.forEach(deg => {
                    let campusesHtml = '';
                    if (deg.campuses_list) {
                        const campuses = deg.campuses_list.split('|');
                        campuses.forEach(camp => {
                            const parts = camp.split('::');
                            if (parts.length === 2) {
                                campusesHtml += `<a href="/riasec/\${parts[1]}?id=\${parts[0]}" class="text-[10px] bg-gray-100 hover:bg-gray-200 text-gray-600 px-2 py-0.5 rounded transition font-bold">\${parts[0]}</a>`;
                            }
                        });
                    }
                    
                    html += `
                    <div class="bg-white border border-gray-100 p-5 rounded-xl shadow-sm hover:border-emerald-200 hover:shadow-md transition flex flex-col sm:flex-row gap-4 justify-between items-start sm:items-center group">
                        <div>
                            <div class="flex items-center gap-2 mb-1">
                                <h3 class="font-bold text-gray-900 group-hover:text-emerald-700 transition">\${deg.title}</h3>
                                <span class="text-[10px] font-bold px-2 py-0.5 rounded bg-emerald-50 text-emerald-700 border border-emerald-100 uppercase tracking-wider">\${deg.category || 'Program'}</span>
                            </div>
                            <p class="text-sm text-gray-500 line-clamp-1 mb-3">\${deg.description || 'A degree program.'}</p>
                            <div class="flex flex-wrap gap-1">
                                \${campusesHtml}
                            </div>
                        </div>
                        <div class="flex-shrink-0 mt-2 sm:mt-0 flex gap-2 w-full sm:w-auto">
                            <a href="/riasec/degree-profile?id=\${deg.id}" class="flex-1 sm:flex-none text-center px-4 py-2 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 text-sm font-bold rounded-lg transition border border-emerald-100">View Details</a>
                            <button onclick="if(window.saveDegree) { window.saveDegree(this, \${deg.id}); setTimeout(()=>location.reload(), 300); }" class="p-2 text-emerald-600 bg-emerald-50 rounded-lg hover:bg-emerald-100 transition border border-emerald-100" aria-label="Remove">
                                <svg class="w-5 h-5" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24"><path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                            </button>
                        </div>
                    </div>
                    `;
                });
                shortlistContainer.innerHTML = html;
            }
            
        } catch (e) {
            console.error(e);
            shortlistContainer.innerHTML = '<p class="text-sm text-red-500 py-4">Failed to load saved courses. Please refresh.</p>';
        }
    });
    </script>
JS;

    $content .= $script;
    file_put_contents($file, $content);
    echo "Added script to profile.html\n";
} else {
    echo "Script already exists in profile.html\n";
}
