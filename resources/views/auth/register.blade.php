<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Register - KPSA</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        body {
            background: linear-gradient(135deg, #198754, #157347);
            min-height: 100vh;
            font-family: 'Inter', sans-serif;
        }

        .register-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px 0;
        }

        .register-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            max-width: 950px;
            width: 100%;
        }

        .register-left {
            background: linear-gradient(135deg, #198754, #157347);
            color: white;
            padding: 60px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
        }

        .register-right {
            padding: 60px 40px;
        }

        .logo {
            width: 80px;
            height: 80px;
            margin-bottom: 20px;
        }

        .form-control {
            border: 2px solid #e9ecef;
            border-radius: 10px;
            padding: 12px 15px;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #198754;
            box-shadow: 0 0 0 0.2rem rgba(25, 135, 84, 0.25);
        }

        .btn-success {
            background: linear-gradient(135deg, #198754, #157347);
            border: none;
            border-radius: 10px;
            padding: 12px 30px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-success:hover {
            background: linear-gradient(135deg, #157347, #146c43);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(25, 135, 84, 0.4);
        }

        .form-label {
            font-weight: 600;
            color: #495057;
            margin-bottom: 8px;
        }

        .login-link {
            color: #198754;
            font-weight: 600;
            text-decoration: none;
        }

        .login-link:hover {
            color: #157347;
            text-decoration: underline;
        }

        .alert {
            border: none;
            border-radius: 10px;
        }

        .invalid-feedback {
            display: block;
        }

        @media (max-width: 768px) {
            .register-left {
                padding: 40px 20px;
            }
            .register-right {
                padding: 40px 20px;
            }
        }
    </style>
</head>

<body>
    <div class="register-container">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="register-card">
                        <div class="row g-0">
                            <!-- Left Side - Branding -->
                            <div class="col-md-6 register-left">
                                <img src="{{ asset('img/BPDLogo.png') }}" alt="KPSA Logo" class="logo">
                                <h2 class="mb-3">Join Us Today!</h2>
                                <h4 class="mb-4">KPSA</h4>
                                <p class="mb-4">Katalog Perubahan Sistem Informasi</p>
                                <p class="opacity-75">Create your account to start managing application changes efficiently</p>
                            </div>

                            <!-- Right Side - Register Form -->
                            <div class="col-md-6 register-right">
                                <div class="mb-4">
                                    <h3 class="text-dark mb-2">Create Account</h3>
                                    <p class="text-muted">Fill in your information to create a new account</p>
                                </div>

                                <form method="POST" action="{{ route('register') }}">
                                    @csrf

                                    <!-- Name -->
                                    <div class="mb-3">
                                        <label for="name" class="form-label">
                                            <i class="bi bi-person me-2"></i>Full Name
                                        </label>
                                        <input type="text" 
                                               class="form-control @error('name') is-invalid @enderror" 
                                               id="name" 
                                               name="name" 
                                               value="{{ old('name') }}" 
                                               required 
                                               autofocus 
                                               autocomplete="name"
                                               placeholder="Enter your full name">
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Email Address -->
                                    <div class="mb-3">
                                        <label for="email" class="form-label">
                                            <i class="bi bi-envelope me-2"></i>Email Address
                                        </label>
                                        <input type="email" 
                                               class="form-control @error('email') is-invalid @enderror" 
                                               id="email" 
                                               name="email" 
                                               value="{{ old('email') }}" 
                                               required 
                                               autocomplete="username"
                                               placeholder="Enter your email address">
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Password -->
                                    <div class="mb-3">
                                        <label for="password" class="form-label">
                                            <i class="bi bi-lock me-2"></i>Password
                                        </label>
                                        <input type="password" 
                                               class="form-control @error('password') is-invalid @enderror" 
                                               id="password" 
                                               name="password" 
                                               required 
                                               autocomplete="new-password"
                                               placeholder="Enter your password">
                                        @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Confirm Password -->
                                    <div class="mb-4">
                                        <label for="password_confirmation" class="form-label">
                                            <i class="bi bi-lock-fill me-2"></i>Confirm Password
                                        </label>
                                        <input type="password" 
                                               class="form-control @error('password_confirmation') is-invalid @enderror" 
                                               id="password_confirmation" 
                                               name="password_confirmation" 
                                               required 
                                               autocomplete="new-password"
                                               placeholder="Confirm your password">
                                        @error('password_confirmation')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Register Button -->
                                    <button type="submit" class="btn btn-success w-100 mb-3">
                                        <i class="bi bi-person-plus me-2"></i>
                                        Create Account
                                    </button>

                                    <!-- Login Link -->
                                    <div class="text-center">
                                        <p class="mb-0">Already have an account? 
                                            <a href="{{ route('login') }}" class="login-link">Sign in here</a>
                                        </p>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Add loading state to register form
        document.querySelector('form').addEventListener('submit', function(e) {
            const submitBtn = this.querySelector('button[type="submit"]');
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Creating Account...';
        });

        // Real-time password confirmation validation
        const passwordField = document.getElementById('password');
        const confirmPasswordField = document.getElementById('password_confirmation');
        
        confirmPasswordField.addEventListener('input', function() {
            if (passwordField.value !== confirmPasswordField.value) {
                confirmPasswordField.setCustomValidity('Passwords do not match');
                confirmPasswordField.classList.add('is-invalid');
            } else {
                confirmPasswordField.setCustomValidity('');
                confirmPasswordField.classList.remove('is-invalid');
            }
        });
    </script>
</body>
</html>
