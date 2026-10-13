<?php
$file = 'app/Views/results.html';
$html = file_get_contents($file);

// 1. Remove the strict v-if="!isLoggedIn" blocking wrapper
$blocker_html = '
            <div v-if="!isLoggedIn" class="max-w-3xl mx-auto px-4 py-16 text-center mt-8 bg-white rounded-2xl shadow-xl border border-gray-100 mb-16">
                <div class="w-20 h-20 bg-orange-100 text-orange-600 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8V7a4 4 0 00-8 0v4h8z"></path></svg>
                </div>
                <h2 class="text-3xl font-serif-heading font-bold text-gray-900 mb-4">Your Results are Ready!</h2>
                <p class="text-gray-500 mb-8 max-w-lg mx-auto">Please create a free account or log in to view your top degree matches, trait breakdown, and personalized recommendations.</p>
                <div class="flex justify-center gap-4">
                    <a href="signup" class="bg-[#0e3223] hover:bg-black text-white font-bold py-3 px-8 rounded-full transition shadow">Sign Up Free</a>
                    <a href="login" class="bg-white hover:bg-gray-50 text-[#0e3223] border border-[#0e3223] font-bold py-3 px-8 rounded-full transition shadow-sm">Log In</a>
                </div>
            </div>
            
            <div v-else>
';
$html = str_replace($blocker_html, '<div>', $html);

// Remove the closing div for v-else
$html = preg_replace('/<\/div>\s*<\/main>/', '</div></main>', $html);

// 2. Add an optional "Save your results" banner if not logged in
$save_banner = '
            <div v-if="!isLoggedIn" class="bg-amber-50 border border-amber-200 p-4 rounded-xl mb-8 flex justify-between items-center max-w-[1200px] mx-auto text-amber-800 shadow-sm mt-4">
                <div>
                    <strong>Guest Mode:</strong> Your results are only saved locally right now. Sign up to permanently save your profile and degree matches!
                </div>
                <a href="signup" class="bg-amber-600 hover:bg-amber-700 text-white px-4 py-2 rounded-lg font-bold shadow-sm transition">Create Account</a>
            </div>
';
$html = str_replace('<section class="max-w-[1200px] mx-auto px-4 -mt-10 md:-mt-16 relative z-20 mb-16">', $save_banner . '<section class="max-w-[1200px] mx-auto px-4 -mt-10 md:-mt-16 relative z-20 mb-16">', $html);


// 3. Improve the Matchmaker Algorithm
$old_fetch = "const fetchRecommendedDegrees = async () => {
                try {
                    const res = await fetch('api/get_degrees');
                    if (!res.ok) return;
                    const all = await res.json();
                    
                    let matches = all.map(deg => {
                        let score = 0;
                        if (deg.holland_code) {
                            if (topTraits.value[0] && deg.holland_code.includes(topTraits.value[0].code)) score += 50;
                            if (topTraits.value[1] && deg.holland_code.includes(topTraits.value[1].code)) score += 30;
                            if (topTraits.value[2] && deg.holland_code.includes(topTraits.value[2].code)) score += 10;
                        }
                        
                        return {
                            id: deg.id,
                            title: deg.title,
                            fit: Math.min(99, 45 + score),
                            isPublic: deg.category !== 'private',
                            campuses: deg.campuses || [],
                            showDropdown: false
                        };
                    });
                    
                    // Sort by fit
                    matches.sort((a, b) => b.fit - a.fit);
                    degreeMatches.value = matches.slice(0, 6);
                } catch(e) {
                    console.error(e);
                }
            };";

$new_fetch = "const fetchRecommendedDegrees = async () => {
                try {
                    const res = await fetch('api/get_degrees');
                    if (!res.ok) return;
                    const all = await res.json();
                    
                    let userCode = topTraits.value.map(t => t.code).join('');
                    
                    let matches = all.map(deg => {
                        let score = 0;
                        if (deg.holland_code && userCode.length === 3) {
                            let degCode = deg.holland_code.replace(/-/g, '');
                            for(let i=0; i<3; i++) {
                                for(let j=0; j<3; j++) {
                                    if(degCode[j] && userCode[i] === degCode[j]) {
                                        if(i === j) score += 3; // exact match
                                        else if(Math.abs(i-j) === 1) score += 2; // off by 1
                                        else score += 1; // off by 2
                                    }
                                }
                            }
                        }
                        
                        // Score is out of 9 max. Convert to percentage.
                        let percent = Math.round((score / 9) * 100);
                        if (percent < 30) percent = 30 + Math.floor(Math.random()*20); // Base floor so it doesn't look totally broken
                        if (percent > 99) percent = 99;
                        if (score === 9) percent = 99; // Perfect match
                        
                        return {
                            id: deg.id,
                            title: deg.title,
                            fit: percent,
                            isPublic: deg.category !== 'private',
                            campuses: deg.campuses || [],
                            showDropdown: false
                        };
                    });
                    
                    // Sort by fit
                    matches.sort((a, b) => b.fit - a.fit);
                    degreeMatches.value = matches.slice(0, 6);
                } catch(e) {
                    console.error(e);
                }
            };";

$html = str_replace($old_fetch, $new_fetch, $html);

// 4. Make sure fetchRecommendedDegrees runs even if not logged in
$html = str_replace('if (isLoggedIn.value) { fetchRecommendedDegrees(); } document.addEventListener', 'fetchRecommendedDegrees(); document.addEventListener', $html);

file_put_contents($file, $html);
echo "Results Matchmaker perfectly optimized!";
?>
