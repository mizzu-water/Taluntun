<?php
$content = file_get_contents('app/Views/layout.php');

$patch = "
        // Global save functions for colleges and degrees
        window.saveCollege = function(btn, collegeId) {
            const userDataStr = localStorage.getItem('talunton_user');
            if (!userDataStr) {
                window.location.href = 'login';
                return;
            }
            
            // Visual feedback
            btn.innerHTML = '<svg class=\"w-4 h-4\" fill=\"currentColor\" stroke=\"currentColor\" viewBox=\"0 0 24 24\"><path d=\"M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z\"></path></svg> Saved!';
            btn.classList.remove('bg-emerald-600', 'hover:bg-emerald-700');
            btn.classList.add('bg-gray-800', 'hover:bg-gray-900');
            
            const csrfMeta = document.querySelector('meta[name=\"csrf-token\"]');
            const csrfToken = csrfMeta ? csrfMeta.content : '';
            
            fetch('api/save_college', {
                method: 'POST',
                headers: { 
                    'Content-Type': 'application/json',
                    'X-CSRF-Token': csrfToken
                },
                body: JSON.stringify({ college_id: collegeId })
            })
            .then(res => res.json())
            .then(data => {
                if(!data.success) {
                    alert('Error saving college: ' + (data.error || 'Unknown error'));
                }
            })
            .catch(err => console.error(err));
        };
";

$content = str_replace('    </script>', $patch . "\n    </script>", $content);
file_put_contents('app/Views/layout.php', $content);
echo "Injected saveCollege into layout.php";
?>
