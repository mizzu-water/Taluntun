<?php
$file = 'app/Views/signup.html';
$html = file_get_contents($file);

$js = '
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const form = document.getElementById("signupForm");
        const btn = document.getElementById("submitBtn");
        const btnText = document.getElementById("submitText");
        const spinner = document.getElementById("submitSpinner");
        const globalError = document.getElementById("globalError");
        const globalErrorText = document.getElementById("globalErrorText");
        
        // Password toggle
        const toggleBtn = document.getElementById("togglePassword");
        const passwordInput = document.getElementById("password");
        if(toggleBtn && passwordInput) {
            toggleBtn.addEventListener("click", () => {
                const type = passwordInput.getAttribute("type") === "password" ? "text" : "password";
                passwordInput.setAttribute("type", type);
                toggleBtn.innerHTML = type === "password" ? 
                    \'<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>\' : 
                    \'<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path></svg>\';
            });
        }

        // Password strength
        const strengthBar = document.getElementById("strengthBar");
        const strengthLabel = document.getElementById("strengthLabel");
        if(passwordInput && strengthBar) {
            passwordInput.addEventListener("input", (e) => {
                const val = e.target.value;
                let strength = 0;
                if(val.length >= 8) strength++;
                if(/[A-Z]/.test(val)) strength++;
                if(/[0-9]/.test(val)) strength++;
                if(/[^A-Za-z0-9]/.test(val)) strength++;
                
                let width = "0%"; let color = "#ef4444"; let label = "Too weak";
                if(strength === 1) { width = "25%"; color = "#ef4444"; label = "Weak"; }
                if(strength === 2) { width = "50%"; color = "#f59e0b"; label = "Fair"; }
                if(strength === 3) { width = "75%"; color = "#10b981"; label = "Good"; }
                if(strength >= 4) { width = "100%"; color = "#059669"; label = "Strong"; }
                
                if(val === "") { width = "0%"; label = ""; }
                
                strengthBar.style.width = width;
                strengthBar.style.backgroundColor = color;
                strengthLabel.textContent = label;
                strengthLabel.style.color = color;
            });
        }

        const showError = (id, msg) => {
            const el = document.getElementById(id + "Error");
            if(el) { el.textContent = msg; el.style.display = "block"; }
            const input = document.getElementById(id);
            if(input) { input.classList.add("border-red-400", "bg-red-50"); }
        };

        const clearErrors = () => {
            document.querySelectorAll(".error-msg").forEach(e => { e.textContent = ""; e.style.display = "none"; });
            document.querySelectorAll("input, select").forEach(i => i.classList.remove("border-red-400", "bg-red-50"));
            globalError.classList.add("hidden");
        };

        if(form) {
            form.addEventListener("submit", async (e) => {
                e.preventDefault();
                clearErrors();
                
                const fullName = document.getElementById("full_name").value.trim();
                const email = document.getElementById("email").value.trim();
                const password = document.getElementById("password").value;
                const confirmPassword = document.getElementById("confirm_password").value;
                const userType = document.getElementById("user_type").value;
                const agree = document.getElementById("agree").checked;

                let hasError = false;

                if(!fullName) { showError("full_name", "Full name is required"); hasError = true; }
                if(!email) { showError("email", "Email is required"); hasError = true; }
                else if(!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) { showError("email", "Invalid email format"); hasError = true; }
                
                if(!password) { showError("password", "Password is required"); hasError = true; }
                else if(password.length < 8) { showError("password", "Password must be at least 8 characters"); hasError = true; }
                
                if(password !== confirmPassword) { showError("confirm_password", "Passwords do not match"); hasError = true; }
                if(!agree) { showError("agree", "You must agree to the Terms of Use"); hasError = true; }

                if(hasError) return;

                btn.disabled = true;
                btnText.textContent = "Creating Account...";
                spinner.classList.remove("hidden");

                try {
                    const res = await fetch("register", {
                        method: "POST",
                        headers: { "Content-Type": "application/json" },
                        body: JSON.stringify({ full_name: fullName, email, password, user_type: userType })
                    });
                    const data = await res.json();
                    
                    if(data.success) {
                        // Switch to verification step
                        document.getElementById("formStep").classList.add("hidden");
                        document.getElementById("successStep").classList.remove("hidden");
                        document.getElementById("confirmedEmail").textContent = email;
                        
                        if(data.dev_code) {
                            document.getElementById("devCodeBox").classList.remove("hidden");
                            document.getElementById("devCode").textContent = data.dev_code;
                        }
                    } else {
                        if(data.errors) {
                            Object.keys(data.errors).forEach(key => showError(key, data.errors[key]));
                        } else {
                            globalError.classList.remove("hidden");
                            globalErrorText.textContent = data.error || "Registration failed.";
                        }
                    }
                } catch(err) {
                    globalError.classList.remove("hidden");
                    globalErrorText.textContent = "A network error occurred. Please try again.";
                }

                btn.disabled = false;
                btnText.textContent = "Create Account";
                spinner.classList.add("hidden");
            });
        }
        
        // Verification form logic
        const verifyForm = document.getElementById("verifyForm");
        if(verifyForm) {
            verifyForm.addEventListener("submit", async (e) => {
                e.preventDefault();
                const code = document.getElementById("verificationCode").value.trim();
                const vBtn = document.getElementById("verifyBtn");
                const vText = document.getElementById("verifyBtnText");
                const vSpinner = document.getElementById("verifySpinner");
                const vErr = document.getElementById("verificationCodeError");
                const vGlobal = document.getElementById("verifyGlobalError");
                const vGlobalText = document.getElementById("verifyGlobalErrorText");
                
                vErr.textContent = ""; vGlobal.classList.add("hidden");
                
                if(!code || code.length !== 6) {
                    vErr.textContent = "Please enter the 6-digit code";
                    return;
                }
                
                vBtn.disabled = true; vText.textContent = "Verifying..."; vSpinner.classList.remove("hidden");
                
                try {
                    const email = document.getElementById("email").value.trim();
                    const res = await fetch("verify_code", {
                        method: "POST",
                        headers: { "Content-Type": "application/json" },
                        body: JSON.stringify({ email, code })
                    });
                    const data = await res.json();
                    if(data.success) {
                        window.location.href = "assessment";
                    } else {
                        vGlobal.classList.remove("hidden");
                        vGlobalText.textContent = data.error || "Invalid code";
                    }
                } catch(err) {
                    vGlobal.classList.remove("hidden");
                    vGlobalText.textContent = "Network error";
                }
                
                vBtn.disabled = false; vText.textContent = "Verify Account"; vSpinner.classList.add("hidden");
            });
        }
    });
</script>
';

// If script tag already exists, skip
if (strpos($html, 'document.getElementById("signupForm")') === false) {
    file_put_contents($file, $html . "\n" . $js);
    echo "Frontend JavaScript added!";
} else {
    echo "JavaScript already exists.";
}
?>
