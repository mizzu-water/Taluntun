import os
import re

colleges_map = {
    'dlsu-profile.html': 1,
    'tup-profile.html': 2,
    'cvsu-profile.html': 3,
    'eac-profile.html': 4,
    'ncst-profile.html': 5,
    'pcu-profile.html': 6
}

save_script = """
    <script>
        function saveCollege(btn, collegeId) {
            const userDataStr = localStorage.getItem('talunton_user');
            if (!userDataStr) {
                window.location.href = 'login.html';
                return;
            }
            try {
                const user = JSON.parse(userDataStr);
                
                // Visual feedback
                btn.innerHTML = `<svg class="w-4 h-4" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24"><path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg> Saved!`;
                btn.classList.remove('bg-emerald-600', 'hover:bg-emerald-700');
                btn.classList.add('bg-gray-800', 'hover:bg-gray-900');
                
                fetch('save_college.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ user_id: user.id, college_id: collegeId })
                })
                .then(res => res.json())
                .then(data => {
                    if(!data.success) {
                        alert('Error saving college: ' + data.error);
                    }
                })
                .catch(err => console.error(err));
            } catch(e) {
                console.error('User parsing error:', e);
            }
        }
    </script>
</body>
"""

for filename, college_id in colleges_map.items():
    if os.path.exists(filename):
        with open(filename, 'r', encoding='utf-8') as f:
            content = f.read()
        
        # Replace the onclick
        content = re.sub(r'onclick="this\.innerHTML=\'&lt;svg[^"]+"', f'onclick="saveCollege(this, {college_id})"', content)
        
        # Inject the script if not already there
        if 'function saveCollege(' not in content:
            content = content.replace('</body>', save_script)
            
        with open(filename, 'w', encoding='utf-8') as f:
            f.write(content)
        print(f"Updated {filename}")
