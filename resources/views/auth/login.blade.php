<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Login - Progressly</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <style>
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }

            body {
                font-family: 'Figtree', sans-serif;
                background: #111827;
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 20px;
                position: relative;
                overflow: hidden;
            }

            body::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: 
                    radial-gradient(circle at 20% 80%, rgba(59, 130, 246, 0.1) 0%, transparent 50%),
                    radial-gradient(circle at 80% 20%, rgba(139, 92, 246, 0.1) 0%, transparent 50%),
                    radial-gradient(circle at 40% 40%, rgba(16, 185, 129, 0.05) 0%, transparent 50%);
                z-index: -1;
            }

            .login-container {
                background: rgba(31, 41, 55, 0.95);
                border-radius: 16px;
                box-shadow: 
                    0 25px 50px rgba(0, 0, 0, 0.3),
                    0 0 0 1px rgba(55, 65, 81, 1);
                width: 100%;
                max-width: 440px;
                overflow: hidden;
                backdrop-filter: blur(20px);
            }

            .login-header {
                background: linear-gradient(135deg, #3b82f6 0%, #8b5cf6 100%);
                padding: 2.5rem 2rem;
                text-align: center;
                color: white;
                position: relative;
                overflow: hidden;
            }

            .login-header::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: 
                    radial-gradient(circle at 30% 70%, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
                    radial-gradient(circle at 70% 30%, rgba(255, 255, 255, 0.1) 0%, transparent 50%);
            }

            .logo {
                display: flex;
                align-items: center;
                justify-content: center;
                margin-bottom: 1rem;
                position: relative;
                z-index: 2;
            }

            .logo svg {
                width: 40px;
                height: 40px;
            }

            .logo-text {
                font-size: 1.5rem;
                font-weight: 700;
                margin-left: 0.5rem;
                background: linear-gradient(135deg, #ffffff, #e0e7ff);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
            }

            .login-header h1 {
                font-size: 1.5rem;
                font-weight: 600;
                margin-bottom: 0.5rem;
                position: relative;
                z-index: 2;
            }

            .login-header p {
                opacity: 0.9;
                font-size: 0.9rem;
                position: relative;
                z-index: 2;
            }

            .login-form {
                padding: 2rem;
            }

            .form-group {
                margin-bottom: 1.5rem;
            }

            .form-group label {
                display: block;
                margin-bottom: 0.5rem;
                font-weight: 500;
                color: #f3f4f6;
                font-size: 0.9rem;
            }

            .form-input {
                width: 100%;
                padding: 0.75rem 1rem;
                background: rgba(17, 24, 39, 0.8);
                border: 1px solid rgba(55, 65, 81, 1);
                border-radius: 8px;
                font-size: 0.9rem;
                transition: all 0.3s ease;
                color: #f3f4f6;
            }

            .form-input::placeholder {
                color: #9ca3af;
            }

            .form-input:focus {
                outline: none;
                border-color: #3b82f6;
                box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
                background: rgba(17, 24, 39, 0.9);
            }

            .form-input.error {
                border-color: #ef4444;
                box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.2);
            }

            .error-message {
                color: #f87171;
                font-size: 0.8rem;
                margin-top: 0.25rem;
            }

            .validation-errors {
                background: rgba(127, 29, 29, 0.2);
                border: 1px solid rgba(248, 113, 113, 0.3);
                border-radius: 8px;
                padding: 1rem;
                margin-bottom: 1.5rem;
                color: #fca5a5;
                font-size: 0.9rem;
                backdrop-filter: blur(10px);
            }

            .validation-errors ul {
                list-style: none;
                margin: 0;
                padding: 0;
            }

            .validation-errors li {
                margin-bottom: 0.25rem;
            }

            .status-message {
                background: rgba(21, 128, 61, 0.2);
                border: 1px solid rgba(74, 222, 128, 0.3);
                border-radius: 8px;
                padding: 1rem;
                margin-bottom: 1.5rem;
                color: #86efac;
                font-size: 0.9rem;
                backdrop-filter: blur(10px);
            }

            .remember-forgot {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 1.5rem;
            }

            .remember-me {
                display: flex;
                align-items: center;
            }

            .remember-me input {
                margin-right: 0.5rem;
            }

            .remember-me label {
                margin-bottom: 0;
                font-size: 0.9rem;
                color: #d1d5db;
            }

            .forgot-password {
                color: #60a5fa;
                text-decoration: none;
                font-size: 0.9rem;
                transition: all 0.3s ease;
            }

            .forgot-password:hover {
                color: #93c5fd;
            }

            .btn {
                display: block;
                width: 100%;
                padding: 0.75rem 1rem;
                background: linear-gradient(135deg, #3b82f6, #8b5cf6);
                color: white;
                border: none;
                border-radius: 8px;
                font-size: 0.9rem;
                font-weight: 600;
                cursor: pointer;
                transition: all 0.3s ease;
                box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
            }

            .btn:hover {
                transform: translateY(-2px);
                box-shadow: 0 8px 25px rgba(59, 130, 246, 0.4);
            }

            .register-link {
                text-align: center;
                margin-top: 1.5rem;
                color: #9ca3af;
                font-size: 0.9rem;
            }

            .register-link a {
                color: #60a5fa;
                text-decoration: none;
                font-weight: 500;
                transition: color 0.3s ease;
            }

            .register-link a:hover {
                color: #93c5fd;
            }

            .checkbox {
                width: 16px;
                height: 16px;
                background: rgba(17, 24, 39, 0.8);
                border: 1px solid rgba(55, 65, 81, 1);
                border-radius: 4px;
                cursor: pointer;
                position: relative;
                transition: all 0.3s ease;
            }

            .checkbox:checked {
                background: linear-gradient(135deg, #3b82f6, #8b5cf6);
                border-color: #3b82f6;
            }

            .checkbox:checked::before {
                content: '✓';
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                color: white;
                font-size: 12px;
                font-weight: bold;
            }

            /* Floating animation for decorative elements */
            @keyframes float {
                0%, 100% { transform: translateY(0px); }
                50% { transform: translateY(-10px); }
            }

            .floating {
                animation: float 3s ease-in-out infinite;
            }
        </style>
    </head>
    <body>
        <div class="login-container floating">
            <div class="login-header">
                <div class="logo">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 2L2 7L12 12L22 7L12 2Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M2 17L12 22L22 17" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M2 12L12 17L22 12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <span class="logo-text">Progressly</span>
                </div>
                <h1>Welcome Back</h1>
                <p>Sign in to your account to continue</p>
            </div>

            <div class="login-form">
                <!-- Validation Errors -->
                @if ($errors->any())
                    <div class="validation-errors">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Status Message -->
                @if (session('status'))
                    <div class="status-message">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input 
                            id="email" 
                            class="form-input @error('email') error @enderror" 
                            type="email" 
                            name="email" 
                            value="{{ old('email') }}" 
                            required 
                            autofocus 
                            autocomplete="username"
                            placeholder="Enter your email"
                        >
                        @error('email')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input 
                            id="password" 
                            class="form-input @error('password') error @enderror" 
                            type="password" 
                            name="password" 
                            required 
                            autocomplete="current-password"
                            placeholder="Enter your password"
                        >
                        @error('password')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="remember-forgot">
                        <div class="remember-me">
                            <input type="checkbox" id="remember_me" name="remember" class="checkbox">
                            <label for="remember_me">Remember me</label>
                        </div>
                        
                        @if (Route::has('password.request'))
                            <a class="forgot-password" href="{{ route('password.request') }}">
                                Forgot your password?
                            </a>
                        @endif
                    </div>

                    <button type="submit" class="btn">
                        Sign In
                    </button>
                </form>

                <div class="register-link">
                    Don't have an account? <a href="{{ route('register') }}">Sign up</a>
                </div>
            </div>
        </div>

        <script>
            // Simple client-side validation
            document.querySelector('form').addEventListener('submit', function(e) {
                const email = document.getElementById('email');
                const password = document.getElementById('password');
                
                // Reset error states
                email.classList.remove('error');
                password.classList.remove('error');
                
                let isValid = true;
                
                // Email validation
                if (!email.value || !isValidEmail(email.value)) {
                    email.classList.add('error');
                    isValid = false;
                }
                
                // Password validation
                if (!password.value) {
                    password.classList.add('error');
                    isValid = false;
                }
                
                if (!isValid) {
                    e.preventDefault();
                }
            });
            
            function isValidEmail(email) {
                const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                return re.test(email);
            }

            // Add focus effects
            const inputs = document.querySelectorAll('.form-input');
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentElement.classList.add('focused');
                });
                
                input.addEventListener('blur', function() {
                    this.parentElement.classList.remove('focused');
                });
            });
        </script>
    </body>
</html>