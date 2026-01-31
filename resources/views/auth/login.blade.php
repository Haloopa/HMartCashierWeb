<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - H'Mart Kasir System</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .login-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
        }
        .input-group {
            transition: all 0.3s ease;
        }
        .input-group:focus-within {
            transform: translateY(-2px);
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4">
    <div class="absolute inset-0 overflow-hidden">
        <div class="absolute -top-40 -right-40 w-80 h-80 bg-purple-300 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob"></div>
        <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-pink-300 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-2000"></div>
        <div class="absolute -top-40 -left-40 w-80 h-80 bg-blue-300 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-4000"></div>
    </div>

    <div class="relative w-full max-w-md">
        <!-- Logo & Title -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-white rounded-2xl shadow-lg mb-4">
                <i class="fas fa-store text-3xl text-blue-600"></i>
            </div>
            <h1 class="text-3xl font-bold text-white">H'Mart Supermarket</h1>
            <p class="text-white/80 mt-2">Sistem Kasir Digital</p>
        </div>

        <!-- Login Card -->
        <div class="login-card rounded-2xl shadow-2xl p-8">
            <div class="mb-6">
                <h2 class="text-2xl font-bold text-gray-800 text-center">Masuk ke Sistem</h2>
                <p class="text-gray-600 text-center mt-2">Silakan masuk dengan akun kasir Anda</p>
            </div>

            <!-- Session Status -->
            @if (session('status'))
            <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-lg text-green-700">
                {{ session('status') }}
            </div>
            @endif

            <!-- Error Messages -->
            @if ($errors->any())
            <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-circle text-red-500 mr-3"></i>
                    <div>
                        @foreach ($errors->all() as $error)
                        <p class="text-red-700 text-sm">{{ $error }}</p>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email -->
                <div class="mb-6">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-envelope mr-2"></i>Alamat Email
                    </label>
                    <div class="input-group relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-user text-gray-400"></i>
                        </div>
                        <input id="email" 
                               name="email" 
                               type="email" 
                               value="{{ old('email') }}" 
                               required 
                               autofocus 
                               autocomplete="email"
                               class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                               placeholder="kasir@hmart.com">
                    </div>
                </div>

                <!-- Password -->
                <div class="mb-6">
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-lock mr-2"></i>Password
                    </label>
                    <div class="input-group relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-key text-gray-400"></i>
                        </div>
                        <input id="password" 
                               name="password" 
                               type="password" 
                               required 
                               autocomplete="current-password"
                               class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                               placeholder="••••••••">
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                            <button type="button" id="togglePassword" class="text-gray-400 hover:text-gray-600">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="flex items-center justify-between mb-6">
                    <label class="flex items-center">
                        <input id="remember_me" 
                               name="remember" 
                               type="checkbox"
                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <span class="ml-2 text-sm text-gray-600">Ingat saya</span>
                    </label>
                    
                    @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" 
                       class="text-sm text-blue-600 hover:text-blue-800 hover:underline">
                        Lupa password?
                    </a>
                    @endif
                </div>

                <!-- Submit Button -->
                <button type="submit" 
                        class="w-full bg-gradient-to-r from-blue-600 to-purple-600 text-white py-3 px-4 rounded-xl font-medium hover:from-blue-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-200 transform hover:-translate-y-0.5 shadow-lg">
                    <i class="fas fa-sign-in-alt mr-2"></i>Masuk ke Sistem
                </button>

                <!-- Demo Account Info -->
                <div class="mt-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                    <p class="text-sm text-blue-800 font-medium mb-2">
                        <i class="fas fa-info-circle mr-2"></i>Akun Demo:
                    </p>
                    <div class="text-xs text-blue-700 space-y-1">
                        <p><span class="font-medium">Admin:</span> admin@hmart.com / password</p>
                        <p><span class="font-medium">Kasir:</span> kasir@hmart.com / password</p>
                    </div>
                </div>

                <!-- Footer -->
                <div class="mt-8 pt-6 border-t border-gray-200 text-center">
                    <p class="text-sm text-gray-600">
                        H'Mart Supermarket 
                    </p>
                </div>
            </form>
        </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Toggle password visibility
            const togglePassword = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('password');
            
            if (togglePassword && passwordInput) {
                togglePassword.addEventListener('click', function() {
                    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordInput.setAttribute('type', type);
                    
                    // Toggle eye icon
                    const icon = this.querySelector('i');
                    if (type === 'password') {
                        icon.classList.remove('fa-eye-slash');
                        icon.classList.add('fa-eye');
                    } else {
                        icon.classList.remove('fa-eye');
                        icon.classList.add('fa-eye-slash');
                    }
                });
            }
            
            // Add animation to form inputs on focus
            const inputs = document.querySelectorAll('input');
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentElement.classList.add('ring-2', 'ring-blue-500');
                });
                
                input.addEventListener('blur', function() {
                    this.parentElement.classList.remove('ring-2', 'ring-blue-500');
                });
            });
        });
    </script>
</body>
</html>