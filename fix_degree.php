<?php
$html = file_get_contents('app/Views/layout.php');

$script = "
        window.saveDegree = function(btn, degreeId) {
            const userDataStr = localStorage.getItem('talunton_user');
            if (!userDataStr) {
                window.location.href = 'login';
                return;
            }
            
            // Visual feedback
            btn.innerHTML = \<svg class=\\"w-5 h-5\\" fill=\\"currentColor\\" stroke=\\"currentColor\\" viewBox=\\"0 0 24 24\\"><path d=\\"M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z\\"></path></svg>\;
            btn.classList.add('text-emerald-600');
            
            const csrfMeta = document.querySelector('meta[name=\\"csrf-token\\"]');
            const csrfToken = csrfMeta ? csrfMeta.content : '';
            
            fetch('api/save_degree', {
                method: 'POST',
                headers: { 
                    'Content-Type': 'application/json',
                    'X-CSRF-Token': csrfToken
                },
                body: JSON.stringify({ degree_id: degreeId })
            })
            .then(res => res.json())
            .then(data => {
                if(!data.success) {
                    alert('Error saving degree: ' + (data.error || 'Unknown error'));
                }
            })
            .catch(err => console.error(err));
        };
";

\ = str_replace('window.saveCollege = function', \ . "\n        window.saveCollege = function", \);
file_put_contents('app/Views/layout.php', \);
echo "Injected saveDegree into layout.php";
?>
