<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Talunton Cavite - Discover Your Career DNA' ?></title>
    <meta name="csrf-token" content="<?= $_SESSION['csrf_token'] ?? '' ?>">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="assets/css/enhancements.css?v=<?= filemtime(__DIR__ . '/../../assets/css/enhancements.css') ?>">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="vue.global.prod.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Merriweather:wght@700;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; scroll-behavior: smooth; }
        .font-serif-heading { font-family: 'Merriweather', serif; }
        
        /* Custom wavy bottom for hero (Optional, kept for backward compat) */
        .custom-shape-divider-bottom {
            position: absolute;
            bottom: -1px;
            left: 0;
            width: 100%;
            overflow: hidden;
            line-height: 0;
            z-index: 10;
        }

        .custom-shape-divider-bottom svg {
            position: relative;
            display: block;
            width: calc(100% + 1.3px);
            height: 40px;
        }

        .custom-shape-divider-bottom .shape-fill {
            fill: #fdfaf6;
        }
        
        @media (min-width: 768px) {
            .custom-shape-divider-bottom svg {
                height: 60px;
            }
        }
    
        /* Premium Animated Card */
        @keyframes slideInRight {
            0% { transform: translateY(8px) scale(0.99); opacity: 0; }
            100% { transform: translateY(0) scale(1); opacity: 1; }
        }

        .question-card {
            background: #ffffff !important;
            border-radius: 2.5rem !important;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.08), 0 0 0 1px rgba(0, 0, 0, 0.02) !important;
            padding: 3rem !important;
            animation: slideInRight 0.35s cubic-bezier(0.2, 0.8, 0.2, 1) forwards !important;
        }

        @media (max-width: 640px) {
            .question-card {
                padding: 1.5rem !important;
                border-radius: 1.5rem !important;
            }
        }
    </style>
    <script>
        function setNavbarHeight() {
            const header = document.querySelector('header');
            if (header) {
                document.documentElement.style.setProperty('--navbar-height', header.offsetHeight + 'px');
            }
        }
        window.addEventListener('resize', setNavbarHeight);
        window.addEventListener('DOMContentLoaded', setNavbarHeight);
        // Also run immediately if possible
        setNavbarHeight();
    </script>
</head>
<body class="bg-[#fdfaf6] text-gray-800">
    <?php
        $navbarAuthenticated = isLoggedIn();
        $navbarFullName = trim((string)($_SESSION['full_name'] ?? ''));
        $navbarEmail = trim((string)($_SESSION['email'] ?? ''));
        $navbarFirstName = $navbarFullName !== '' ? (preg_split('/\s+/', $navbarFullName)[0] ?? '') : '';
        $navbarEmailName = explode('@', $navbarEmail, 2)[0];
        $navbarDisplayName = $navbarFirstName !== '' ? $navbarFirstName : $navbarEmailName;
        $navbarInitial = mb_strtoupper(mb_substr($navbarDisplayName, 0, 1, 'UTF-8'), 'UTF-8') ?: 'U';
    ?>
    <div id="app" class="min-h-screen flex flex-col">
        
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
                <nav aria-label="Primary navigation" class="hidden lg:flex items-center gap-6 text-[13px] font-bold text-gray-700">
                            <a href="home" class="hover:text-emerald-700 transition">Home</a>
                            <a href="assessment" class="hover:text-emerald-700 transition">Assessment</a>
                            <a href="colleges" class="hover:text-emerald-700 transition">Colleges</a>
                            <a href="degrees" class="hover:text-emerald-700 transition">Degree Programs</a>
                            <a href="scholarships" class="hover:text-emerald-700 transition">Scholarships</a>
                            <a href="holland" class="hover:text-emerald-700 transition">Holland Codes</a>
                </nav>

                <!-- Right: Auth + Burger -->
                <div class="flex items-center gap-3">
                    <!-- Logged OUT -->
                    <div id="authLoggedOut" class="flex items-center gap-2<?= $navbarAuthenticated ? ' hidden' : '' ?>">
                        <a href="login" class="hidden sm:inline-flex text-[13px] font-bold text-gray-700 border border-gray-300 rounded-full px-4 py-1.5 hover:bg-gray-50 transition">Log In</a>
                        <a href="signup" class="inline-flex text-[13px] font-bold text-white bg-[#0f2e21] rounded-full px-4 py-1.5 hover:bg-black transition">Sign Up</a>
                    </div>
                    <!-- Logged IN -->
                    <div id="authLoggedIn" class="<?= $navbarAuthenticated ? 'relative' : 'hidden relative' ?>">
                        <button id="userMenuBtn" aria-expanded="false" aria-controls="userDropdown" class="flex items-center gap-2 bg-emerald-50 hover:bg-emerald-100 border border-emerald-200 rounded-full pl-2 pr-4 py-1.5 transition">
                            <div id="userAvatar" class="w-7 h-7 rounded-full bg-[#0e3223] text-white text-xs font-bold flex items-center justify-center"><?= $navbarAuthenticated ? htmlspecialchars($navbarInitial, ENT_QUOTES, 'UTF-8') : '' ?></div>
                            <span id="userNameDisplay" class="text-sm font-bold text-gray-800 max-w-[100px] truncate"><?= $navbarAuthenticated ? htmlspecialchars($navbarDisplayName, ENT_QUOTES, 'UTF-8') : '' ?></span>
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
                            </div>

                            <!-- Logout -->
                            <div class="px-4 pt-1 pb-1">
                                <a href="logout" class="flex items-center gap-3 py-1.5 text-sm text-red-500 hover:text-red-700 font-bold group">
                                    <svg class="w-4 h-4 text-red-400 group-hover:text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                    Log Out
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Burger Button -->
                    <button id="burgerBtn" class="lg:hidden p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg transition" aria-label="Open menu" aria-expanded="false" aria-controls="mobileMenu">
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
            <div id="mobileMenu" class="hidden lg:hidden bg-white border-t border-gray-100 shadow-lg z-40 relative" role="region" aria-label="Mobile navigation">
                <div class="max-w-[1400px] mx-auto px-4 py-3 space-y-1">
                <a href="home" class="block px-4 py-3 text-sm font-bold text-gray-700 hover:bg-gray-50 hover:text-emerald-700 rounded-lg transition">Home</a>
                <a href="assessment" class="block px-4 py-3 text-sm font-bold text-gray-700 hover:bg-gray-50 hover:text-emerald-700 rounded-lg transition">Assessment</a>
                <a href="colleges" class="block px-4 py-3 text-sm font-bold text-gray-700 hover:bg-gray-50 hover:text-emerald-700 rounded-lg transition">Colleges</a>
                <a href="degrees" class="block px-4 py-3 text-sm font-bold text-gray-700 hover:bg-gray-50 hover:text-emerald-700 rounded-lg transition">Degree Programs</a>
                <a href="scholarships" class="block px-4 py-3 text-sm font-bold text-gray-700 hover:bg-gray-50 hover:text-emerald-700 rounded-lg transition">Scholarships</a>
                <a href="holland" class="block px-4 py-3 text-sm font-bold text-gray-700 hover:bg-gray-50 hover:text-emerald-700 rounded-lg transition">Holland Codes</a>
                    <div id="mobileAuthLoggedOut" class="border-t border-gray-100 pt-3 mt-2 space-y-2<?= $navbarAuthenticated ? ' hidden' : '' ?>">
                        <a href="login" class="block text-center text-sm font-bold text-gray-700 border border-gray-300 rounded-full py-2.5 hover:bg-gray-50 transition">Log In</a>
                        <a href="signup" class="block text-center text-sm font-bold text-white bg-[#0f2e21] rounded-full py-2.5 hover:bg-black transition">Sign Up</a>
                    </div>
                    <div id="mobileAuthLoggedIn" class="<?= $navbarAuthenticated ? 'border-t border-gray-100 pt-3 mt-2 space-y-1' : 'hidden border-t border-gray-100 pt-3 mt-2 space-y-1' ?>">
                        <a href="profile" class="block px-4 py-2.5 text-sm font-bold text-gray-700 hover:bg-gray-50 hover:text-emerald-700 rounded-lg transition">My Profile</a>
                        <a href="settings" class="block px-4 py-2.5 text-sm font-bold text-gray-700 hover:bg-gray-50 hover:text-emerald-700 rounded-lg transition">Account Settings</a>
                        <a href="results" class="block px-4 py-2.5 text-sm font-bold text-gray-700 hover:bg-gray-50 hover:text-emerald-700 rounded-lg transition">My Results</a>
                        <a href="logout" class="block px-4 py-2.5 text-sm font-bold text-red-600 hover:bg-red-50 rounded-lg transition">Log Out</a>
                    </div>
                </div>
            </div>
        </header>

        <script>
            // Make the server-verified session available before page apps mount.
            window.taluntonAuthenticated = <?= $navbarAuthenticated ? 'true' : 'false' ?>;
            try {
                const existingTaluntonUser = localStorage.getItem('talunton_user');
                if (existingTaluntonUser === '[object Object]' || existingTaluntonUser === 'undefined') {
                    localStorage.removeItem('talunton_user');
                }
                <?php if ($navbarAuthenticated): ?>
                localStorage.setItem('talunton_user', JSON.stringify(<?= json_encode(['user_id' => (int)$_SESSION['user_id'], 'full_name' => $navbarFullName, 'email' => $navbarEmail, 'user_type' => $_SESSION['user_type'] ?? ''], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT) ?>));
                <?php else: ?>
                localStorage.removeItem('talunton_user');
                <?php endif; ?>
            } catch (e) { /* The server session remains authoritative when browser storage is unavailable. */ }
        </script>

        <main id="main-content" class="flex-grow flex flex-col page-transition-enter">
            <?= $content ?>
        </main>
        
        <!-- Footer -->
        <footer class="bg-white border-t border-gray-200 py-8 text-center text-xs text-gray-500">
            <p>&copy; <?= date('Y') ?> Talunton Cavite Guidance. Adapted for RIASEC profiling.</p>
        </footer>
    </div>
    
    <script>
        // Keep UI-only account details aligned with the server-verified session.
        try {
            const existingTaluntonUser2 = localStorage.getItem('talunton_user');
            if (existingTaluntonUser2 === '[object Object]' || existingTaluntonUser2 === 'undefined') {
                localStorage.removeItem('talunton_user');
            }
            <?php if ($navbarAuthenticated): ?>
            localStorage.setItem('talunton_user', JSON.stringify(<?= json_encode(['user_id' => (int)$_SESSION['user_id'], 'full_name' => $navbarFullName, 'email' => $navbarEmail, 'user_type' => $_SESSION['user_type'] ?? ''], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT) ?>));
            <?php else: ?>
            localStorage.removeItem('talunton_user');
            <?php endif; ?>
        } catch (e) { /* The server session remains authoritative when browser storage is unavailable. */ }
        // Render account actions and identity from the verified server session on every route.
        (function () {
            const authenticated = <?= $navbarAuthenticated ? 'true' : 'false' ?>;
            const user = <?= $navbarAuthenticated ? json_encode(['full_name' => $navbarFullName, 'email' => $navbarEmail], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT) : 'null' ?>;
            document.getElementById('authLoggedOut')?.classList.toggle('hidden', authenticated);
            document.getElementById('authLoggedIn')?.classList.toggle('hidden', !authenticated);
            document.getElementById('mobileAuthLoggedOut')?.classList.toggle('hidden', authenticated);
            document.getElementById('mobileAuthLoggedIn')?.classList.toggle('hidden', !authenticated);

            const fullName = String(user?.full_name || '').trim();
            const firstName = fullName.split(/\s+/)[0] || '';
            const emailName = String(user?.email || '').trim().split('@')[0];
            const displayName = authenticated ? (firstName || emailName || 'User') : '';
            const initial = Array.from(displayName)[0]?.toLocaleUpperCase() || 'U';
            if (document.getElementById('userNameDisplay')) document.getElementById('userNameDisplay').textContent = displayName;
            if (document.getElementById('userAvatar')) document.getElementById('userAvatar').textContent = authenticated ? initial : '';
            
            // User dropdown
            document.addEventListener('click', (e) => {
                const btn = e.target.closest('#userMenuBtn');
                const dd = document.getElementById('userDropdown');
                if (btn) {
                    e.stopPropagation();
                    const isOpen = dd?.classList.toggle('hidden') === false;
                    btn.setAttribute('aria-expanded', String(isOpen));
                } else if (dd && !dd.contains(e.target)) {
                    dd?.classList.add('hidden');
                    document.getElementById('userMenuBtn')?.setAttribute('aria-expanded', 'false');
                }
            });
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') {
                    document.getElementById('userDropdown')?.classList.add('hidden');
                    document.getElementById('userMenuBtn')?.setAttribute('aria-expanded', 'false');
                }
            });
        })();

        // Burger menu
        (function () {
            document.addEventListener('click', function (e) {
                const burgerBtn = e.target.closest('#burgerBtn');
                const menu = document.getElementById('mobileMenu');
                const burgerIcon = document.getElementById('burgerIcon');
                const closeIcon = document.getElementById('closeIcon');
                const setMenuOpen = (isOpen) => {
                    menu.classList.toggle('hidden', !isOpen);
                    burgerBtn?.setAttribute('aria-expanded', String(isOpen));
                    burgerBtn?.setAttribute('aria-label', isOpen ? 'Close menu' : 'Open menu');
                    burgerIcon?.classList.toggle('hidden', isOpen);
                    closeIcon?.classList.toggle('hidden', !isOpen);
                };
                
                if (!menu) return;

                if (burgerBtn) {
                    e.stopPropagation();
                    const isOpen = !menu.classList.contains('hidden');
                    setMenuOpen(!isOpen);
                } else if (e.target.closest('#mobileMenu a')) {
                    setMenuOpen(false);
                } else if (!menu.contains(e.target)) {
                    setMenuOpen(false);
                }
            });
            document.addEventListener('keydown', function (e) {
                if (e.key !== 'Escape') return;
                document.getElementById('mobileMenu')?.classList.add('hidden');
                document.getElementById('burgerBtn')?.setAttribute('aria-expanded', 'false');
                document.getElementById('burgerBtn')?.setAttribute('aria-label', 'Open menu');
                document.getElementById('burgerIcon')?.classList.remove('hidden');
                document.getElementById('closeIcon')?.classList.add('hidden');
            });
        })();

        // Global save functions for colleges and degrees
        window.saveDegree = function(btn, degreeId) {
            const userDataStr = localStorage.getItem('talunton_user');
            if (!userDataStr) {
                window.location.href = 'login';
                return Promise.resolve(false);
            }
            if (btn.disabled) return Promise.resolve(false);
            
            const svg = btn.querySelector('svg');
            const isFilled = svg.getAttribute('fill') === 'currentColor';
            const originalFill = svg.getAttribute('fill');
            const originalClassName = btn.className;
            
            if (isFilled) {
                svg.setAttribute('fill', 'none');
                btn.classList.remove('text-emerald-600', 'bg-emerald-50');
                btn.classList.add('text-gray-400', 'hover:text-emerald-600', 'bg-gray-50', 'hover:bg-emerald-50');
            } else {
                svg.setAttribute('fill', 'currentColor');
                btn.classList.remove('text-gray-400', 'hover:text-emerald-600', 'bg-gray-50', 'hover:bg-emerald-50');
                btn.classList.add('text-emerald-600', 'bg-emerald-50');
            }
            
            const csrfMeta = document.querySelector('meta[name="csrf-token"]');
            const csrfToken = csrfMeta ? csrfMeta.content : '';
            
            btn.disabled = true;
            btn.setAttribute('aria-busy', 'true');
            return fetch('api/save_degree', {
                method: 'POST',
                headers: { 
                    'Content-Type': 'application/json',
                    'X-CSRF-Token': csrfToken
                },
                body: JSON.stringify({ degree_id: degreeId })
            })
            .then(res => {
                if (!res.ok) throw new Error('Server returned HTTP ' + res.status);
                return res.json();
            })
            .then(data => {
                if(!data.success) {
                    svg.setAttribute('fill', originalFill);
                    btn.className = originalClassName;
                    window.showToast?.(data.error || 'Failed to update shortlist', 'error');
                    return false;
                }
                const action = data.action || (isFilled ? 'removed' : 'added');
                window.showToast?.(action === 'removed' ? 'Removed program from shortlist' : 'Program saved to your shortlist!', action === 'removed' ? 'info' : 'success');
                return true;
            })
            .catch(err => {
                console.error(err);
                svg.setAttribute('fill', originalFill);
                btn.className = originalClassName;
                window.showToast?.('Network error while saving', 'error');
                return false;
            })
            .finally(() => {
                btn.disabled = false;
                btn.removeAttribute('aria-busy');
            });
        };

        window.saveCollege = function(btn, collegeId) {
            const userDataStr = localStorage.getItem('talunton_user');
            if (!userDataStr) {
                window.location.href = 'login';
                return Promise.resolve(false);
            }
            if (btn.disabled) return Promise.resolve(false);
            
            const isIconOnly = btn.dataset.iconOnly === 'true' || btn.classList.contains('rounded-full');
            const svg = btn.querySelector('svg');
            const isSaved = btn.dataset.saved === 'true' || (svg && svg.getAttribute('fill') === 'currentColor') || btn.innerHTML.includes('Saved!');
            const originalHtml = btn.innerHTML;
            const originalClassName = btn.className;
            const originalSavedState = btn.dataset.saved;
            const originalAriaPressed = btn.getAttribute('aria-pressed');
            
            if (isIconOnly) {
                if (svg) svg.setAttribute('fill', isSaved ? 'none' : 'currentColor');
                btn.classList.toggle('text-emerald-700', !isSaved);
                btn.classList.toggle('text-gray-700', isSaved);
            } else {
                if (isSaved) {
                    btn.innerHTML = 'Save';
                    btn.classList.remove('bg-gray-800', 'hover:bg-gray-900');
                    btn.classList.add('bg-emerald-600', 'hover:bg-emerald-700');
                } else {
                    btn.innerHTML = `<svg class="w-4 h-4 inline-block mr-1" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24"><path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg> Saved!`;
                    btn.classList.remove('bg-emerald-600', 'hover:bg-emerald-700');
                    btn.classList.add('bg-gray-800', 'hover:bg-gray-900');
                }
            }
            btn.dataset.saved = String(!isSaved);
            btn.setAttribute('aria-pressed', String(!isSaved));
            
            const csrfMeta = document.querySelector('meta[name="csrf-token"]');
            const csrfToken = csrfMeta ? csrfMeta.content : '';
            
            btn.disabled = true;
            btn.setAttribute('aria-busy', 'true');
            return fetch('api/save_college', {
                method: 'POST',
                headers: { 
                    'Content-Type': 'application/json',
                    'X-CSRF-Token': csrfToken
                },
                body: JSON.stringify({ college_id: collegeId })
            })
            .then(res => {
                if (!res.ok) throw new Error('Server returned HTTP ' + res.status);
                return res.json();
            })
            .then(data => {
                if(!data.success) {
                    // Revert button state
                    btn.innerHTML = originalHtml;
                    btn.className = originalClassName;
                    if (originalSavedState === undefined) delete btn.dataset.saved;
                    else btn.dataset.saved = originalSavedState;
                    if (originalAriaPressed === null) btn.removeAttribute('aria-pressed');
                    else btn.setAttribute('aria-pressed', originalAriaPressed);

                    if (window.showToast) {
                        window.showToast(data.error || 'Failed to update college', 'error');
                    } else {
                        alert('Error: ' + (data.error || 'Unknown error'));
                    }
                    return false;
                } else {
                    const action = data.action || (isSaved ? 'removed' : 'added');
                    const savedAfter = action === 'added';
                    btn.dataset.saved = String(savedAfter);
                    btn.setAttribute('aria-pressed', String(savedAfter));
                    if (isIconOnly) {
                        if (svg) svg.setAttribute('fill', savedAfter ? 'currentColor' : 'none');
                        btn.classList.toggle('text-emerald-700', savedAfter);
                        btn.classList.toggle('text-gray-700', !savedAfter);
                    } else {
                        if (savedAfter) {
                            btn.innerHTML = `<svg class="w-4 h-4 inline-block mr-1" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24"><path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg> Saved!`;
                            btn.classList.add('bg-gray-800', 'hover:bg-gray-900');
                            btn.classList.remove('bg-emerald-600', 'hover:bg-emerald-700');
                        } else {
                            btn.innerHTML = 'Save';
                            btn.classList.add('bg-emerald-600', 'hover:bg-emerald-700');
                            btn.classList.remove('bg-gray-800', 'hover:bg-gray-900');
                        }
                    }
                    window.showToast?.(action === 'removed' ? 'Removed campus from shortlist' : 'Campus saved to your shortlist!', action === 'removed' ? 'info' : 'success');
                    return true;
                }
            })
            .catch(err => {
                console.error(err);
                btn.innerHTML = originalHtml;
                btn.className = originalClassName;
                if (originalSavedState === undefined) delete btn.dataset.saved;
                else btn.dataset.saved = originalSavedState;
                if (originalAriaPressed === null) btn.removeAttribute('aria-pressed');
                else btn.setAttribute('aria-pressed', originalAriaPressed);
                if (window.showToast) window.showToast('Network error while saving', 'error');
                return false;
            })
            .finally(() => {
                btn.disabled = false;
                btn.removeAttribute('aria-busy');
            });
        };
    </script>
    <script>
        // Revalidate protected pages restored from browser history before showing cached private content.
        window.addEventListener('pageshow', async (event) => {
            if (!event.persisted) return;
            const route = window.location.pathname.replace(/\/+$/, '').split('/').pop();
            if (!['assessment', 'results', 'course-quiz'].includes(route)) return;
            const params = new URLSearchParams(window.location.search);
            const target = route === 'course-quiz' && params.has('degree_id')
                ? 'course-quiz?degree_id=' + params.get('degree_id')
                : route === 'assessment' && params.has('retake')
                    ? 'assessment?retake=' + params.get('retake')
                    : route;
            document.body.style.visibility = 'hidden';
            try {
                const response = await fetch('api/authorize_assessment?return_to=' + encodeURIComponent(target), { cache: 'no-store' });
                const data = await response.json();
                if (response.status === 401) {
                    window.location.replace(data.redirect || ('login?return=' + encodeURIComponent(target)));
                    return;
                }
                document.body.style.visibility = '';
            } catch (e) {
                window.location.replace('login?return=' + encodeURIComponent(target));
            }
        });
    </script>
    <script src="assets/js/ux-enhancements.js"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script src="campus-map.js"></script>
</body>
</html>


