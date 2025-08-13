<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modern Login</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            transform: translateY(20px);
            opacity: 0;
            animation: slideUp 0.6s ease-out forwards;
        }

        @keyframes slideUp {
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .login-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .login-header h1 {
            color: #333;
            font-size: 2.2em;
            font-weight: 300;
            margin-bottom: 10px;
        }

        .login-header p {
            color: #666;
            font-size: 0.9em;
        }

        .form-group {
            position: relative;
            margin-bottom: 25px;
        }

        .form-input {
            width: 100%;
            padding: 15px 20px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 16px;
            transition: all 0.3s ease;
            background: white;
        }

        .form-input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .form-label {
            position: absolute;
            top: 15px;
            left: 20px;
            color: #999;
            transition: all 0.3s ease;
            pointer-events: none;
            background: white;
            padding: 0 5px;
        }

        .form-input:focus + .form-label,
        .form-input:not(:placeholder-shown) + .form-label {
            top: -8px;
            left: 15px;
            font-size: 12px;
            color: #667eea;
            font-weight: 500;
        }

        .password-toggle {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #999;
            transition: color 0.3s ease;
        }

        .password-toggle:hover {
            color: #667eea;
        }

        .forgot-password {
            text-align: right;
            margin-bottom: 25px;
        }

        .forgot-password a {
            color: #667eea;
            text-decoration: none;
            font-size: 14px;
            transition: color 0.3s ease;
        }

        .forgot-password a:hover {
            color: #764ba2;
        }

        .login-btn {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .login-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
        }

        .login-btn:active {
            transform: translateY(0);
        }

        .login-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .login-btn:hover::before {
            left: 100%;
        }

        .divider {
            text-align: center;
            margin: 25px 0;
            position: relative;
            color: #999;
            font-size: 14px;
        }

        .divider::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background: #e0e0e0;
        }

        .divider span {
            background: white;
            padding: 0 15px;
        }

        .social-login {
            display: flex;
            gap: 10px;
            margin-bottom: 25px;
        }

        .social-btn {
            flex: 1;
            padding: 12px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            background: white;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 500;
        }

        .social-btn:hover {
            border-color: #667eea;
            transform: translateY(-1px);
        }

        .social-btn.google {
            color: #db4437;
        }

        .social-btn.facebook {
            color: #4267B2;
        }

        .signup-link {
            text-align: center;
            color: #666;
            font-size: 14px;
        }

        .signup-link a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
        }

        .signup-link a:hover {
            color: #764ba2;
        }

        /* Loading state */
        .loading {
            opacity: 0.7;
            pointer-events: none;
        }

        .loading::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 20px;
            height: 20px;
            margin: -10px 0 0 -10px;
            border: 2px solid transparent;
            border-top: 2px solid white;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Error state */
        .error {
            border-color: #e74c3c !important;
            box-shadow: 0 0 0 3px rgba(231, 76, 60, 0.1) !important;
        }

        .error-message {
            color: #e74c3c;
            font-size: 12px;
            margin-top: 5px;
            opacity: 0;
            transform: translateY(-10px);
            transition: all 0.3s ease;
        }

        .error-message.show {
            opacity: 1;
            transform: translateY(0);
        }

        /* Mobile responsiveness */
        @media (max-width: 480px) {
            .login-container {
                padding: 30px 20px;
            }
            
            .login-header h1 {
                font-size: 1.8em;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <h1>Welcome Back</h1>
            <p>Sign in to your account</p>
        </div>

        <form class="login-form" id="loginForm">
            <div class="form-group">
                <input type="email" class="form-input" id="email" placeholder=" " required>
                <label class="form-label" for="email">Email Address</label>
                <div class="error-message" id="emailError">Please enter a valid email address</div>
            </div>

            <div class="form-group">
                <input type="password" class="form-input" id="password" placeholder=" " required>
                <label class="form-label" for="password">Password</label>
                <span class="password-toggle" id="passwordToggle">👁️</span>
                <div class="error-message" id="passwordError">Password must be at least 6 characters</div>
            </div>

            <div class="forgot-password">
                <a href="#" id="forgotPassword">Forgot your password?</a>
            </div>

            <button type="submit" class="login-btn" id="loginBtn">
                Sign In
            </button>
        </form>

        <div class="divider">
            <span>or continue with</span>
        </div>

        <div class="social-login">
            <button class="social-btn google" id="googleLogin">
                Google
            </button>
            <button class="social-btn facebook" id="facebookLogin">
                Facebook
            </button>
        </div>

        <div class="signup-link">
            Don't have an account? <a href="#" id="signupLink">Sign up</a>
        </div>
    </div>

    <script>
        // Get DOM elements
        const loginForm = document.getElementById('loginForm');
        const emailInput = document.getElementById('email');
        const passwordInput = document.getElementById('password');
        const passwordToggle = document.getElementById('passwordToggle');
        const loginBtn = document.getElementById('loginBtn');
        const emailError = document.getElementById('emailError');
        const passwordError = document.getElementById('passwordError');

        // Password toggle functionality
        passwordToggle.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            this.textContent = type === 'password' ? '👁️' : '🙈';
        });

        // Email validation
        function validateEmail(email) {
            const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return re.test(email);
        }

        // Show error
        function showError(input, errorElement) {
            input.classList.add('error');
            errorElement.classList.add('show');
        }

        // Hide error
        function hideError(input, errorElement) {
            input.classList.remove('error');
            errorElement.classList.remove('show');
        }

        // Real-time validation
        emailInput.addEventListener('input', function() {
            if (this.value && !validateEmail(this.value)) {
                showError(this, emailError);
            } else {
                hideError(this, emailError);
            }
        });

        passwordInput.addEventListener('input', function() {
            if (this.value && this.value.length < 6) {
                showError(this, passwordError);
            } else {
                hideError(this, passwordError);
            }
        });

        // Form submission
        loginForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const email = emailInput.value;
            const password = passwordInput.value;
            let hasErrors = false;

            // Validate email
            if (!email) {
                showError(emailInput, emailError);
                emailError.textContent = 'Email is required';
                hasErrors = true;
            } else if (!validateEmail(email)) {
                showError(emailInput, emailError);
                emailError.textContent = 'Please enter a valid email address';
                hasErrors = true;
            } else {
                hideError(emailInput, emailError);
            }

            // Validate password
            if (!password) {
                showError(passwordInput, passwordError);
                passwordError.textContent = 'Password is required';
                hasErrors = true;
            } else if (password.length < 6) {
                showError(passwordInput, passwordError);
                passwordError.textContent = 'Password must be at least 6 characters';
                hasErrors = true;
            } else {
                hideError(passwordInput, passwordError);
            }

            if (!hasErrors) {
                // Show loading state
                loginBtn.classList.add('loading');
                loginBtn.textContent = 'Signing In...';
                
                // Simulate API call
                setTimeout(() => {
                    loginBtn.classList.remove('loading');
                    loginBtn.textContent = 'Sign In';
                    alert('Login successful! (This is a demo)');
                }, 2000);
            }
        });

        // Social login handlers
        document.getElementById('googleLogin').addEventListener('click', function() {
            alert('Google login clicked! (This is a demo)');
        });

        document.getElementById('facebookLogin').addEventListener('click', function() {
            alert('Facebook login clicked! (This is a demo)');
        });

        document.getElementById('forgotPassword').addEventListener('click', function(e) {
            e.preventDefault();
            alert('Forgot password clicked! (This is a demo)');
        });

        document.getElementById('signupLink').addEventListener('click', function(e) {
            e.preventDefault();
            alert('Sign up clicked! (This is a demo)');
        });

        // Add floating label animation for pre-filled inputs
        document.addEventListener('DOMContentLoaded', function() {
            const inputs = document.querySelectorAll('.form-input');
            inputs.forEach(input => {
                if (input.value) {
                    input.nextElementSibling.style.top = '-8px';
                    input.nextElementSibling.style.fontSize = '12px';
                    input.nextElementSibling.style.color = '#667eea';
                }
            });
        });
    </script>
</body>
</html>
