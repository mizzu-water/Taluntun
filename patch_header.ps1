
# Injects a standardized, fully working header (with burger menu) into every page.
# Each page gets the right "active" nav link highlighted.

$rootDir = "c:\xampp\htdocs\riasec\app\Views"

# Define per-page config: activeLink label, path prefix for assets
$pageConfigs = @{
    "home.html"         = @{ active="Home";            prefix="" }
    "colleges.html"     = @{ active="Colleges";        prefix="" }
    "degrees.html"      = @{ active="Degree Programs"; prefix="" }
    "scholarships.html" = @{ active="Scholarships";    prefix="" }
    "holland.html"      = @{ active="Holland Codes";   prefix="" }
    "assessment.html"   = @{ active="Assessment";      prefix="" }
    "results.html"      = @{ active="My Results";      prefix="" }
    "how-it-works.html" = @{ active="";                prefix="" }
    "profile.html"      = @{ active="";                prefix="" }
    "settings.html"     = @{ active="";                prefix="" }
    "school-map.html"   = @{ active="";                prefix="" }
        "course-intro.html" = @{ active="";                prefix="" }
    "cvsu-profile.html" = @{ active=""; prefix="" }
    "cvsu-campus.html" = @{ active=""; prefix="" }
    "cvsu-programs.html" = @{ active=""; prefix="" }
    "cvsu-tuition.html" = @{ active=""; prefix="" }
    "dlsu-profile.html" = @{ active=""; prefix="" }
    "dlsu-campus.html" = @{ active=""; prefix="" }
    "dlsu-programs.html" = @{ active=""; prefix="" }
    "dlsu-tuition.html" = @{ active=""; prefix="" }
    "eac-profile.html" = @{ active=""; prefix="" }
    "eac-campus.html" = @{ active=""; prefix="" }
    "eac-programs.html" = @{ active=""; prefix="" }
    "eac-tuition.html" = @{ active=""; prefix="" }
    "ncst-profile.html" = @{ active=""; prefix="" }
    "ncst-campus.html" = @{ active=""; prefix="" }
    "ncst-programs.html" = @{ active=""; prefix="" }
    "ncst-tuition.html" = @{ active=""; prefix="" }
    "pcu-profile.html" = @{ active=""; prefix="" }
    "pcu-campus.html" = @{ active=""; prefix="" }
    "pcu-programs.html" = @{ active=""; prefix="" }
    "pcu-tuition.html" = @{ active=""; prefix="" }
    "tup-profile.html" = @{ active=""; prefix="" }
    "tup-campus.html" = @{ active=""; prefix="" }
    "tup-programs.html" = @{ active=""; prefix="" }
    "tup-tuition.html" = @{ active=""; prefix="" }
    "school-profile.html" = @{ active=""; prefix="" }
    "school-campus.html" = @{ active=""; prefix="" }
    "school-programs.html" = @{ active=""; prefix="" }
    "school-tuition.html" = @{ active=""; prefix="" }
}

$navLinks = @(
    @{ href="home";             label="Home" },
    @{ href="assessment";   label="Assessment" },
    @{ href="colleges";     label="Colleges" },
    @{ href="degrees";      label="Degree Programs" },
    @{ href="scholarships"; label="Scholarships" },
    @{ href="holland";      label="Holland Codes" }
)

foreach ($pageName in $pageConfigs.Keys) {
    $filePath = Join-Path $rootDir $pageName
    if (-not (Test-Path $filePath)) { Write-Host "Not found: $pageName"; continue }

    $content = Get-Content $filePath -Raw -Encoding UTF8
    $activeLabel = $pageConfigs[$pageName].active

    # â”€â”€ Build desktop nav links â”€â”€
    $desktopLinks = ""
    foreach ($link in $navLinks) {
        if ($link.label -eq $activeLabel) {
            $desktopLinks += "                        <a href=`"$($link.href)`" class=`"text-emerald-700 border-b-2 border-emerald-700 pb-0.5`">$($link.label)</a>`n"
        } else {
            $desktopLinks += "                        <a href=`"$($link.href)`" class=`"hover:text-emerald-700 transition`">$($link.label)</a>`n"
        }
    }

    # â”€â”€ Build mobile nav links â”€â”€
    $mobileLinks = ""
    foreach ($link in $navLinks) {
        if ($link.label -eq $activeLabel) {
            $mobileLinks += "            <a href=`"$($link.href)`" class=`"block px-4 py-3 text-sm font-bold text-emerald-700 bg-emerald-50 rounded-lg`">$($link.label)</a>`n"
        } else {
            $mobileLinks += "            <a href=`"$($link.href)`" class=`"block px-4 py-3 text-sm font-bold text-gray-700 hover:bg-gray-50 hover:text-emerald-700 rounded-lg transition`">$($link.label)</a>`n"
        }
    }

    # â”€â”€ Full header HTML â”€â”€
    $newHeader = @"
    <!-- Header -->
    <header class="bg-white px-4 py-2 sticky top-0 z-50 border-b border-gray-100 shadow-sm">
        <div class="max-w-[1400px] mx-auto flex justify-between items-center">
            <!-- Logo -->
            <a href="home" class="flex items-center gap-2">
                <div class="text-emerald-700 font-extrabold text-2xl tracking-tight leading-none">TALUNTON</div>
                <div class="hidden sm:flex text-emerald-500">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </a>

            <!-- Desktop Nav -->
            <nav class="hidden lg:flex items-center gap-6 text-[13px] font-bold text-gray-700">
$desktopLinks            </nav>

            <!-- Right: Auth + Burger -->
            <div class="flex items-center gap-3">
                <!-- Logged OUT -->
                <div id="authLoggedOut" class="flex items-center gap-2">
                    <a href="login" class="hidden sm:inline-flex text-[13px] font-bold text-gray-700 border border-gray-300 rounded-full px-4 py-1.5 hover:bg-gray-50 transition">Log In</a>
                    <a href="signup" class="inline-flex text-[13px] font-bold text-white bg-[#0f2e21] rounded-full px-4 py-1.5 hover:bg-black transition">Sign Up</a>
                </div>
                <!-- Logged IN -->
                <div id="authLoggedIn" class="hidden relative">
                    <button id="userMenuBtn" class="flex items-center gap-2 bg-emerald-50 hover:bg-emerald-100 border border-emerald-200 rounded-full pl-2 pr-4 py-1.5 transition">
                        <div id="userAvatar" class="w-7 h-7 rounded-full bg-[#0e3223] text-white text-xs font-bold flex items-center justify-center">J</div>
                        <span id="userNameDisplay" class="text-sm font-bold text-gray-800 max-w-[100px] truncate"></span>
                        <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div id="userDropdown" class="hidden absolute right-0 top-12 bg-white border border-gray-100 rounded-xl shadow-xl w-56 py-2 z-50">
                        <!-- Profile Section -->
                        <div class="px-4 py-2 border-b border-gray-100 mb-1">
                            <p class="text-xs text-gray-500 uppercase tracking-wider font-bold mb-1">Account</p>
                            <a href="profile" class="flex items-center gap-3 py-1.5 text-sm text-gray-700 hover:text-emerald-700 font-medium group">
                                <svg class="w-4 h-4 text-gray-400 group-hover:text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                My Profile
                            </a>
                            <a href="settings" class="flex items-center gap-3 py-1.5 text-sm text-gray-700 hover:text-emerald-700 font-medium group">
                                <svg class="w-4 h-4 text-gray-400 group-hover:text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                Settings
                            </a>
                        </div>
                        
                        <!-- Assessment Section -->
                        <div class="px-4 py-2 border-b border-gray-100 mb-1">
                            <p class="text-xs text-gray-500 uppercase tracking-wider font-bold mb-1">Assessment</p>
                            <a href="results" class="flex items-center gap-3 py-1.5 text-sm text-gray-700 hover:text-emerald-700 font-medium group">
                                <svg class="w-4 h-4 text-gray-400 group-hover:text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                My Results
                            </a>
                            <a href="assessment" class="flex items-center gap-3 py-1.5 text-sm text-gray-700 hover:text-emerald-700 font-medium group">
                                <svg class="w-4 h-4 text-gray-400 group-hover:text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                                Retake Assessment
                            </a>
                        </div>

                        <!-- Logout -->
                        <div class="px-4 pt-1 pb-1">
                            <a href="auth/logout.php" class="flex items-center gap-3 py-1.5 text-sm text-red-500 hover:text-red-700 font-bold group">
                                <svg class="w-4 h-4 text-red-400 group-hover:text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                Log Out
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Burger Button -->
                <button id="burgerBtn" class="lg:hidden p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg transition" aria-label="Open menu">
                    <svg id="burgerIcon" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                    <svg id="closeIcon" class="w-6 h-6 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>
        
        <!-- Mobile Menu Drawer -->
        <div id="mobileMenu" class="hidden lg:hidden bg-white border-t border-gray-100 shadow-lg z-40 relative">
            <div class="max-w-[1400px] mx-auto px-4 py-3 space-y-1">
$mobileLinks                <div class="border-t border-gray-100 pt-3 mt-2 space-y-2">
                    <a href="login" class="block text-center text-sm font-bold text-gray-700 border border-gray-300 rounded-full py-2.5 hover:bg-gray-50 transition">Log In</a>
                    <a href="signup" class="block text-center text-sm font-bold text-white bg-[#0f2e21] rounded-full py-2.5 hover:bg-black transition">Sign Up</a>
                </div>
            </div>
        </div>
    </header>
"@

    # â”€â”€ Auth + Burger JS (inject before </body>) â”€â”€
    $headerJs = @"
    <script>
        // â”€â”€ Auth state â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
        (function () {
            const userData = localStorage.getItem('talunton_user');
            if (userData) {
                try {
                    const user = JSON.parse(userData);
                    document.getElementById('authLoggedOut').classList.add('hidden');
                    document.getElementById('authLoggedIn').classList.remove('hidden');
                    const name = user.full_name || '';
                    document.getElementById('userNameDisplay').textContent = name.split(' ')[0];
                    document.getElementById('userAvatar').textContent = name.charAt(0).toUpperCase();
                } catch(e) {}
            }
            // User dropdown (using event delegation)
            document.addEventListener('click', (e) => {
                const btn = e.target.closest('#userMenuBtn');
                const dd = document.getElementById('userDropdown');
                if (btn) {
                    e.stopPropagation();
                    dd?.classList.toggle('hidden');
                } else if (dd && !dd.contains(e.target)) {
                    dd.classList.add('hidden');
                }
            });
        })();

        // â”€â”€ Burger menu â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
        (function () {
            document.addEventListener('click', function (e) {
                const burgerBtn = e.target.closest('#burgerBtn');
                const menu = document.getElementById('mobileMenu');
                const burgerIcon = document.getElementById('burgerIcon');
                const closeIcon = document.getElementById('closeIcon');
                
                if (!menu) return;

                if (burgerBtn) {
                    e.stopPropagation();
                    const isOpen = !menu.classList.contains('hidden');
                    menu.classList.toggle('hidden');
                    if (burgerIcon) burgerIcon.classList.toggle('hidden', !isOpen);
                    if (closeIcon) closeIcon.classList.toggle('hidden', isOpen);
                } else if (!menu.contains(e.target)) {
                    menu.classList.add('hidden');
                    if (burgerIcon) burgerIcon.classList.remove('hidden');
                    if (closeIcon) closeIcon.classList.add('hidden');
                }
            });
        })();
    </script>
"@

    # â”€â”€ Replace the old <header>â€¦</header> block â”€â”€
    $content = $content -replace '(?s)(?:<!--\s*Header\s*-->[\s\r\n]*)?<header[^>]*>.*?</header>', $newHeader

    # â”€â”€ Remove any old JS blocks already in the file â”€â”€
    # Destructive regex removed
    
    # â”€â”€ Inject new JS before </body> â”€â”€
    $content = $content -replace '(?s)(</body>)', "$headerJs`$1"

    Set-Content -Path $filePath -Value $content -Encoding UTF8
    Write-Host "Patched: $pageName"
}

Write-Host "`nAll pages updated!"



