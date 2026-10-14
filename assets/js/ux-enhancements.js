/**
 * Talunton Cavite - UX & UI Enhancements Script
 * Smooth Page Transitions, Nav Highlighting, Toast Notifications, & Micro-Interactions
 * 100% Non-destructive and backward compatible
 */

(function () {
    'use strict';

    // ── 1. Page Progress Bar & Transitions ──
    let progressBar = null;
    let isNavigating = false;
    let navigationTimeout = null;
    let navigationTransitionHandler = null;

    function initProgressBar() {
        if (!document.getElementById('pageProgressBar')) {
            progressBar = document.createElement('div');
            progressBar.id = 'pageProgressBar';
            document.body.prepend(progressBar);
        } else {
            progressBar = document.getElementById('pageProgressBar');
        }
    }

    function startProgress() {
        if (!progressBar) return;
        progressBar.classList.add('is-loading');
        progressBar.style.width = '30%';
        setTimeout(() => {
            if (isNavigating && progressBar) progressBar.style.width = '75%';
        }, 120);
    }

    function completeProgress() {
        if (!progressBar) return;
        progressBar.style.width = '100%';
        setTimeout(() => {
            if (progressBar) {
                progressBar.classList.remove('is-loading');
                progressBar.style.width = '0%';
            }
        }, 220);
    }

    function resetTransitions() {
        isNavigating = false;
        clearTimeout(navigationTimeout);
        navigationTimeout = null;
        const main = document.querySelector('main');
        if (main) {
            if (navigationTransitionHandler) {
                main.removeEventListener('transitionend', navigationTransitionHandler);
            }
            main.classList.remove('page-transition-leave');
            main.classList.add('page-transition-enter');
        }
        navigationTransitionHandler = null;
        completeProgress();
    }

    function setupPageTransitions() {
        const main = document.querySelector('main');
        if (main) {
            main.classList.add('page-transition-enter');
        }

        // Intercept internal link clicks for smooth transitions
        document.addEventListener('click', function (e) {
            const anchor = e.target.closest('a');
            if (!anchor) return;

            const href = anchor.getAttribute('href');
            if (!href) return;

            // Ignore external links, anchors, new tabs, modifier keys, protocols, and downloads
            if (
                anchor.target === '_blank' ||
                anchor.hasAttribute('download') ||
                anchor.getAttribute('rel') === 'external' ||
                anchor.dataset.noTransition !== undefined ||
                e.ctrlKey || e.metaKey || e.shiftKey || e.altKey ||
                e.button !== 0 ||
                href.startsWith('#') ||
                href.startsWith('javascript:') ||
                href.startsWith('mailto:') ||
                href.startsWith('tel:') ||
                href.startsWith('http://') ||
                href.startsWith('https://')
            ) {
                return;
            }

            const targetUrl = new URL(anchor.href, window.location.href);

            // If navigating to the exact same URL + query, don't animate leave
            if (targetUrl.href === window.location.href) {
                return;
            }

            if (isNavigating) {
                e.preventDefault();
                return;
            }

            if (targetUrl.origin === window.location.origin && /\/logout\/?$/i.test(targetUrl.pathname)) {
                window.queueToast('You have been logged out.', 'info');
            }

            if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
                return;
            }

            // Allow smooth fade out
            e.preventDefault();
            isNavigating = true;
            startProgress();

            const navigate = () => {
                if (!isNavigating) return;
                isNavigating = false;
                clearTimeout(navigationTimeout);
                navigationTimeout = null;
                if (main && navigationTransitionHandler) {
                    main.removeEventListener('transitionend', navigationTransitionHandler);
                }
                navigationTransitionHandler = null;
                window.location.assign(targetUrl.href);
            };

            if (main) {
                main.classList.remove('page-transition-enter');
                void main.offsetHeight;
                main.classList.add('page-transition-leave');
                navigationTransitionHandler = (event) => {
                    if (event.target === main && event.propertyName === 'opacity') navigate();
                };
                main.addEventListener('transitionend', navigationTransitionHandler);
                navigationTimeout = setTimeout(navigate, 220);
            } else {
                navigate();
            }
        });

        // Handle browser back/forward cache
        window.addEventListener('pageshow', function (event) {
            resetTransitions();
        });
    }

    // ── 2. Active Navigation Item Highlight ──
    function setupActiveNav() {
        const path = window.location.pathname.toLowerCase();
        const search = window.location.search.toLowerCase();
        const navLinks = document.querySelectorAll('nav a, #mobileMenu a');

        navLinks.forEach(link => {
            const href = (link.getAttribute('href') || '').toLowerCase();
            if (!href || href === '#' || href === 'logout') return;

            // Normalize match
            let isCurrent = false;

            if (href === 'home' || href === '/') {
                isCurrent = path.endsWith('/riasec') || path.endsWith('/riasec/') || path.endsWith('/home') || path === '/' || search.includes('url=home') || search.includes('url=/home') || (!search.includes('url=') && (path.endsWith('/riasec') || path.endsWith('/riasec/')));
            } else {
                isCurrent = path.includes('/' + href) || path.endsWith(href) || search.includes('url=' + href) || search.includes('url=/' + href);
            }

            if (isCurrent) {
                link.classList.add('nav-link-active');
                link.setAttribute('aria-current', 'page');
            } else {
                link.classList.remove('nav-link-active');
                link.removeAttribute('aria-current');
            }
        });
    }

    // ── 3. Header Scroll Elevation ──
    function setupHeaderScroll() {
        const header = document.querySelector('header');
        if (!header) return;

        function updateHeader() {
            if (window.scrollY > 15) {
                header.classList.add('header-scrolled');
            } else {
                header.classList.remove('header-scrolled');
            }
        }

        window.addEventListener('scroll', updateHeader, { passive: true });
        updateHeader();
    }

    // ── 4. Toast Notification System ──
    function ensureToastContainer() {
        let container = document.getElementById('toastContainer');
        if (!container) {
            container = document.createElement('div');
            container.id = 'toastContainer';
            container.setAttribute('aria-label', 'Notifications');
            container.setAttribute('aria-live', 'polite');
            container.setAttribute('aria-relevant', 'additions');
            document.body.appendChild(container);
        }
        return container;
    }

    window.showToast = function (message, type = 'success', duration) {
        const container = ensureToastContainer();
        const toastType = ['success', 'error', 'warning', 'info'].includes(type) ? type : 'info';
        const messageDuration = duration ?? (toastType === 'error' ? 7000 : 3500);
        const toast = document.createElement('div');
        toast.className = `talunton-toast toast-${toastType}`;
        toast.setAttribute('role', toastType === 'error' ? 'alert' : 'status');
        toast.setAttribute('aria-atomic', 'true');

        let iconSvg = '';
        if (toastType === 'success') {
            iconSvg = `<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>`;
        } else if (toastType === 'error') {
            iconSvg = `<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>`;
        } else if (toastType === 'warning') {
            iconSvg = `<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>`;
        } else {
            iconSvg = `<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>`;
        }

        const icon = document.createElement('div');
        icon.className = 'toast-icon';
        icon.innerHTML = iconSvg;

        const toastMessage = document.createElement('div');
        toastMessage.className = 'toast-message';
        toastMessage.textContent = String(message ?? '');

        const closeButton = document.createElement('button');
        closeButton.className = 'toast-close';
        closeButton.type = 'button';
        closeButton.setAttribute('aria-label', 'Close notification');
        closeButton.innerHTML = '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>';
        toast.append(icon, toastMessage, closeButton);

        let dismissTimer;
        let dismissed = false;
        function dismiss() {
            if (dismissed) return;
            dismissed = true;
            clearTimeout(dismissTimer);
            toast.classList.add('toast-leave');
            setTimeout(() => {
                if (toast.parentNode) toast.parentNode.removeChild(toast);
            }, 200);
        }

        closeButton.addEventListener('click', dismiss);
        container.appendChild(toast);

        if (messageDuration > 0) {
            dismissTimer = setTimeout(dismiss, messageDuration);
        }
    };

    window.queueToast = function (message, type = 'success') {
        try {
            sessionStorage.setItem('talunton_flash_toast', JSON.stringify({ message, type }));
        } catch (error) {}
    };

    // ── 5. Back to Top Button ──
    function setupBackToTop() {
        const btn = document.createElement('button');
        btn.id = 'backToTopBtn';
        btn.setAttribute('aria-label', 'Scroll back to top');
        btn.innerHTML = `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>`;
        document.body.appendChild(btn);

        window.addEventListener('scroll', function () {
            if (window.scrollY > 320) {
                btn.classList.add('visible');
            } else {
                btn.classList.remove('visible');
            }
        }, { passive: true });

        btn.addEventListener('click', function () {
            const behavior = window.matchMedia('(prefers-reduced-motion: reduce)').matches ? 'auto' : 'smooth';
            window.scrollTo({ top: 0, behavior });
        });
    }

    // ── 6. Card Staggered Reveal via Intersection Observer ──
    function setupScrollReveal() {
        if (!('IntersectionObserver' in window)) return;

        const observer = new IntersectionObserver((entries, obs) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                    obs.unobserve(entry.target);
                }
            });
        }, {
            root: null,
            threshold: 0.08,
            rootMargin: '0px 0px -20px 0px'
        });

        const revealTargets = document.querySelectorAll(
            'section:not(:first-child) .grid > div, .card-elevated, .feature-card'
        );

        revealTargets.forEach((el, index) => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(12px)';
            el.style.transition = `opacity 0.4s ease ${(index % 4) * 0.07}s, transform 0.4s cubic-bezier(0.16, 1, 0.3, 1) ${(index % 4) * 0.07}s`;
            observer.observe(el);
        });
    }

    // ── Initialize on DOM Ready ──
    document.addEventListener('DOMContentLoaded', function () {
        initProgressBar();
        setupPageTransitions();
        setupActiveNav();
        setupHeaderScroll();
        setupBackToTop();

        try {
            const queuedToast = sessionStorage.getItem('talunton_flash_toast');
            if (queuedToast) {
                sessionStorage.removeItem('talunton_flash_toast');
                const { message, type } = JSON.parse(queuedToast);
                if (message) window.showToast(message, type);
            }
        } catch (error) {
            try {
                sessionStorage.removeItem('talunton_flash_toast');
            } catch (storageError) {}
        }

        // Run subtle scroll reveal after slight tick to prevent layout flashes
        setTimeout(setupScrollReveal, 100);
    });

})();
