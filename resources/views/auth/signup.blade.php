<!DOCTYPE html>
<html lang="en" class="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request Academy Access - QuranFlow</title>

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
                        'pulse-slow': 'pulse 4s infinite',
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

        .input-group input:focus + .input-icon,
        .input-group textarea:focus + .input-icon {
            color: #2563eb;
        }

        .signup-bg {
            background: linear-gradient(135deg, #059669 0%, #2563eb 100%);
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

        .floating-element:nth-child(1) { top: 15%; left: 10%; animation-delay: 0s; }
        .floating-element:nth-child(2) { top: 70%; right: 15%; animation-delay: 2s; }
        .floating-element:nth-child(3) { bottom: 15%; left: 20%; animation-delay: 4s; }
        .floating-element:nth-child(4) { top: 45%; right: 25%; animation-delay: 1s; }
        .floating-element:nth-child(5) { top: 25%; left: 60%; animation-delay: 3s; }
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
                    <a href="{{ route('login') }}" class="text-slate-600 hover:text-primary-600 font-medium transition-colors duration-200">
                        Sign In
                    </a>
                </div>
            </div>
        </div>
    </nav>

    {{-- Academy Access Request Section --}}
    <section class="min-h-screen flex items-center justify-center signup-bg pattern-bg pt-16 relative overflow-hidden">
        <!-- Floating Background Elements -->
        <div class="floating-elements">
            <div class="floating-element">
                <i class="fas fa-university text-6xl text-white"></i>
            </div>
            <div class="floating-element">
                <i class="fas fa-chalkboard-teacher text-5xl text-white"></i>
            </div>
            <div class="floating-element">
                <i class="fas fa-users text-4xl text-white"></i>
            </div>
            <div class="floating-element">
                <i class="fas fa-book-open text-5xl text-white"></i>
            </div>
            <div class="floating-element">
                <i class="fas fa-graduation-cap text-4xl text-white"></i>
            </div>
        </div>

        <div class="relative z-10 w-full max-w-2xl mx-4">
            <!-- Request Access Card -->
            <div class="glass-effect rounded-3xl shadow-2xl p-8 lg:p-12" data-aos="fade-up" data-aos-duration="800">
                <!-- Header -->
                <div class="text-center mb-8">
                    <div class="w-20 h-20 bg-gradient-to-br from-emerald-500 to-primary-600 rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-lg">
                        <i class="fas fa-university text-white text-2xl"></i>
                    </div>
                    <h1 class="text-3xl lg:text-4xl font-bold text-slate-900 mb-2">Request Academy Access</h1>
                    <p class="text-slate-600 text-lg">Join the QuranFlow community and transform your Islamic education</p>
                </div>

                <!-- Process Info -->
                <div class="bg-primary-50 border border-primary-200 rounded-2xl p-6 mb-8" data-aos="fade-up" data-aos-delay="200">
                    <div class="flex items-center mb-4">
                        <i class="fas fa-info-circle text-primary-600 text-xl mr-3"></i>
                        <h3 class="text-lg font-semibold text-primary-900">How It Works</h3>
                    </div>
                    <div class="grid md:grid-cols-3 gap-4 text-sm">
                        <div class="flex items-start space-x-3">
                            <div class="w-6 h-6 bg-primary-600 text-white rounded-full flex items-center justify-center text-xs font-bold">1</div>
                            <div>
                                <div class="font-medium text-primary-900">Submit Request</div>
                                <div class="text-primary-700">Fill out academy details</div>
                            </div>
                        </div>
                        <div class="flex items-start space-x-3">
                            <div class="w-6 h-6 bg-primary-600 text-white rounded-full flex items-center justify-center text-xs font-bold">2</div>
                            <div>
                                <div class="font-medium text-primary-900">Admin Review</div>
                                <div class="text-primary-700">We verify your academy</div>
                            </div>
                        </div>
                        <div class="flex items-start space-x-3">
                            <div class="w-6 h-6 bg-primary-600 text-white rounded-full flex items-center justify-center text-xs font-bold">3</div>
                            <div>
                                <div class="font-medium text-primary-900">Get Access</div>
                                <div class="text-primary-700">Receive login credentials</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Request Form -->
                <form method="POST" action="" class="space-y-6" aria-label="Academy access request form">
                    @csrf

                    <div class="grid md:grid-cols-2 gap-6">
                        <!-- Full Name -->
                        <div class="input-group">
                            <label for="name" class="block text-slate-700 font-medium mb-2 text-sm">Full Name *</label>
                            <div class="relative">
                                <input 
                                    id="name" 
                                    name="name" 
                                    type="text" 
                                    required
                                    class="w-full pl-12 pr-4 py-4 rounded-xl bg-white border-2 border-slate-200 text-slate-800 placeholder-slate-400 focus:border-primary-500 focus:ring-4 focus:ring-primary-100 transition-all duration-200"
                                    placeholder="Your full name"
                                    value="{{ old('name') }}"
                                >
                                <i class="input-icon fas fa-user absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 transition-colors duration-200"></i>
                            </div>
                        </div>

                        <!-- Email Address -->
                        <div class="input-group">
                            <label for="email" class="block text-slate-700 font-medium mb-2 text-sm">Email Address *</label>
                            <div class="relative">
                                <input 
                                    id="email" 
                                    name="email" 
                                    type="email" 
                                    required
                                    class="w-full pl-12 pr-4 py-4 rounded-xl bg-white border-2 border-slate-200 text-slate-800 placeholder-slate-400 focus:border-primary-500 focus:ring-4 focus:ring-primary-100 transition-all duration-200"
                                    placeholder="your@email.com"
                                    value="{{ old('email') }}"
                                >
                                <i class="input-icon fas fa-envelope absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 transition-colors duration-200"></i>
                            </div>
                        </div>
                    </div>

                    <div class="grid md:grid-cols-2 gap-6">
                        <!-- Phone Number -->
                        <div class="input-group">
                            <label for="phone" class="block text-slate-700 font-medium mb-2 text-sm">Phone Number *</label>
                            <div class="relative">
                                <input 
                                    id="phone" 
                                    name="phone" 
                                    type="tel" 
                                    required
                                    class="w-full pl-12 pr-4 py-4 rounded-xl bg-white border-2 border-slate-200 text-slate-800 placeholder-slate-400 focus:border-primary-500 focus:ring-4 focus:ring-primary-100 transition-all duration-200"
                                    placeholder="+1 (555) 123-4567"
                                    value="{{ old('phone') }}"
                                >
                                <i class="input-icon fas fa-phone absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 transition-colors duration-200"></i>
                            </div>
                        </div>

                        <!-- Position/Title -->
                        <div class="input-group">
                            <label for="position" class="block text-slate-700 font-medium mb-2 text-sm">Your Position *</label>
                            <div class="relative">
                                <select 
                                    id="position" 
                                    name="position" 
                                    required
                                    class="w-full pl-12 pr-4 py-4 rounded-xl bg-white border-2 border-slate-200 text-slate-800 focus:border-primary-500 focus:ring-4 focus:ring-primary-100 transition-all duration-200"
                                >
                                    <option value="">Select your position</option>
                                    <option value="director" {{ old('position') == 'director' ? 'selected' : '' }}>Academy Director</option>
                                    <option value="principal" {{ old('position') == 'principal' ? 'selected' : '' }}>Principal</option>
                                    <option value="admin" {{ old('position') == 'admin' ? 'selected' : '' }}>Administrator</option>
                                    <option value="owner" {{ old('position') == 'owner' ? 'selected' : '' }}>Academy Owner</option>
                                    <option value="other" {{ old('position') == 'other' ? 'selected' : '' }}>Other</option>
                                </select>
                                <i class="input-icon fas fa-briefcase absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 transition-colors duration-200"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Academy Name -->
                    <div class="input-group">
                        <label for="academy_name" class="block text-slate-700 font-medium mb-2 text-sm">Academy Name *</label>
                        <div class="relative">
                            <input 
                                id="academy_name" 
                                name="academy_name" 
                                type="text" 
                                required
                                class="w-full pl-12 pr-4 py-4 rounded-xl bg-white border-2 border-slate-200 text-slate-800 placeholder-slate-400 focus:border-primary-500 focus:ring-4 focus:ring-primary-100 transition-all duration-200"
                                placeholder="Enter your academy name"
                                value="{{ old('academy_name') }}"
                            >
                            <i class="input-icon fas fa-university absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 transition-colors duration-200"></i>
                        </div>
                    </div>

                    <!-- Academy Details -->
                    <div class="grid md:grid-cols-2 gap-6">
                        <!-- Students Count -->
                        <div class="input-group">
                            <label for="student_count" class="block text-slate-700 font-medium mb-2 text-sm">Current Students *</label>
                            <div class="relative">
                                <select 
                                    id="student_count" 
                                    name="student_count" 
                                    required
                                    class="w-full pl-12 pr-4 py-4 rounded-xl bg-white border-2 border-slate-200 text-slate-800 focus:border-primary-500 focus:ring-4 focus:ring-primary-100 transition-all duration-200"
                                >
                                    <option value="">Select student count</option>
                                    <option value="1-50" {{ old('student_count') == '1-50' ? 'selected' : '' }}>1-50 Students</option>
                                    <option value="51-100" {{ old('student_count') == '51-100' ? 'selected' : '' }}>51-100 Students</option>
                                    <option value="101-200" {{ old('student_count') == '101-200' ? 'selected' : '' }}>101-200 Students</option>
                                    <option value="201-500" {{ old('student_count') == '201-500' ? 'selected' : '' }}>201-500 Students</option>
                                    <option value="500+" {{ old('student_count') == '500+' ? 'selected' : '' }}>500+ Students</option>
                                </select>
                                <i class="input-icon fas fa-users absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 transition-colors duration-200"></i>
                            </div>
                        </div>

                        <!-- Teachers Count -->
                        <div class="input-group">
                            <label for="teacher_count" class="block text-slate-700 font-medium mb-2 text-sm">Number of Teachers *</label>
                            <div class="relative">
                                <select 
                                    id="teacher_count" 
                                    name="teacher_count" 
                                    required
                                    class="w-full pl-12 pr-4 py-4 rounded-xl bg-white border-2 border-slate-200 text-slate-800 focus:border-primary-500 focus:ring-4 focus:ring-primary-100 transition-all duration-200"
                                >
                                    <option value="">Select teacher count</option>
                                    <option value="1-5" {{ old('teacher_count') == '1-5' ? 'selected' : '' }}>1-5 Teachers</option>
                                    <option value="6-10" {{ old('teacher_count') == '6-10' ? 'selected' : '' }}>6-10 Teachers</option>
                                    <option value="11-20" {{ old('teacher_count') == '11-20' ? 'selected' : '' }}>11-20 Teachers</option>
                                    <option value="21-50" {{ old('teacher_count') == '21-50' ? 'selected' : '' }}>21-50 Teachers</option>
                                    <option value="50+" {{ old('teacher_count') == '50+' ? 'selected' : '' }}>50+ Teachers</option>
                                </select>
                                <i class="input-icon fas fa-chalkboard-teacher absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 transition-colors duration-200"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Academy Address -->
                    <div class="input-group">
                        <label for="address" class="block text-slate-700 font-medium mb-2 text-sm">Academy Address *</label>
                        <div class="relative">
                            <textarea 
                                id="address" 
                                name="address" 
                                rows="3"
                                required
                                class="w-full pl-12 pr-4 py-4 rounded-xl bg-white border-2 border-slate-200 text-slate-800 placeholder-slate-400 focus:border-primary-500 focus:ring-4 focus:ring-primary-100 transition-all duration-200 resize-none"
                                placeholder="Enter complete academy address"
                            >{{ old('address') }}</textarea>
                            <i class="input-icon fas fa-map-marker-alt absolute left-4 top-6 text-slate-400 transition-colors duration-200"></i>
                        </div>
                    </div>

                    <!-- Additional Information -->
                    <div class="input-group">
                        <label for="message" class="block text-slate-700 font-medium mb-2 text-sm">Additional Information</label>
                        <div class="relative">
                            <textarea 
                                id="message" 
                                name="message" 
                                rows="4"
                                class="w-full pl-12 pr-4 py-4 rounded-xl bg-white border-2 border-slate-200 text-slate-800 placeholder-slate-400 focus:border-primary-500 focus:ring-4 focus:ring-primary-100 transition-all duration-200 resize-none"
                                placeholder="Tell us about your academy, current challenges, or specific requirements..."
                            >{{ old('message') }}</textarea>
                            <i class="input-icon fas fa-comment-alt absolute left-4 top-6 text-slate-400 transition-colors duration-200"></i>
                        </div>
                    </div>

                    <!-- Terms Agreement -->
                    <div class="flex items-start space-x-3">
                        <input 
                            type="checkbox" 
                            id="terms"
                            name="terms"
                            required
                            class="mt-1 w-5 h-5 text-primary-600 bg-white border-2 border-slate-300 rounded focus:ring-primary-500 focus:ring-2 transition-colors duration-200"
                        >
                        <label for="terms" class="text-slate-600 text-sm leading-relaxed">
                            I agree to the 
                            <a href="#" class="text-primary-600 hover:text-primary-700 font-medium">Terms of Service</a> 
                            and 
                            <a href="#" class="text-primary-600 hover:text-primary-700 font-medium">Privacy Policy</a>. 
                            I understand that account creation is subject to admin approval.
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <button 
                        type="submit"
                        class="w-full bg-gradient-to-r from-emerald-600 to-primary-600 hover:from-emerald-700 hover:to-primary-700 text-white font-semibold py-4 px-6 rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-200 text-lg flex items-center justify-center space-x-2"
                    >
                        <span>Submit Access Request</span>
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </form>

                <!-- Already Have Account -->
                <div class="relative my-8">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-slate-200"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-4 bg-white text-slate-500 font-medium">Already have access?</span>
                    </div>
                </div>

                <div class="text-center">
                    <a 
                        href="{{ route('login') }}" 
                        class="inline-flex items-center justify-center px-6 py-3 border-2 border-slate-200 hover:border-primary-300 text-slate-700 hover:text-primary-600 font-semibold rounded-xl transition-all duration-200 hover:bg-primary-50 space-x-2"
                    >
                        <span>Sign In to Your Account</span>
                        <i class="fas fa-sign-in-alt"></i>
                    </a>
                </div>

                <!-- Support Contact -->
                <div class="mt-8 pt-8 border-t border-slate-200">
                    <div class="text-center">
                        <p class="text-slate-600 text-sm mb-4">Need help with your request?</p>
                        <div class="flex flex-col sm:flex-row items-center justify-center space-y-2 sm:space-y-0 sm:space-x-6">
                            <a href="mailto:support@quranflow.com" class="flex items-center space-x-2 text-primary-600 hover:text-primary-700 transition-colors">
                                <i class="fas fa-envelope"></i>
                                <span>support@quranflow.com</span>
                            </a>
                            <a href="tel:+1234567890" class="flex items-center space-x-2 text-primary-600 hover:text-primary-700 transition-colors">
                                <i class="fas fa-phone"></i>
                                <span>+1 (234) 567-8900</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Response Time Info -->
            <div class="text-center mt-8 text-white/90">
                <div class="bg-white/20 backdrop-blur-lg rounded-2xl p-6">
                    <div class="flex items-center justify-center space-x-6">
                        <div class="text-center">
                            <div class="text-2xl font-bold">24-48h</div>
                            <div class="text-sm">Response Time</div>
                        </div>
                        <div class="w-px h-12 bg-white/30"></div>
                        <div class="text-center">
                            <div class="text-2xl font-bold">500+</div>
                            <div class="text-sm">Verified Academies</div>
                        </div>
                        <div class="w-px h-12 bg-white/30"></div>
                        <div class="text-center">
                            <div class="text-2xl font-bold">99%</div>
                            <div class="text-sm">Approval Rate</div>
                        </div>
                    </div>
                </div>
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

        // Form validation
        document.addEventListener('DOMContentLoaded', () => {
            const form = document.querySelector('form');
            const inputs = form.querySelectorAll('input[required], select[required], textarea[required]');

            inputs.forEach(input => {
                input.addEventListener('blur', validateField);
                input.addEventListener('input', clearErrors);
            });

            function validateField(e) {
                const field = e.target;
                const value = field.value.trim();
                
                field.classList.remove('border-red-500', 'focus:border-red-500', 'focus:ring-red-100');
                
                if (field.type === 'email' && value) {
                    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    if (!emailRegex.test(value)) {
                        field.classList.add('border-red-500', 'focus:border-red-500', 'focus:ring-red-100');
                    }
                }
                
                if (field.type === 'tel' && value) {
                    const phoneRegex = /^[\+]?[1-9][\d]{0,15}$/;
                    if (!phoneRegex.test(value.replace(/[\s\-\(\)]/g, ''))) {
                        field.classList.add('border-red-500', 'focus:border-red-500', 'focus:ring-red-100');
                    }
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
                    duration: 5000,
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