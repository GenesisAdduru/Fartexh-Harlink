const container = document.getElementById('authContainer');
const registerBtn = document.querySelector('.register-btn');
const loginBtn = document.querySelector('.login-btn');
const adminDemoButton = document.getElementById('fillAdminDemo');
const donorDemoButton = document.getElementById('fillDonorDemo');
const recipientDemoButton = document.getElementById('fillRecipientDemo');
const staffDemoButton = document.getElementById('fillStaffDemo');
const wigmakerDemoButton = document.getElementById('fillWigmakerDemo');
const ADMIN_DEMO_EMAIL = 'admin@hairlink.local';
const ADMIN_DEMO_PASSWORD = 'admin12345';
const DEMO_ACCOUNTS_KEY = 'hairlinkDemoAccountsV1';

<<<<<<< HEAD
function fillDemo(userType) {
    const emailField = document.getElementById('loginEmail');
    const passwordField = document.getElementById('loginPassword');
    if (emailField) emailField.value = userType === 'recipient' ? 'recipient.demo@hairlink.local' : 'donor.demo@hairlink.local';
    if (passwordField) passwordField.value = 'password123'; // assuming standard password for demo accounts
=======
function getDemoAccounts() {
    try {
        return JSON.parse(localStorage.getItem(DEMO_ACCOUNTS_KEY) || '[]');
    } catch (_error) {
        return [];
    }
}

function saveDemoAccounts(accounts) {
    localStorage.setItem(DEMO_ACCOUNTS_KEY, JSON.stringify(accounts));
}

function setCurrentUser(account) {
    if (!account) return;

    localStorage.setItem('hairlinkUserType', account.userType || 'donor');
    localStorage.setItem('hairlinkUserEmail', account.email || '');
    localStorage.setItem('hairlinkUserProfile', JSON.stringify(account.profile || {}));
}

function redirectByUserType(userType) {
    if (userType === 'staff') {
        alert('Login successful. Redirecting to staff dashboard.');
        window.location.href = '/staff/dashboard';
        return;
    }

    if (userType === 'wigmaker') {
        alert('Login successful. Redirecting to wigmaker dashboard.');
        window.location.href = '/wigmaker/dashboard';
        return;
    }

    if (userType === 'admin') {
        alert('Login successful. Redirecting to admin dashboard.');
        window.location.href = '/admin/dashboard';
        return;
    }

    if (userType === 'recipient') {
        alert('Login successful. Redirecting to recipient dashboard.');
        window.location.href = '/recipient/dashboard';
        return;
    }

    alert('Login successful. Redirecting to donor dashboard.');
    window.location.href = '/donor/dashboard';
}

function runRoleDemo(userType) {
    const account = {
        email: userType === 'recipient'
            ? 'recipient.demo@hairlink.local'
            : userType === 'staff'
                ? 'staff.demo@hairlink.local'
                : userType === 'wigmaker'
                    ? 'wigmaker.demo@hairlink.local'
                    : 'donor.demo@hairlink.local',
        userType,
        profile: {
            firstName: userType === 'recipient'
                ? 'Recipient'
                : userType === 'staff'
                    ? 'Staff'
                    : userType === 'wigmaker'
                        ? 'Wigmaker'
                        : 'Donor',
            lastName: 'Demo',
            fullName: userType === 'recipient'
                ? 'Recipient Demo'
                : userType === 'staff'
                    ? 'Staff Demo'
                    : userType === 'wigmaker'
                        ? 'Wigmaker Demo'
                        : 'Donor Demo',
            email: userType === 'recipient'
                ? 'recipient.demo@hairlink.local'
                : userType === 'staff'
                    ? 'staff.demo@hairlink.local'
                    : userType === 'wigmaker'
                        ? 'wigmaker.demo@hairlink.local'
                        : 'donor.demo@hairlink.local',
            phone: '0917-000-0000',
            age: '22',
            country: 'ph',
            region: 'Metro Manila',
            postalCode: '1000',
            gender: 'prefer_not_say',
            userType
        }
    };

    const accounts = getDemoAccounts();
    const existingIndex = accounts.findIndex((item) => item.email === account.email);
    if (existingIndex >= 0) {
        accounts[existingIndex] = account;
    } else {
        accounts.push(account);
    }

    saveDemoAccounts(accounts);
    setCurrentUser(account);
    redirectByUserType(userType);
>>>>>>> origin/main
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

function handleAjaxSubmit(form, formType) {
    if (!form) return;
    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        clearErrors(formType);
        
        const btn = form.querySelector('button[type="submit"]');
        const originalText = btn.innerText;
        btn.innerText = 'Processing...';
        btn.disabled = true;

        const formData = new FormData(form);
        const url = form.getAttribute('action');
        
        try {
            const response = await fetch(url, {
                method: 'POST',
                body: formData,
                headers: {
                    'Accept': 'application/json'
                }
            });
            
            const data = await response.json();
            
            if (response.ok && data.redirect) {
                window.location.href = data.redirect;
            } else if (response.status === 422 && data.errors) {
                showErrors(formType, data.errors);
            } else {
                alert(data.message || 'Something went wrong, please try again later.');
            }
        } catch (error) {
            console.error('Submission error', error);
            alert('A network error occurred.');
        } finally {
            btn.innerText = originalText;
            btn.disabled = false;
        }
    });
}

function setupRegisterFlow() {
    const registerForm = document.getElementById('registerForm');
    handleAjaxSubmit(registerForm, 'register');

    // Real-time validation loops for instant feedback
    const passwordInput = document.getElementById('registerPassword');
    const confirmInput = document.getElementById('registerConfirmPassword');
    const emailInput = document.getElementById('registerEmail');

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
}

function setupLoginFlow() {
    const loginForm = document.getElementById('loginForm');
    handleAjaxSubmit(loginForm, 'login');

    const adminDemoButton = document.getElementById('fillAdminDemo');
    const donorDemoButton = document.getElementById('fillDonorDemo');
    const recipientDemoButton = document.getElementById('fillRecipientDemo');

    if (adminDemoButton) {
        adminDemoButton.addEventListener('click', () => {
            const emailField = document.getElementById('loginEmail');
            const passwordField = document.getElementById('loginPassword');

            if (emailField) {
                emailField.value = 'admin@hairlink.local';
            }

            if (passwordField) {
                passwordField.value = 'admin12345';
            }
        });
    }

    if (donorDemoButton) {
        donorDemoButton.addEventListener('click', () => {
            fillDemo('donor');
        });
    }

    if (recipientDemoButton) {
        recipientDemoButton.addEventListener('click', () => {
            fillDemo('recipient');
        });
    }
<<<<<<< HEAD
=======

    if (staffDemoButton) {
        staffDemoButton.addEventListener('click', () => {
            runRoleDemo('staff');
        });
    }

    if (wigmakerDemoButton) {
        wigmakerDemoButton.addEventListener('click', () => {
            runRoleDemo('wigmaker');
        });
    }

    loginForm.addEventListener('submit', (e) => {
        e.preventDefault();

        const email = document.getElementById('loginEmail')?.value || '';
        const password = document.getElementById('loginPassword')?.value || '';
        const storedType = localStorage.getItem('hairlinkUserType') || 'donor';
        const accounts = getDemoAccounts();

        if (email === ADMIN_DEMO_EMAIL && password === ADMIN_DEMO_PASSWORD) {
            alert('Admin demo login successful. Redirecting to admin dashboard.');
            window.location.href = '/admin/dashboard';
            return;
        }

        if (!email) {
            redirectByUserType(storedType);
            return;
        }

        const matchedAccount = accounts.find((item) => item.email === email);

        if (matchedAccount) {
            setCurrentUser(matchedAccount);
            redirectByUserType(matchedAccount.userType);
            return;
        }

        // Fallback for quick frontend checks: keep using last selected role.
        redirectByUserType(storedType);
    });
>>>>>>> origin/main
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
