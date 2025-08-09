<!DOCTYPE html>
<html lang="en" class="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - QuranFlow</title>

    {{-- Tailwind + FontAwesome + AOS --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Amiri:wght@400;700&display=swap" rel="stylesheet">

    {{-- Toastify.js CDN --}}
    <link href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                fontFamily: {
                    sans: ['Inter', 'sans-serif'],
                    arabic: ['Amiri', 'serif']
                },
                extend: {
                    colors: {
                        primary: {
                            50: '#eff6ff',
                            100: '#dbeafe',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                            900: '#1e3a8a'
                        },
                        emerald: {
                            50: '#ecfdf5',
                            500: '#10b981',
                            600: '#059669'
                        },
                        slate: {
                            50: '#f8fafc',
                            100: '#f1f5f9',
                            600: '#475569',
                            700: '#334155',
                            800: '#1e293b',
                            900: '#0f172a'
                        }
                    },
                    animation: {
                        'float': 'float 6s ease-in-out infinite',
                        'gradient-x': 'gradientX 15s ease infinite'
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': { transform: 'translateY(0px)' },
                            '50%': { transform: 'translateY(-20px)' }
                        },
                        gradientX: {
                            '0%,100%': { 'background-position': '0% 50%' },
                            '50%': { 'background-position': '100% 50%' }
                        }
                    }
                }
            }
        }
    </script>

    <style>
        .glass-effect {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .input-group {
            position: relative;
        }

        .input-group input:focus + .input-icon {
            color: #2563eb;
        }

        .login-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .pattern-bg {
            background-image: radial-gradient(circle at 25px 25px, rgba(255,255,255,0.1) 2px, transparent 2px);
            background-size: 50px 50px;
        }

        /* Toast Styles */
        .toastify {
            font-family: 'Inter', sans-serif !important;
            backdrop-filter: blur(8px);
            background: linear-gradient(90deg, rgba(239, 68, 68, 0.95), rgba(220, 38, 38, 0.95)) !important;
            border-radius: 0.75rem !important;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04) !important;
            top: 100px !important;
            right: 20px !important;
            padding: 1rem 3rem 1rem 1rem !important;
            color: #ffffff !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
        }

        .toastify.success {
            background: linear-gradient(90deg, rgba(16, 185, 129, 0.95), rgba(5, 150, 105, 0.95)) !important;
        }

        .toastify-close {
            color: #ffffff !important;
            opacity: 0.8 !important;
            font-size: 1.1rem !important;
            position: absolute !important;
            top: 1rem !important;
            right: 0.75rem !important;
        }

        .floating-elements {
            position: absolute;
            width: 100%;
            height: 100%;
            overflow: hidden;
        }

        .floating-element {
            position: absolute;
            opacity: 0.1;
            animation: float 6s ease-in-out infinite;
        }

        .floating-element:nth-child(1) { top: 20%; left: 10%; animation-delay: 0s; }
        .floating-element:nth-child(2) { top: 60%; right: 15%; animation-delay: 2s; }
        .floating-element:nth-child(3) { bottom: 20%; left: 20%; animation-delay: 4s; }
        .floating-element:nth-child(4) { top: 40%; right: 30%; animation-delay: 1s; }
    </style>
</head>

<body class="bg-slate-50 font-sans">
    {{-- Navbar --}}
    <nav class="fixed w-full top-0 z-50 glass-effect">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-primary-600 to-primary-700 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-book-quran text-white text-lg"></i>
                    </div>
                    <span class="text-xl font-bold text-slate-800">QuranFlow</span>
                </div>
                
                <div class="flex items-center space-x-4">
                    <a href="/" class="text-slate-600 hover:text-primary-600 font-medium transition-colors duration-200">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Back to Home
                    </a>
                </div>
            </div>
        </div>
    </nav>

    {{-- Login Section --}}
    <section class="min-h-screen flex items-center justify-center login-bg pattern-bg pt-16 relative overflow-hidden">
        <!-- Floating Background Elements -->
        <div class="floating-elements">
            <div class="floating-element">
                <i class="fas fa-book-quran text-6xl text-white"></i>
            </div>
            <div class="floating-element">
                <i class="fas fa-mosque text-5xl text-white"></i>
            </div>
            <div class="floating-element">
                <i class="fas fa-star-and-crescent text-4xl text-white"></i>
            </div>
            <div class="floating-element">
                <i class="fas fa-pray text-5xl text-white"></i>
            </div>
        </div>

        <div class="relative z-10 w-full max-w-lg mx-4">
            <!-- Login Card -->
            <div class="glass-effect rounded-3xl shadow-2xl p-8 lg:p-12" data-aos="fade-up" data-aos-duration="800">
                <!-- Header -->
                <div class="text-center mb-8">
                    <div class="w-20 h-20 bg-gradient-to-br from-primary-600 to-emerald-600 rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-lg">
                        <i class="fas fa-book-quran text-white text-2xl"></i>
                    </div>
                    <h1 class="text-3xl lg:text-4xl font-bold text-slate-900 mb-2">Welcome Back</h1>
                    <p class="text-slate-600 text-lg">Sign in to continue your Quranic journey</p>
                </div>

                <!-- Login Form -->
                <form method="POST" action="{{ route('login') }}" class="space-y-6" aria-label="Login form">
                    @csrf

                    <!-- Email Field -->
                    <div class="input-group">
                        <label for="email" class="block text-slate-700 font-medium mb-2 text-sm">Email Address</label>
                        <div class="relative">
                            <input 
                                id="email" 
                                name="email" 
                                type="email" 
                                required
                                class="w-full pl-12 pr-4 py-4 rounded-xl bg-white border-2 border-slate-200 text-slate-800 placeholder-slate-400 focus:border-primary-500 focus:ring-4 focus:ring-primary-100 transition-all duration-200 text-lg"
                                placeholder="Enter your email address"
                                value="{{ old('email') }}"
                            >
                            <i class="input-icon fas fa-envelope absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 transition-colors duration-200"></i>
                        </div>
                    </div>

                    <!-- Password Field -->
                    <div class="input-group">
                        <label for="password" class="block text-slate-700 font-medium mb-2 text-sm">Password</label>
                        <div class="relative">
                            <input 
                                id="password" 
                                name="password" 
                                type="password" 
                                required
                                class="w-full pl-12 pr-14 py-4 rounded-xl bg-white border-2 border-slate-200 text-slate-800 placeholder-slate-400 focus:border-primary-500 focus:ring-4 focus:ring-primary-100 transition-all duration-200 text-lg"
                                placeholder="Enter your password"
                            >
                            <i class="input-icon fas fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 transition-colors duration-200"></i>
                            <button 
                                type="button"
                                id="toggle-password" 
                                class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 transition-colors duration-200"
                                aria-label="Toggle password visibility"
                            >
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Remember Me & Forgot Password -->
                    <div class="flex items-center justify-between">
                        <label class="flex items-center">
                            <input 
                                type="checkbox" 
                                name="remember"
                                class="w-4 h-4 text-primary-600 bg-white border-2 border-slate-300 rounded focus:ring-primary-500 focus:ring-2 transition-colors duration-200"
                            >
                            <span class="ml-3 text-slate-600 font-medium">Remember me</span>
                        </label>
                        <a href="#" class="text-primary-600 hover:text-primary-700 font-medium transition-colors duration-200">
                            Forgot Password?
                        </a>
                    </div>

                    <!-- Login Button -->
                    <button 
                        type="submit"
                        class="w-full bg-gradient-to-r from-primary-600 to-primary-700 hover:from-primary-700 hover:to-primary-800 text-white font-semibold py-4 px-6 rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-200 text-lg flex items-center justify-center space-x-2"
                    >
                        <span>Sign In to QuranFlow</span>
                        <i class="fas fa-arrow-right"></i>
                    </button>
                </form>


                <!-- Sign Up Link -->

                <!-- Trust Indicators -->
                <div class="mt-8 pt-8 border-t border-slate-200">
                    <div class="flex items-center justify-center space-x-6 text-slate-500">
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-shield-alt text-emerald-500"></i>
                            <span class="text-sm">Secure Login</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-users text-primary-500"></i>
                            <span class="text-sm">50+ Academies</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Additional Info -->
            <div class="text-center mt-8 text-white/80">
                <p class="text-sm">
                    By signing in, you agree to our 
                    <a href="#" class="underline hover:text-white transition-colors">Terms of Service</a> 
                    and 
                    <a href="#" class="underline hover:text-white transition-colors">Privacy Policy</a>
                </p>
            </div>
        </div>
    </section>

    <script>
        // Initialize AOS
        AOS.init({
            once: true,
            offset: 100,
            duration: 800
        });

        // Password Toggle Functionality
        document.addEventListener('DOMContentLoaded', () => {
            const passwordInput = document.getElementById('password');
            const togglePassword = document.getElementById('toggle-password');

            togglePassword.addEventListener('click', () => {
                const isPassword = passwordInput.type === 'password';
                passwordInput.type = isPassword ? 'text' : 'password';
                
                const icon = togglePassword.querySelector('i');
                icon.classList.toggle('fa-eye', !isPassword);
                icon.classList.toggle('fa-eye-slash', isPassword);
            });

            // Form validation feedback
            const form = document.querySelector('form');
            const inputs = form.querySelectorAll('input[required]');

            inputs.forEach(input => {
                input.addEventListener('blur', validateField);
                input.addEventListener('input', clearErrors);
            });

            function validateField(e) {
                const field = e.target;
                const value = field.value.trim();
                
                // Remove existing error styling
                field.classList.remove('border-red-500', 'focus:border-red-500', 'focus:ring-red-100');
                
                // Email validation
                if (field.type === 'email' && value) {
                    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    if (!emailRegex.test(value)) {
                        field.classList.add('border-red-500', 'focus:border-red-500', 'focus:ring-red-100');
                    }
                }
                
                // Password validation
                if (field.type === 'password' && value && value.length < 6) {
                    field.classList.add('border-red-500', 'focus:border-red-500', 'focus:ring-red-100');
                }
            }

            function clearErrors(e) {
                const field = e.target;
                field.classList.remove('border-red-500', 'focus:border-red-500', 'focus:ring-red-100');
            }
        });

        // Display Laravel validation errors
        @if ($errors->any())
            document.addEventListener('DOMContentLoaded', () => {
                const errors = @json($errors->all());
                errors.forEach((error, index) => {
                    setTimeout(() => {
                        Toastify({
                            text: error,
                            duration: 4000,
                            gravity: "top",
                            position: "right",
                            backgroundColor: "transparent",
                            className: "rounded-xl shadow-lg",
                            stopOnFocus: true,
                            close: true
                        }).showToast();
                    }, index * 500);
                });
            });
        @endif

        // Success message handling
        @if (session('success'))
            document.addEventListener('DOMContentLoaded', () => {
                Toastify({
                    text: "{{ session('success') }}",
                    duration: 3000,
                    gravity: "top",
                    position: "right",
                    backgroundColor: "transparent",
                    className: "rounded-xl shadow-lg success",
                    stopOnFocus: true,
                    close: true
                }).showToast();
            });
        @endif
    </script>
</body>

</html>