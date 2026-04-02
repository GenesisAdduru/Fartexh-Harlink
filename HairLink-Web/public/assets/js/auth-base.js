const container = document.getElementById('authContainer');
const registerBtn = document.querySelector('.register-btn');
const loginBtn = document.querySelector('.login-btn');
const adminDemoButton = document.getElementById('fillAdminDemo');
const donorDemoButton = document.getElementById('fillDonorDemo');
const recipientDemoButton = document.getElementById('fillRecipientDemo');
const staffDemoButton = document.getElementById('fillStaffDemo');
const wigmakerDemoButton = document.getElementById('fillWigmakerDemo');

function fillDemo(userType) {
    const emailField = document.getElementById('loginEmail');
    const passwordField = document.getElementById('loginPassword');
    if (emailField) emailField.value = userType === 'recipient' ? 'recipient.demo@hairlink.local' : 'donor.demo@hairlink.local';
    if (passwordField) passwordField.value = 'password123';
}

function setMode(mode) {
    if (!container) return;
    if (mode === 'register') {
        container.classList.add('active');
    } else {
        container.classList.remove('active');
    }
}

if (registerBtn) {
    registerBtn.addEventListener('click', () => setMode('register'));
}

if (loginBtn) {
    loginBtn.addEventListener('click', () => setMode('login'));
}

function clearErrors(formType) {
    document.querySelectorAll(`[id^="error-${formType}-"]`).forEach(el => {
        el.innerText = '';
        el.style.display = 'none';
    });
}

function showErrors(formType, errors) {
    for (const [field, messages] of Object.entries(errors)) {
        const errorEl = document.getElementById(`error-${formType}-${field}`);
        if (errorEl) {
            errorEl.innerText = messages[0];
            errorEl.style.display = 'block';
        }
    }
}

/**
 * Single AJAX submit handler — the ONLY place we listen for form submit.
 */
function handleAjaxSubmit(form, formType) {
    if (!form) return;
    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        clearErrors(formType);

        const btn = form.querySelector('button[type="submit"]');
        const loader = document.getElementById('fullScreenLoader');
        const loaderText = document.getElementById('loaderText');
        const originalText = btn ? btn.innerText : '';
        
        if (btn) btn.disabled = true;
        if (loader) {
            loaderText.innerText = formType === 'login' ? 'Logging in...' : 'Creating your account...';
            loader.style.display = 'flex';
        }

        const formData = new FormData(form);
        const url = form.getAttribute('action');

        try {
            const response = await fetch(url, {
                method: 'POST',
                body: formData,
                headers: { 'Accept': 'application/json' }
            });

            const data = await response.json();

            if (response.ok && data.redirect) {
                if (loaderText) loaderText.innerText = 'Redirecting...';
                window.location.href = data.redirect;
                return;
            }

            if (response.status === 422 && data.errors) {
                showErrors(formType, data.errors);
            } else {
                const msg = data.message || 'Something went wrong. Please try again.';
                const errorEl = document.getElementById(`error-${formType}-email`);
                if (errorEl) {
                    errorEl.innerText = msg;
                    errorEl.style.display = 'block';
                } else {
                    alert(msg);
                }
            }
        } catch (err) {
            console.error('Submission error', err);
            alert('A network error occurred. Please check your connection.');
        } finally {
            if (btn) btn.disabled = false;
            // Delay hiding the loader slightly in case of instant redirect
            setTimeout(() => {
                if (loader) loader.style.display = 'none';
            }, 300);
        }
    });
}

function setupRegisterFlow() {
    const registerForm = document.getElementById('registerForm');
    handleAjaxSubmit(registerForm, 'register');

    const passwordInput = document.getElementById('registerPassword');
    const confirmInput  = document.getElementById('registerConfirmPassword');
    const emailInput    = document.getElementById('registerEmail');

    if (passwordInput && confirmInput) {
        const validatePassword = () => {
            const val = passwordInput.value;
            const errorEl = document.getElementById('error-register-password');
            if (val.length > 0 && val.length < 8) {
                errorEl.innerText = 'Password must be at least 8 characters.';
                errorEl.style.display = 'block';
            } else {
                errorEl.style.display = 'none';
            }
            validateMatch();
        };
        const validateMatch = () => {
            const errorEl = document.getElementById('error-register-password_confirmation');
            if (confirmInput.value.length > 0 && confirmInput.value !== passwordInput.value) {
                errorEl.innerText = 'The password confirmation does not match.';
                errorEl.style.display = 'block';
            } else {
                errorEl.style.display = 'none';
            }
        };
        passwordInput.addEventListener('input', validatePassword);
        confirmInput.addEventListener('input', validateMatch);
    }

    if (emailInput) {
        emailInput.addEventListener('input', () => {
            const val = emailInput.value;
            const errorEl = document.getElementById('error-register-email');
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (val.length > 0 && !emailRegex.test(val)) {
                errorEl.innerText = 'Please enter a valid email address.';
                errorEl.style.display = 'block';
            } else {
                errorEl.style.display = 'none';
            }
        });
    }

    // Enforce digits-only for age and postal_code inputs
    const ageInput    = document.querySelector('input[name="age"]');
    const postalInput = document.querySelector('input[name="postal_code"]');
    const phoneInput  = document.querySelector('input[name="phone"]');

    [ageInput, postalInput].forEach(input => {
        if (!input) return;
        input.setAttribute('inputmode', 'numeric');
        input.addEventListener('input', () => {
            input.value = input.value.replace(/[^0-9]/g, '');
        });
        input.addEventListener('keydown', e => {
            const allowed = ['Backspace','Delete','ArrowLeft','ArrowRight','Tab','Home','End'];
            if (!allowed.includes(e.key) && !/^[0-9]$/.test(e.key)) {
                e.preventDefault();
            }
        });
    });

    if (phoneInput) {
        phoneInput.setAttribute('inputmode', 'tel');
        phoneInput.addEventListener('input', () => {
            phoneInput.value = phoneInput.value.replace(/[^0-9\-\+\s\(\)]/g, '');
        });
    }
}

function setupLoginFlow() {
    // Demo fill buttons — fill fields only, no redirects
    if (adminDemoButton) {
        adminDemoButton.addEventListener('click', () => {
            const emailField    = document.getElementById('loginEmail');
            const passwordField = document.getElementById('loginPassword');
            if (emailField)    emailField.value    = 'admin@hairlink.local';
            if (passwordField) passwordField.value = 'admin12345';
        });
    }
    if (donorDemoButton)     donorDemoButton.addEventListener('click', () => fillDemo('donor'));
    if (recipientDemoButton) recipientDemoButton.addEventListener('click', () => fillDemo('recipient'));
    if (staffDemoButton) {
        staffDemoButton.addEventListener('click', () => {
            const emailField    = document.getElementById('loginEmail');
            const passwordField = document.getElementById('loginPassword');
            if (emailField)    emailField.value    = 'staff.demo@hairlink.local';
            if (passwordField) passwordField.value = 'password123';
        });
    }
    if (wigmakerDemoButton) {
        wigmakerDemoButton.addEventListener('click', () => {
            const emailField    = document.getElementById('loginEmail');
            const passwordField = document.getElementById('loginPassword');
            if (emailField)    emailField.value    = 'wigmaker.demo@hairlink.local';
            if (passwordField) passwordField.value = 'password123';
        });
    }

    // SINGLE AJAX submit listener for login form — no duplicate
    const loginForm = document.getElementById('loginForm');
    handleAjaxSubmit(loginForm, 'login');
}

document.addEventListener('DOMContentLoaded', () => {
    const initialMode = container?.dataset?.initialMode;
    const params = new URLSearchParams(window.location.search);
    const mode = params.get('mode');

    if (initialMode === 'register' || initialMode === 'login') {
        setMode(initialMode);
    } else if (mode === 'register' || mode === 'login') {
        setMode(mode);
    } else {
        setMode('register');
    }

    setupRegisterFlow();
    setupLoginFlow();
});
