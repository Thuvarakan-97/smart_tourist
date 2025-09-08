<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Smart Tourist Guide</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<style>
/* Colors matching welcome.blade.php */
:root {
    --orange: #e67e22;
    --green: #27ae60;
    --gold: #f39c12;
    --maroon: #8b0000;
    --light-gray: #f8f9fa;
    --dark-gray: #2c3e50;
    --white: #ffffff;
    --shadow: 0 2px 10px rgba(0,0,0,0.1);
}

body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    line-height: 1.6;
    color: #333;
}

/* Form Styles */
.form-group {
    margin-bottom: 1.5rem;
}

.form-group label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 500;
    color: var(--dark-gray);
}

.form-control {
    width: 100%;
    padding: 12px;
    border: 2px solid #ddd;
    border-radius: 8px;
    font-size: 1rem;
    transition: border-color 0.3s ease;
}

.form-control:focus {
    outline: none;
    border-color: var(--orange);
}

.form-control.error {
    border-color: #e74c3c;
}

.error-message {
    color: #e74c3c;
    font-size: 0.875rem;
    margin-top: 0.5rem;
}

/* Buttons */
.btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 12px 24px;
    border: none;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
    text-align: center;
}

.btn-primary {
    background: var(--orange);
    color: white;
}

.btn-primary:hover {
    background: #d35400;
    transform: translateY(-2px);
}

.btn-secondary {
    background: var(--green);
    color: white;
}

.btn-secondary:hover {
    background: #229954;
    transform: translateY(-2px);
}

.btn-outline {
    background: transparent;
    color: var(--orange);
    border: 2px solid var(--orange);
}

.btn-outline:hover {
    background: var(--orange);
    color: white;
}

/* Cards */
.card {
    background: white;
    border-radius: 12px;
    box-shadow: var(--shadow);
    overflow: hidden;
}

.card-header {
    padding: 1.5rem;
    border-bottom: 1px solid #eee;
}

.card-body {
    padding: 1.5rem;
}

/* Checkbox Styles */
.checkbox-group {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-bottom: 1rem;
}

.checkbox-group input[type="checkbox"] {
    width: 18px;
    height: 18px;
    accent-color: var(--orange);
}

.checkbox-group label {
    margin: 0;
    font-size: 0.9rem;
    color: #666;
}

/* Links */
.link {
    color: var(--orange);
    text-decoration: none;
    font-size: 0.9rem;
    transition: color 0.3s ease;
}

.link:hover {
    color: #d35400;
    text-decoration: underline;
}

/* Responsive */
@media (max-width: 768px) {
    .container {
        padding: 0 15px;
    }
    
    .btn {
        padding: 10px 20px;
        font-size: 0.9rem;
    }
}
</style>
<body class="bg-gray-100 min-h-screen">
    <!-- Navigation -->
    <nav class="bg-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <div class="flex items-center">
                        <i class="fas fa-map-marker-alt text-orange-500 text-2xl mr-3"></i>
                        <span class="text-xl font-bold text-gray-800">Smart Tourist Guide</span>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ url('/') }}" class="text-gray-600 hover:text-orange-500 transition-colors">
                        <i class="fas fa-home mr-2"></i>Home
                    </a>
                    <a href="{{ route('discover.places') }}" class="text-gray-600 hover:text-orange-500 transition-colors">
                        <i class="fas fa-globe mr-2"></i>Discover Places
                    </a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="bg-orange-500 text-white px-4 py-2 rounded-md hover:bg-orange-600 transition-colors">
                            Register
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="bg-gradient-to-r from-orange-500 to-yellow-500 text-white py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-3xl font-bold mb-2">Welcome Back!</h1>
            <p class="text-lg opacity-90">Sign in to continue your Sri Lankan adventure</p>
        </div>
    </section>

    <!-- Login Form -->
    <section class="py-12">
        <div class="max-w-md mx-auto px-4 sm:px-6 lg:px-8">
            <div class="card">
                <div class="card-header text-center">
                    <div class="flex items-center justify-center mb-4">
                        <i class="fas fa-sign-in-alt text-orange-500 text-3xl mr-3"></i>
                        <h2 class="text-2xl font-bold text-gray-800">Sign In</h2>
                    </div>
                    <p class="text-gray-600">Enter your credentials to access your account</p>
                </div>
                
                <div class="card-body">
                    <!-- Session Status -->
                    @if (session('status'))
                        <div class="mb-4 p-3 bg-green-100 border border-green-400 text-green-700 rounded-md">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <!-- Email Address -->
                        <div class="form-group">
                            <label for="email" class="flex items-center">
                                <i class="fas fa-envelope mr-2 text-orange-500"></i>
                                Email Address
                            </label>
                            <input type="email" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email') }}" 
                                   required 
                                   autofocus 
                                   autocomplete="username"
                                   class="form-control @error('email') error @enderror"
                                   placeholder="Enter your email address">
                            @error('email')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="form-group">
                            <label for="password" class="flex items-center">
                                <i class="fas fa-lock mr-2 text-orange-500"></i>
                                Password
                            </label>
                            <input type="password" 
                                   id="password" 
                                   name="password" 
                                   required 
                                   autocomplete="current-password"
                                   class="form-control @error('password') error @enderror"
                                   placeholder="Enter your password">
                            @error('password')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Remember Me -->
                        <div class="checkbox-group">
                            <input type="checkbox" 
                                   id="remember_me" 
                                   name="remember" 
                                   class="rounded">
                            <label for="remember_me">Remember me</label>
                        </div>

                        <!-- Submit Button -->
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary w-full">
                                <i class="fas fa-sign-in-alt mr-2"></i>
                                Sign In
                            </button>
                        </div>

                        <!-- Forgot Password -->
                        @if (Route::has('password.request'))
                            <div class="text-center">
                                <a href="{{ route('password.request') }}" class="link">
                                    <i class="fas fa-key mr-1"></i>
                                    Forgot your password?
                                </a>
                            </div>
                        @endif
                    </form>
                </div>
            </div>

            <!-- Register Link -->
            @if (Route::has('register'))
                <div class="text-center mt-6">
                    <p class="text-gray-600">
                        Don't have an account? 
                        <a href="{{ route('register') }}" class="link font-semibold">
                            <i class="fas fa-user-plus mr-1"></i>
                            Create Account
                        </a>
                    </p>
                </div>
            @endif
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="flex items-center justify-center mb-4">
                <i class="fas fa-map-marker-alt text-orange-500 text-2xl mr-3"></i>
                <span class="text-xl font-bold">Smart Tourist Guide</span>
            </div>
            <p class="text-gray-400">&copy; 2024 Sri Lanka Tourism. All rights reserved.</p>
        </div>
    </footer>

    <script>
        // Add some interactive effects
        document.addEventListener('DOMContentLoaded', function() {
            // Add focus effects to form inputs
            const inputs = document.querySelectorAll('.form-control');
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentElement.classList.add('focused');
                });
                
                input.addEventListener('blur', function() {
                    this.parentElement.classList.remove('focused');
                });
            });
        });
    </script>
</body>
</html>