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

function buildAppUrl(path) {
    const appBase = document
        .querySelector('meta[name="app-base-url"]')
        ?.getAttribute('content')
        ?.replace(/\/$/, '') || window.location.origin;

    return `${appBase}/${String(path || '').replace(/^\/+/, '')}`;
}

function redirectTo(path) {
    window.location.href = buildAppUrl(path);
}

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
        redirectTo('staff/dashboard');
        return;
    }

    if (userType === 'wigmaker') {
        alert('Login successful. Redirecting to wigmaker dashboard.');
        redirectTo('wigmaker/dashboard');
        return;
    }

    if (userType === 'admin') {
        alert('Login successful. Redirecting to admin dashboard.');
        redirectTo('admin/dashboard');
        return;
    }

    if (userType === 'recipient') {
        alert('Login successful. Redirecting to recipient dashboard.');
        redirectTo('recipient/dashboard');
        return;
    }

    alert('Login successful. Redirecting to donor dashboard.');
    redirectTo('donor/dashboard');
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

function setupRegisterFlow() {
    const registerForm = document.getElementById('registerForm');
    if (!registerForm) return;

    registerForm.addEventListener('submit', (e) => {
        e.preventDefault();

        const userType = registerForm.querySelector('input[name="userType"]:checked')?.value;
        const email = document.getElementById('registerEmail')?.value || '';
        const password = document.getElementById('registerPassword')?.value || '';
        const confirmPassword = document.getElementById('registerConfirmPassword')?.value || '';
        const textInputs = registerForm.querySelectorAll('input[type="text"]');
        const firstName = textInputs[0]?.value?.trim() || '';
        const lastName = textInputs[1]?.value?.trim() || '';
        const region = textInputs[2]?.value?.trim() || '';
        const postalCode = textInputs[3]?.value?.trim() || '';
        const age = registerForm.querySelector('input[type="number"]')?.value || '';
        const phone = registerForm.querySelector('input[type="tel"]')?.value?.trim() || '';
        const selects = registerForm.querySelectorAll('select');
        const country = selects[0]?.value || '';
        const gender = selects[1]?.value || '';

        if (password !== confirmPassword) {
            alert('Passwords do not match.');
            return;
        }

        if (userType && email) {
            const profile = {
                firstName,
                lastName,
                fullName: `${firstName} ${lastName}`.trim(),
                email,
                phone,
                age,
                country,
                region,
                postalCode,
                gender,
                userType
            };

            const account = { email, userType, profile };
            const accounts = getDemoAccounts();
            const existingIndex = accounts.findIndex((item) => item.email === email);

            if (existingIndex >= 0) {
                accounts[existingIndex] = account;
            } else {
                accounts.push(account);
            }

            saveDemoAccounts(accounts);
            setCurrentUser(account);
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

    if (donorDemoButton) {
        donorDemoButton.addEventListener('click', () => {
            runRoleDemo('donor');
        });
    }

    if (recipientDemoButton) {
        recipientDemoButton.addEventListener('click', () => {
            runRoleDemo('recipient');
        });
    }

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
            redirectTo('admin/dashboard');
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
