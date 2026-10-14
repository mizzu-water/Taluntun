$CollegesMap = @{
    'dlsu-profile.html' = 1
    'tup-profile.html' = 2
    'cvsu-profile.html' = 3
    'eac-profile.html' = 4
    'ncst-profile.html' = 5
    'pcu-profile.html' = 6
}

$SaveScript = @"
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
"@

foreach ($File in $CollegesMap.Keys) {
    if (Test-Path $File) {
        $Content = Get-Content -Raw -Path $File
        $CollegeId = $CollegesMap[$File]
        
        # Regex replacement for onclick
        $Content = $Content -replace 'onclick="this\.innerHTML=\''&lt;svg[^"]+"', "onclick=`"saveCollege(this, $CollegeId)`""
        
        # Inject script
        if ($Content -notmatch 'function saveCollege\(') {
            $Content = $Content -replace '</body>', $SaveScript
        }
        
        Set-Content -Path $File -Value $Content -Encoding UTF8
        Write-Host "Updated $File"
    }
}
