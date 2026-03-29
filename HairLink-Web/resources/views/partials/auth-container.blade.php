@php
    $initialMode = $initialMode ?? 'register';
@endphp

<div class="container {{ $initialMode === 'register' ? 'active' : '' }}" id="authContainer" data-initial-mode="{{ $initialMode }}">
    <div class="form-box login">
        <form id="loginForm" action="#">
            <h1>Login</h1>
            <p class="form-subtitle">We've missed you. Log in to continue your HairLink journey.</p>
            <div class="demo-account-card">
                <p class="demo-account-title">Admin demo account</p>
                <p class="demo-account-copy">Use this for frontend preview only.</p>
                <p class="demo-account-credentials">Email: admin@hairlink.local</p>
                <p class="demo-account-credentials">Password: admin12345</p>
                <button type="button" class="demo-fill-btn" id="fillAdminDemo">Use Admin Demo</button>
            </div>

            <div class="input-box">
                <input id="loginEmail" type="email" placeholder="Email" required>
                <i class='bx bxs-envelope'></i>
            </div>

            <div class="input-box">
                <input id="loginPassword" type="password" placeholder="Password" required>
                <i class='bx bxs-lock-alt'></i>
            </div>

            <div class="forgot-link">
                <a href="#">Forgot Password?</a>
            </div>

            <button type="submit" class="btn">Login</button>
        </form>
    </div>

    <div class="form-box register">
        <form id="registerForm" action="#">
            <h1>Create Your Account</h1>
            <p class="form-subtitle">Sign up as a donor or recipient to join the mission.</p>

            <div class="user-type-group">
                <span class="user-type-label">User Type</span>
                <div class="user-type-options">
                    <label class="user-type-option">
                        <input type="radio" name="userType" value="donor" required>
                        <span>Donor</span>
                    </label>

                    <label class="user-type-option">
                        <input type="radio" name="userType" value="recipient" required>
                        <span>Recipient</span>
                    </label>
                </div>
            </div>

            <div class="grid-two-cols">
                <div class="input-box input-box--medium">
                    <input type="text" placeholder="First Name" required>
                    <i class='bx bxs-user'></i>
                </div>

                <div class="input-box input-box--medium">
                    <input type="text" placeholder="Last Name" required>
                    <i class='bx bxs-user'></i>
                </div>
            </div>

            <div class="grid-two-cols">
                <div class="input-box select-wrapper">
                    <select required>
                        <option value="" disabled selected>Country</option>
                        <option value="ph">Philippines</option>
                        <option value="us">United States</option>
                        <option value="ca">Canada</option>
                        <option value="gb">United Kingdom</option>
                        <option value="au">Australia</option>
                    </select>
                    <i class='bx bx-world'></i>
                </div>

                <div class="input-box">
                    <input type="text" placeholder="Region / Province" required>
                    <i class='bx bxs-map'></i>
                </div>
            </div>

            <div class="grid-two-cols">
                <div class="input-box input-box--short">
                    <input type="text" placeholder="Postal Code" required>
                    <i class='bx bxs-home'></i>
                </div>

                <div class="input-box input-box--short">
                    <input type="number" min="1" max="120" placeholder="Age" required>
                    <i class='bx bx-calendar'></i>
                </div>
            </div>

            <div class="grid-two-cols">
                <div class="input-box select-wrapper input-box--medium">
                    <select required>
                        <option value="" disabled selected>Gender</option>
                        <option value="female">Female</option>
                        <option value="male">Male</option>
                        <option value="nonbinary">Non-binary</option>
                        <option value="prefer_not_say">Prefer not to say</option>
                    </select>
                    <i class='bx bx-user-circle'></i>
                </div>

                <div class="input-box input-box--medium">
                    <input type="tel" placeholder="Phone Number" required>
                    <i class='bx bxs-phone'></i>
                </div>
            </div>

            <div class="input-box input-box--long">
                <input id="registerEmail" type="email" name="email" placeholder="Email Address" autocomplete="email" inputmode="email" required>
                <i class='bx bxs-envelope'></i>
            </div>

            <div class="grid-two-cols">
                <div class="input-box input-box--medium">
                    <input id="registerPassword" type="password" placeholder="Password" required>
                    <i class='bx bxs-lock-alt'></i>
                </div>

                <div class="input-box input-box--medium">
                    <input id="registerConfirmPassword" type="password" placeholder="Confirm Password" required>
                    <i class='bx bxs-lock-alt'></i>
                </div>
            </div>

            <button type="submit" class="btn">Create Account</button>
        </form>
    </div>

    <div class="toggle-box">
        <div class="toggle-panel toggle-left">
            <h2>Welcome Back!</h2>
            <p>Already part of Strand Up for Cancer?</p>
            <button type="button" class="btn login-btn">Go to Login</button>
        </div>

        <div class="toggle-panel toggle-right">
            <h2>Hello, Welcome!</h2>
            <p>Don't have an account yet?</p>
            <button type="button" class="btn register-btn">Go to Register</button>
        </div>
    </div>
</div>
