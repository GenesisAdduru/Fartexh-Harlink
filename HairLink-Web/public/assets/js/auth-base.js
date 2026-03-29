const container = document.getElementById('authContainer');
const registerBtn = document.querySelector('.register-btn');
const loginBtn = document.querySelector('.login-btn');
const adminDemoButton = document.getElementById('fillAdminDemo');
const ADMIN_DEMO_EMAIL = 'admin@hairlink.local';
const ADMIN_DEMO_PASSWORD = 'admin12345';

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

function setupRegisterFlow() {
    const registerForm = document.getElementById('registerForm');
    if (!registerForm) return;

    registerForm.addEventListener('submit', (e) => {
        e.preventDefault();

        const userType = registerForm.querySelector('input[name="userType"]:checked')?.value;
        const email = document.getElementById('registerEmail')?.value || '';
        const password = document.getElementById('registerPassword')?.value || '';
        const confirmPassword = document.getElementById('registerConfirmPassword')?.value || '';

        if (password !== confirmPassword) {
            alert('Passwords do not match.');
            return;
        }

        if (userType && email) {
            localStorage.setItem('hairlinkUserType', userType);
            localStorage.setItem('hairlinkUserEmail', email);
        }

        registerForm.classList.add('register-success');

        setTimeout(() => {
            setMode('login');
            const loginEmail = document.getElementById('loginEmail');
            if (loginEmail && email) {
                loginEmail.value = email;
            }
            registerForm.classList.remove('register-success');
        }, 700);
    });
}

function setupLoginFlow() {
    const loginForm = document.getElementById('loginForm');
    if (!loginForm) return;

    if (adminDemoButton) {
        adminDemoButton.addEventListener('click', () => {
            const emailField = document.getElementById('loginEmail');
            const passwordField = document.getElementById('loginPassword');

            if (emailField) {
                emailField.value = ADMIN_DEMO_EMAIL;
            }

            if (passwordField) {
                passwordField.value = ADMIN_DEMO_PASSWORD;
            }
        });
    }

    loginForm.addEventListener('submit', (e) => {
        e.preventDefault();

        const email = document.getElementById('loginEmail')?.value || '';
        const password = document.getElementById('loginPassword')?.value || '';
        const storedEmail = localStorage.getItem('hairlinkUserEmail');
        const storedType = localStorage.getItem('hairlinkUserType');

        if (email === ADMIN_DEMO_EMAIL && password === ADMIN_DEMO_PASSWORD) {
            alert('Admin demo login successful. Redirecting to admin dashboard.');
            window.location.href = '/admin';
            return;
        }

        if (storedEmail && email && storedEmail !== email) {
            alert('Email not found in local demo account. Please register first.');
            return;
        }

        if (storedType === 'recipient') {
            alert('Login successful. Recipient dashboard UI will be added next.');
            window.location.href = '/dashboard';
        } else {
            alert('Login successful. Redirecting to donor dashboard.');
            window.location.href = '/donor/dashboard';
        }
    });
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
