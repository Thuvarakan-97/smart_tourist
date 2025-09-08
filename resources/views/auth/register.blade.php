<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Smart Tourist Guide</title>
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

/* Select Styles */
.form-control select {
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
    background-position: right 0.5rem center;
    background-repeat: no-repeat;
    background-size: 1.5em 1.5em;
    padding-right: 2.5rem;
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

/* Role Selection Styles */
.role-options {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: 1rem;
    margin-top: 0.5rem;
}

.role-option {
    padding: 1rem;
    border: 2px solid #ddd;
    border-radius: 8px;
    text-align: center;
    cursor: pointer;
    transition: all 0.3s ease;
}

.role-option:hover {
    border-color: var(--orange);
    background-color: #fef7f0;
}

.role-option.selected {
    border-color: var(--orange);
    background-color: #fef7f0;
}

.role-option input[type="radio"] {
    display: none;
}

.role-option i {
    font-size: 2rem;
    color: var(--orange);
    margin-bottom: 0.5rem;
}

.role-option label {
    margin: 0;
    font-weight: 500;
    cursor: pointer;
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
    
    .role-options {
        grid-template-columns: 1fr;
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
                    <a href="{{ route('login') }}" class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 transition-colors">
                        Login
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="bg-gradient-to-r from-orange-500 to-yellow-500 text-white py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-3xl font-bold mb-2">Join Our Community!</h1>
            <p class="text-lg opacity-90">Create your account and start your Sri Lankan adventure</p>
        </div>
    </section>

    <!-- Register Form -->
    <section class="py-12">
        <div class="max-w-md mx-auto px-4 sm:px-6 lg:px-8">
            <div class="card">
                <div class="card-header text-center">
                    <div class="flex items-center justify-center mb-4">
                        <i class="fas fa-user-plus text-orange-500 text-3xl mr-3"></i>
                        <h2 class="text-2xl font-bold text-gray-800">Create Account</h2>
                    </div>
                    <p class="text-gray-600">Fill in your details to get started</p>
                </div>
                
                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <!-- Name -->
                        <div class="form-group">
                            <label for="name" class="flex items-center">
                                <i class="fas fa-user mr-2 text-orange-500"></i>
                                Full Name
                            </label>
                            <input type="text" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name') }}" 
                                   required 
                                   autofocus 
                                   autocomplete="name"
                                   class="form-control @error('name') error @enderror"
                                   placeholder="Enter your full name">
                            @error('name')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>

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
                                   autocomplete="username"
                                   class="form-control @error('email') error @enderror"
                                   placeholder="Enter your email address">
                            @error('email')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Role Selection -->
                        <div class="form-group">
                            <label class="flex items-center mb-3">
                                <i class="fas fa-user-tag mr-2 text-orange-500"></i>
                                Choose Your Role
                            </label>
                            <div class="role-options">
                                <div class="role-option {{ old('role') == 'tourist' ? 'selected' : '' }}">
                                    <input type="radio" id="role_tourist" name="role" value="tourist" {{ old('role') == 'tourist' ? 'checked' : '' }}>
                                    <label for="role_tourist">
                                        <i class="fas fa-camera"></i>
                                        <div>Tourist</div>
                                    </label>
                                </div>
                                <div class="role-option {{ old('role') == 'room_owner' ? 'selected' : '' }}">
                                    <input type="radio" id="role_room_owner" name="role" value="room_owner" {{ old('role') == 'room_owner' ? 'checked' : '' }}>
                                    <label for="role_room_owner">
                                        <i class="fas fa-bed"></i>
                                        <div>Room Owner</div>
                                    </label>
                                </div>
                                <div class="role-option {{ old('role') == 'vehicle_owner' ? 'selected' : '' }}">
                                    <input type="radio" id="role_vehicle_owner" name="role" value="vehicle_owner" {{ old('role') == 'vehicle_owner' ? 'checked' : '' }}>
                                    <label for="role_vehicle_owner">
                                        <i class="fas fa-car"></i>
                                        <div>Vehicle Owner</div>
                                    </label>
                                </div>
                            </div>
                            @error('role')
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
                                   autocomplete="new-password"
                                   class="form-control @error('password') error @enderror"
                                   placeholder="Create a strong password">
                            @error('password')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div class="form-group">
                            <label for="password_confirmation" class="flex items-center">
                                <i class="fas fa-lock mr-2 text-orange-500"></i>
                                Confirm Password
                            </label>
                            <input type="password" 
                                   id="password_confirmation" 
                                   name="password_confirmation" 
                                   required 
                                   autocomplete="new-password"
                                   class="form-control @error('password_confirmation') error @enderror"
                                   placeholder="Confirm your password">
                            @error('password_confirmation')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary w-full">
                                <i class="fas fa-user-plus mr-2"></i>
                                Create Account
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Login Link -->
            <div class="text-center mt-6">
                <p class="text-gray-600">
                    Already have an account? 
                    <a href="{{ route('login') }}" class="link font-semibold">
                        <i class="fas fa-sign-in-alt mr-1"></i>
                        Sign In
                    </a>
                </p>
            </div>
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
        // Add interactive effects for role selection
        document.addEventListener('DOMContentLoaded', function() {
            const roleOptions = document.querySelectorAll('.role-option');
            
            roleOptions.forEach(option => {
                option.addEventListener('click', function() {
                    // Remove selected class from all options
                    roleOptions.forEach(opt => opt.classList.remove('selected'));
                    
                    // Add selected class to clicked option
                    this.classList.add('selected');
                    
                    // Check the radio button
                    const radio = this.querySelector('input[type="radio"]');
                    radio.checked = true;
                });
            });

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