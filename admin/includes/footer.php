        </main>
    </div>
</div>
<!-- Admin Confirmation / Action Modal -->
<div id="adminConfirmModal" class="admin-modal-backdrop" aria-hidden="true" role="dialog" aria-modal="true">
    <div class="admin-modal-card">
        <div class="admin-modal-header">
            <div class="admin-modal-icon-wrap icon-amber" id="adminModalIcon">
                <!-- SVG icon injected by JS -->
            </div>
            <div class="admin-modal-title-wrap">
                <h3 id="adminModalTitle" class="admin-modal-title">Confirm Action</h3>
            </div>
            <button type="button" class="admin-modal-close" id="adminModalClose" aria-label="Close modal">&times;</button>
        </div>
        <div class="admin-modal-body" id="adminModalBody">
            Are you sure you want to proceed?
        </div>
        <div class="admin-modal-footer">
            <button type="button" class="btn btn-light" id="adminModalCancel">Cancel</button>
            <button type="button" class="btn btn-amber" id="adminModalSubmit">Confirm</button>
        </div>
    </div>
</div>

<script>
// Custom in-DOM confirmation modal for destructive and state-changing actions
(function() {
    const modal = document.getElementById('adminConfirmModal');
    if (!modal) return;
    const titleEl = document.getElementById('adminModalTitle');
    const bodyEl = document.getElementById('adminModalBody');
    const iconEl = document.getElementById('adminModalIcon');
    const cancelBtn = document.getElementById('adminModalCancel');
    const closeBtn = document.getElementById('adminModalClose');
    const submitBtn = document.getElementById('adminModalSubmit');

    let pendingForm = null;

    const icons = {
        archive: '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" /></svg>',
        restore: '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" /></svg>',
        delete: '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>',
        warning: '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>'
    };

    function closeModal() {
        modal.classList.remove('is-open');
        modal.setAttribute('aria-hidden', 'true');
        pendingForm = null;
    }

    function openModal(options, form) {
        pendingForm = form;
        titleEl.textContent = options.title || 'Confirm Action';
        bodyEl.innerHTML = options.message || 'Are you sure you want to proceed?';
        
        const iconType = options.icon || (options.title.toLowerCase().includes('archive') ? 'archive' : 'warning');
        iconEl.innerHTML = icons[iconType] || icons.warning;
        iconEl.className = 'admin-modal-icon-wrap ' + (
            iconType === 'archive' ? 'icon-amber' :
            iconType === 'restore' ? 'icon-green' :
            iconType === 'delete' ? 'icon-red' : 'icon-amber'
        );

        submitBtn.textContent = options.btnText || 'Confirm';
        submitBtn.className = 'btn ' + (options.btnClass || (iconType === 'archive' ? 'btn-amber' : (iconType === 'delete' ? 'btn-danger' : 'btn-primary')));

        modal.classList.add('is-open');
        modal.setAttribute('aria-hidden', 'false');
        submitBtn.focus();
    }

    cancelBtn.addEventListener('click', closeModal);
    closeBtn.addEventListener('click', closeModal);
    modal.addEventListener('click', function(e) {
        if (e.target === modal) closeModal();
    });
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && modal.classList.contains('is-open')) closeModal();
    });

    submitBtn.addEventListener('click', function() {
        if (pendingForm) {
            const form = pendingForm;
            closeModal();
            form.dataset.confirmed = 'true';
            HTMLFormElement.prototype.submit.call(form);
        }
    });

    document.addEventListener('submit', function(e) {
        const form = e.target;
        if (!form || !form.matches) return;
        if (!form.matches('form[data-confirm], form[data-modal-message], form.js-confirm-form')) return;
        
        if (form.dataset.confirmed === 'true') {
            delete form.dataset.confirmed;
            return;
        }

        e.preventDefault();

        const rawConfirm = form.getAttribute('data-confirm');
        const rawMessage = form.getAttribute('data-modal-message');
        const message = rawMessage || (rawConfirm ? rawConfirm.replace(/</g, '&lt;').replace(/>/g, '&gt;') : 'Are you sure you want to proceed?');

        let title = form.getAttribute('data-modal-title');
        if (!title) {
            if (rawConfirm && rawConfirm.toLowerCase().startsWith('delete')) {
                title = 'Confirm Delete';
            } else if (rawConfirm && rawConfirm.toLowerCase().startsWith('archive')) {
                title = 'Archive School';
            } else {
                title = 'Confirm Action';
            }
        }

        let btnText = form.getAttribute('data-modal-btn');
        if (!btnText) {
            if (rawConfirm && rawConfirm.toLowerCase().includes('delete')) {
                btnText = 'Delete';
            } else if (rawConfirm && rawConfirm.toLowerCase().includes('archive')) {
                btnText = 'Archive';
            } else {
                btnText = 'Confirm';
            }
        }

        let btnClass = form.getAttribute('data-modal-btn-class');
        if (!btnClass) {
            if (btnText.toLowerCase().includes('delete')) {
                btnClass = 'btn-danger';
            } else if (btnText.toLowerCase().includes('archive')) {
                btnClass = 'btn-amber';
            } else {
                btnClass = 'btn-primary';
            }
        }

        let icon = form.getAttribute('data-modal-icon');
        if (!icon) {
            if (btnText.toLowerCase().includes('archive') || title.toLowerCase().includes('archive')) {
                icon = 'archive';
            } else if (btnText.toLowerCase().includes('restore') || title.toLowerCase().includes('restore')) {
                icon = 'restore';
            } else if (btnText.toLowerCase().includes('delete')) {
                icon = 'delete';
            } else {
                icon = 'warning';
            }
        }

        openModal({
            title: title,
            message: message,
            btnText: btnText,
            btnClass: btnClass,
            icon: icon
        }, form);
    });
})();

// Periodic heartbeat to refresh admin last_activity while the browser tab remains open (every 3 minutes)
(function() {
    const metaToken = document.querySelector('meta[name="csrf-token"]');
    if (!metaToken) return;
    const csrfToken = metaToken.content;

    setInterval(function() {
        if (document.visibilityState === 'visible') {
            fetch('heartbeat.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'csrf_token=' + encodeURIComponent(csrfToken)
            }).then(res => {
                if (res.status === 403 || res.status === 401 || res.redirected) {
                    window.location.reload();
                }
            }).catch(() => {});
        }
    }, 180000); // 3 minutes
})();
</script>
</body>
</html>
