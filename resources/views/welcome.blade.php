<!DOCTYPE html>
<html lang="en" class="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QuranFlow - Complete Online Quran Academy Management Platform</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Amiri:wght@400;700&display=swap" rel="stylesheet">

    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                fontFamily: {
                    sans: ['Inter', 'sans-serif'],
                    arabic: ['Amiri', 'serif'],
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
                        'fade-in-up': 'fadeInUp 0.8s ease-out',
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': { transform: 'translateY(0px)' },
                            '50%': { transform: 'translateY(-20px)' }
                        },
                        fadeInUp: {
                            '0%': { opacity: '0', transform: 'translateY(30px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' }
                        }
                    }
                }
            }
        }
    </script>

    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .glass-effect {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .feature-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .feature-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
        }
        
        .testimonial-card {
            background: linear-gradient(145deg, #ffffff 0%, #f8fafc 100%);
        }
        
        /* Navigation Enhancements */
        .nav-link::after {
            content: '';
            position: absolute;
            bottom: -4px;
            left: 0;
            width: 0;
            height: 2px;
            background: linear-gradient(90deg, #2563eb, #059669);
            transition: width 0.3s ease;
        }
        
        .nav-link:hover::after,
        .nav-link.active::after {
            width: 100%;
        }
        
        /* Hamburger Menu Animation */
        .hamburger-menu {
            width: 24px;
            height: 18px;
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        
        .hamburger-line {
            width: 100%;
            height: 2px;
            background-color: #475569;
            transition: all 0.3s ease;
            transform-origin: center;
        }
        
        .hamburger-menu.active .hamburger-line:nth-child(1) {
            transform: rotate(45deg) translate(6px, 6px);
        }
        
        .hamburger-menu.active .hamburger-line:nth-child(2) {
            opacity: 0;
        }
        
        .hamburger-menu.active .hamburger-line:nth-child(3) {
            transform: rotate(-45deg) translate(6px, -6px);
        }
        
        /* Mobile Menu Animation */
        #mobileMenu.show {
            transform: translateY(0);
            opacity: 1;
            visibility: visible;
        }
        
        /* Navbar Scroll Effect */
        #navbar.scrolled {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(20px);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }
        
        /* Active Section Highlighting */
        .nav-link.active {
            color: #2563eb;
            font-weight: 600;
        }
    </style>
</head>

<body class="bg-slate-50 font-sans">
    <!-- Modern Navigation -->
    <nav class="fixed w-full top-0 z-50 glass-effect transition-all duration-300" id="navbar">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo Section -->
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-primary-600 to-primary-700 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-book-quran text-white text-lg"></i>
                    </div>
                    <span class="text-xl font-bold text-slate-800">QuranFlow</span>
                </div>
                
                <!-- Desktop Navigation Menu -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#home" class="nav-link text-slate-600 hover:text-primary-600 font-medium transition-colors duration-200 relative">
                        Home
                    </a>
                    <a href="#features" class="nav-link text-slate-600 hover:text-primary-600 font-medium transition-colors duration-200 relative">
                        Features
                    </a>
                    <a href="#pricing" class="nav-link text-slate-600 hover:text-primary-600 font-medium transition-colors duration-200 relative">
                        Pricing
                    </a>
                    <a href="#testimonials" class="nav-link text-slate-600 hover:text-primary-600 font-medium transition-colors duration-200 relative">
                        Reviews
                    </a>
                    <a href="#contact" class="nav-link text-slate-600 hover:text-primary-600 font-medium transition-colors duration-200 relative">
                        Contact
                    </a>
                    
                    <!-- Divider -->
                    <div class="w-px h-6 bg-slate-300"></div>
                    
                    <!-- Auth Buttons -->
                    <a href="/login" class="text-slate-600 hover:text-primary-600 font-medium transition-colors duration-200">
                        Login
                    </a>
                    <a href="/register" class="bg-gradient-to-r from-primary-600 to-primary-700 text-white px-6 py-2.5 rounded-xl hover:from-primary-700 hover:to-primary-800 font-medium transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                        Start Free Trial
                    </a>
                </div>

                <!-- Mobile Menu Button -->
                <button id="mobileMenuBtn" class="md:hidden p-2 rounded-lg hover:bg-slate-100 transition-colors duration-200">
                    <div class="hamburger-menu">
                        <span class="hamburger-line"></span>
                        <span class="hamburger-line"></span>
                        <span class="hamburger-line"></span>
                    </div>
                </button>
            </div>
            
            <!-- Mobile Navigation Menu -->
            <div id="mobileMenu" class="md:hidden absolute top-full left-0 right-0 bg-white/95 backdrop-blur-lg border-t border-slate-200 shadow-xl transform -translate-y-full opacity-0 invisible transition-all duration-300">
                <div class="px-4 py-6 space-y-4">
                    <a href="#home" class="mobile-nav-link block py-3 px-4 text-slate-700 hover:text-primary-600 hover:bg-primary-50 rounded-lg font-medium transition-all duration-200">
                        <i class="fas fa-home mr-3 text-primary-600"></i>
                        Home
                    </a>
                    <a href="#features" class="mobile-nav-link block py-3 px-4 text-slate-700 hover:text-primary-600 hover:bg-primary-50 rounded-lg font-medium transition-all duration-200">
                        <i class="fas fa-star mr-3 text-primary-600"></i>
                        Features
                    </a>
                    <a href="#pricing" class="mobile-nav-link block py-3 px-4 text-slate-700 hover:text-primary-600 hover:bg-primary-50 rounded-lg font-medium transition-all duration-200">
                        <i class="fas fa-tag mr-3 text-primary-600"></i>
                        Pricing
                    </a>
                    <a href="#testimonials" class="mobile-nav-link block py-3 px-4 text-slate-700 hover:text-primary-600 hover:bg-primary-50 rounded-lg font-medium transition-all duration-200">
                        <i class="fas fa-comments mr-3 text-primary-600"></i>
                        Reviews
                    </a>
                    <a href="#contact" class="mobile-nav-link block py-3 px-4 text-slate-700 hover:text-primary-600 hover:bg-primary-50 rounded-lg font-medium transition-all duration-200">
                        <i class="fas fa-envelope mr-3 text-primary-600"></i>
                        Contact
                    </a>
                    
                    <!-- Mobile Auth Section -->
                    <div class="pt-4 border-t border-slate-200 space-y-3">
                        <a href="/login" class="block py-3 px-4 text-center text-slate-700 hover:text-primary-600 hover:bg-slate-50 rounded-lg font-medium transition-all duration-200">
                            Login to Account
                        </a>
                        <a href="/register" class="block py-3 px-4 text-center bg-gradient-to-r from-primary-600 to-primary-700 text-white rounded-lg font-medium hover:from-primary-700 hover:to-primary-800 transition-all duration-200 shadow-lg">
                            Start Free Trial
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="pt-24 pb-20 bg-gradient-to-br from-primary-50 via-white to-emerald-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <div class="space-y-8" data-aos="fade-right">
                    <div class="inline-flex items-center bg-primary-100 text-primary-600 px-4 py-2 rounded-full text-sm font-medium">
                        <i class="fas fa-star mr-2"></i>
                        Trusted by 500+ Quran Academies
                    </div>
                    
                    <h1 class="text-5xl lg:text-6xl font-bold text-slate-900 leading-tight">
                        Complete
                        <span class="bg-gradient-to-r from-primary-600 to-emerald-600 bg-clip-text text-transparent">
                            Quran Academy
                        </span>
                        Management Platform
                    </h1>
                    
                    <p class="text-xl text-slate-600 leading-relaxed">
                        Streamline your online Quran teaching with integrated virtual classrooms, student management, 
                        attendance tracking, and comprehensive admin tools - all in one platform.
                    </p>
                    
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="#signup" class="bg-primary-600 text-white px-8 py-4 rounded-xl hover:bg-primary-700 font-semibold text-lg shadow-lg hover:shadow-xl transition-all">
                            Start 14-Day Free Trial
                        </a>
                        <a href="#demo" class="border-2 border-slate-300 text-slate-700 px-8 py-4 rounded-xl hover:bg-slate-50 font-semibold text-lg transition-all">
                            <i class="fas fa-play mr-2"></i>
                            Watch Demo
                        </a>
                    </div>
                    
                    <div class="flex items-center space-x-6 pt-4">
                        <div class="flex -space-x-3">
                            <img src="https://i.pravatar.cc/40?img=1" class="w-10 h-10 rounded-full border-2 border-white" alt="User">
                            <img src="https://i.pravatar.cc/40?img=2" class="w-10 h-10 rounded-full border-2 border-white" alt="User">
                            <img src="https://i.pravatar.cc/40?img=3" class="w-10 h-10 rounded-full border-2 border-white" alt="User">
                            <div class="w-10 h-10 bg-primary-600 rounded-full border-2 border-white flex items-center justify-center text-white text-sm font-bold">
                                500+
                            </div>
                        </div>
                        <div class="text-slate-600">
                            <div class="font-semibold">Join successful academies</div>
                            <div class="text-sm">Growing their business with QuranFlow</div>
                        </div>
                    </div>
                </div>
                
                <div class="relative" data-aos="fade-left">
                    <div class="relative">
                        <!-- Main Dashboard Preview -->
                        <div class="bg-white rounded-2xl shadow-2xl p-6 transform rotate-3 hover:rotate-0 transition-transform duration-500">
                            <div class="flex items-center justify-between mb-6">
                                <h3 class="font-bold text-slate-800">Academy Dashboard</h3>
                                <div class="flex space-x-2">
                                    <div class="w-3 h-3 bg-red-400 rounded-full"></div>
                                    <div class="w-3 h-3 bg-yellow-400 rounded-full"></div>
                                    <div class="w-3 h-3 bg-green-400 rounded-full"></div>
                                </div>
                            </div>
                            
                            <!-- Stats Cards -->
                            <div class="grid grid-cols-2 gap-4 mb-6">
                                <div class="bg-primary-50 p-4 rounded-lg">
                                    <div class="text-2xl font-bold text-primary-600">248</div>
                                    <div class="text-sm text-slate-600">Active Students</div>
                                </div>
                                <div class="bg-emerald-50 p-4 rounded-lg">
                                    <div class="text-2xl font-bold text-emerald-600">18</div>
                                    <div class="text-sm text-slate-600">Teachers</div>
                                </div>
                            </div>
                            
                            <!-- Virtual Classroom Preview -->
                            <div class="bg-slate-100 rounded-lg p-4 mb-4">
                                <div class="flex items-center justify-between mb-3">
                                    <span class="text-sm font-medium">Live Class: Surah Al-Fatiha</span>
                                    <span class="bg-red-500 text-white text-xs px-2 py-1 rounded-full">LIVE</span>
                                </div>
                                <div class="grid grid-cols-3 gap-2">
                                    <div class="bg-primary-100 h-16 rounded"></div>
                                    <div class="bg-emerald-100 h-16 rounded"></div>
                                    <div class="bg-yellow-100 h-16 rounded"></div>
                                </div>
                            </div>
                            
                            <!-- Attendance Chart -->
                            <div class="h-32 bg-gradient-to-r from-primary-100 to-emerald-100 rounded-lg"></div>
                        </div>
                        
                        <!-- Floating Elements -->
                        <div class="absolute -top-4 -right-4 bg-emerald-500 text-white p-3 rounded-full animate-float">
                            <i class="fas fa-video"></i>
                        </div>
                        <div class="absolute -bottom-4 -left-4 bg-primary-500 text-white p-3 rounded-full animate-float" style="animation-delay: 2s;">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Key Features Section -->
    <section id="features" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16" data-aos="fade-up">
                <h2 class="text-4xl font-bold text-slate-900 mb-4">Everything Your Academy Needs</h2>
                <p class="text-xl text-slate-600 max-w-3xl mx-auto">
                    Comprehensive tools designed specifically for Quran education institutions
                </p>
            </div>
            
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Virtual Classroom -->
                <div class="feature-card bg-white p-8 rounded-2xl shadow-lg" data-aos="fade-up" data-aos-delay="100">
                    <div class="w-16 h-16 bg-primary-100 rounded-2xl flex items-center justify-center mb-6">
                        <i class="fas fa-chalkboard-teacher text-2xl text-primary-600"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-4">Built-in Virtual Classroom</h3>
                    <p class="text-slate-600 mb-4">
                        No more external links! Teachers and students join classes directly within our platform with HD video, audio, and screen sharing.
                    </p>
                    <ul class="space-y-2 text-sm text-slate-600">
                        <li><i class="fas fa-check text-emerald-500 mr-2"></i>HD Video & Audio</li>
                        <li><i class="fas fa-check text-emerald-500 mr-2"></i>Screen Sharing</li>
                        <li><i class="fas fa-check text-emerald-500 mr-2"></i>Interactive Whiteboard</li>
                    </ul>
                </div>

                <!-- Student Management -->
                <div class="feature-card bg-white p-8 rounded-2xl shadow-lg" data-aos="fade-up" data-aos-delay="200">
                    <div class="w-16 h-16 bg-emerald-100 rounded-2xl flex items-center justify-center mb-6">
                        <i class="fas fa-users text-2xl text-emerald-600"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-4">Complete Student Management</h3>
                    <p class="text-slate-600 mb-4">
                        Manage student profiles, track progress, handle enrollments, and maintain comprehensive records effortlessly.
                    </p>
                    <ul class="space-y-2 text-sm text-slate-600">
                        <li><i class="fas fa-check text-emerald-500 mr-2"></i>Student Profiles</li>
                        <li><i class="fas fa-check text-emerald-500 mr-2"></i>Progress Tracking</li>
                        <li><i class="fas fa-check text-emerald-500 mr-2"></i>Performance Analytics</li>
                    </ul>
                </div>

                <!-- Attendance System -->
                <div class="feature-card bg-white p-8 rounded-2xl shadow-lg" data-aos="fade-up" data-aos-delay="300">
                    <div class="w-16 h-16 bg-purple-100 rounded-2xl flex items-center justify-center mb-6">
                        <i class="fas fa-calendar-check text-2xl text-purple-600"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-4">Smart Attendance Tracking</h3>
                    <p class="text-slate-600 mb-4">
                        Automatic attendance marking when students join classes, with detailed reports for parents and administrators.
                    </p>
                    <ul class="space-y-2 text-sm text-slate-600">
                        <li><i class="fas fa-check text-emerald-500 mr-2"></i>Auto Attendance</li>
                        <li><i class="fas fa-check text-emerald-500 mr-2"></i>Detailed Reports</li>
                        <li><i class="fas fa-check text-emerald-500 mr-2"></i>Parent Notifications</li>
                    </ul>
                </div>

                <!-- Communication Hub -->
                <div class="feature-card bg-white p-8 rounded-2xl shadow-lg" data-aos="fade-up" data-aos-delay="400">
                    <div class="w-16 h-16 bg-blue-100 rounded-2xl flex items-center justify-center mb-6">
                        <i class="fas fa-comments text-2xl text-blue-600"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-4">Easy Communication</h3>
                    <p class="text-slate-600 mb-4">
                        Send notifications, announcements, and messages to students, parents, and teachers instantly.
                    </p>
                    <ul class="space-y-2 text-sm text-slate-600">
                        <li><i class="fas fa-check text-emerald-500 mr-2"></i>Instant Notifications</li>
                        <li><i class="fas fa-check text-emerald-500 mr-2"></i>Group Messaging</li>
                        <li><i class="fas fa-check text-emerald-500 mr-2"></i>Email Integration</li>
                    </ul>
                </div>

                <!-- Complaint Management -->
                <div class="feature-card bg-white p-8 rounded-2xl shadow-lg" data-aos="fade-up" data-aos-delay="500">
                    <div class="w-16 h-16 bg-red-100 rounded-2xl flex items-center justify-center mb-6">
                        <i class="fas fa-headset text-2xl text-red-600"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-4">Complaint Resolution</h3>
                    <p class="text-slate-600 mb-4">
                        Structured system to handle and resolve student/parent complaints with tracking and follow-up features.
                    </p>
                    <ul class="space-y-2 text-sm text-slate-600">
                        <li><i class="fas fa-check text-emerald-500 mr-2"></i>Ticket System</li>
                        <li><i class="fas fa-check text-emerald-500 mr-2"></i>Priority Management</li>
                        <li><i class="fas fa-check text-emerald-500 mr-2"></i>Resolution Tracking</li>
                    </ul>
                </div>

                <!-- Records Management -->
                <div class="feature-card bg-white p-8 rounded-2xl shadow-lg" data-aos="fade-up" data-aos-delay="600">
                    <div class="w-16 h-16 bg-yellow-100 rounded-2xl flex items-center justify-center mb-6">
                        <i class="fas fa-database text-2xl text-yellow-600"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-4">Comprehensive Records</h3>
                    <p class="text-slate-600 mb-4">
                        Secure storage and management of all academic records, certificates, and important documents.
                    </p>
                    <ul class="space-y-2 text-sm text-slate-600">
                        <li><i class="fas fa-check text-emerald-500 mr-2"></i>Secure Storage</li>
                        <li><i class="fas fa-check text-emerald-500 mr-2"></i>Document Management</li>
                        <li><i class="fas fa-check text-emerald-500 mr-2"></i>Certificate Generation</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Platform Showcase -->
    <section class="py-20 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16" data-aos="fade-up">
                <h2 class="text-4xl font-bold text-slate-900 mb-4">See QuranFlow in Action</h2>
                <p class="text-xl text-slate-600">Experience the complete workflow from admin to classroom</p>
            </div>
            
            <div class="grid lg:grid-cols-3 gap-8">
                <!-- Admin Dashboard -->
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden" data-aos="fade-up" data-aos-delay="100">
                    <div class="bg-primary-600 text-white p-6">
                        <h3 class="text-xl font-bold mb-2">Admin Dashboard</h3>
                        <p class="text-primary-100">Complete academy oversight</p>
                    </div>
                    <div class="p-6">
                        <ul class="space-y-3">
                            <li class="flex items-center">
                                <i class="fas fa-user-plus text-primary-600 mr-3"></i>
                                Add/Manage Teachers & Students
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-chart-line text-primary-600 mr-3"></i>
                                Real-time Analytics
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-credit-card text-primary-600 mr-3"></i>
                                Payment Management
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-cog text-primary-600 mr-3"></i>
                                System Configuration
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Teacher Portal -->
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden" data-aos="fade-up" data-aos-delay="200">
                    <div class="bg-emerald-600 text-white p-6">
                        <h3 class="text-xl font-bold mb-2">Teacher Portal</h3>
                        <p class="text-emerald-100">Focused teaching tools</p>
                    </div>
                    <div class="p-6">
                        <ul class="space-y-3">
                            <li class="flex items-center">
                                <i class="fas fa-video text-emerald-600 mr-3"></i>
                                Start Virtual Classes
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-clipboard-list text-emerald-600 mr-3"></i>
                                Mark Attendance
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-star text-emerald-600 mr-3"></i>
                                Grade Assignments
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-message text-emerald-600 mr-3"></i>
                                Communicate with Parents
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Student Experience -->
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden" data-aos="fade-up" data-aos-delay="300">
                    <div class="bg-purple-600 text-white p-6">
                        <h3 class="text-xl font-bold mb-2">Student Portal</h3>
                        <p class="text-purple-100">Seamless learning experience</p>
                    </div>
                    <div class="p-6">
                        <ul class="space-y-3">
                            <li class="flex items-center">
                                <i class="fas fa-play text-purple-600 mr-3"></i>
                                Join Classes Instantly
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-book text-purple-600 mr-3"></i>
                                Access Learning Materials
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-calendar text-purple-600 mr-3"></i>
                                View Schedule & Progress
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-certificate text-purple-600 mr-3"></i>
                                Download Certificates
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section id="testimonials" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16" data-aos="fade-up">
                <h2 class="text-4xl font-bold text-slate-900 mb-4">Loved by Academies Worldwide</h2>
                <p class="text-xl text-slate-600">See what our customers say about QuranFlow</p>
            </div>
            
            <div class="grid md:grid-cols-3 gap-8">
                <div class="testimonial-card p-8 rounded-2xl shadow-lg" data-aos="fade-up" data-aos-delay="100">
                    <div class="flex items-center mb-4">
                        <div class="flex text-yellow-400">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                    </div>
                    <p class="text-slate-600 mb-6 italic">
                        "QuranFlow transformed our academy. We went from managing 50 students manually to 300+ students seamlessly. The built-in classroom feature is a game-changer!"
                    </p>
                    <div class="flex items-center">
                        <img src="https://i.pravatar.cc/60?img=10" class="w-12 h-12 rounded-full mr-4" alt="Ahmed">
                        <div>
                            <div class="font-semibold text-slate-900">Ahmed Al-Rashid</div>
                            <div class="text-sm text-slate-600">Director, Al-Noor Academy</div>
                        </div>
                    </div>
                </div>

                <div class="testimonial-card p-8 rounded-2xl shadow-lg" data-aos="fade-up" data-aos-delay="200">
                    <div class="flex items-center mb-4">
                        <div class="flex text-yellow-400">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                    </div>
                    <p class="text-slate-600 mb-6 italic">
                        "The attendance tracking and parent communication features save us hours every week. Parents love getting real-time updates about their children's progress."
                    </p>
                    <div class="flex items-center">
                        <img src="https://i.pravatar.cc/60?img=20" class="w-12 h-12 rounded-full mr-4" alt="Fatima">
                        <div>
                            <div class="font-semibold text-slate-900">Sister Fatima</div>
                            <div class="text-sm text-slate-600">Principal, Dar Al-Quran</div>
                        </div>
                    </div>
                </div>

                <div class="testimonial-card p-8 rounded-2xl shadow-lg" data-aos="fade-up" data-aos-delay="300">
                    <div class="flex items-center mb-4">
                        <div class="flex text-yellow-400">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                    </div>
                    <p class="text-slate-600 mb-6 italic">
                        "As a teacher, I love how easy it is to start classes and track student progress. The platform is intuitive and my students enjoy the interactive features."
                    </p>
                    <div class="flex items-center">
                        <img src="https://i.pravatar.cc/60?img=30" class="w-12 h-12 rounded-full mr-4" alt="Omar">
                        <div>
                            <div class="font-semibold text-slate-900">Ustadh Omar</div>
                            <div class="text-sm text-slate-600">Senior Quran Teacher</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Pricing Section -->
    <section id="pricing" class="py-20 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16" data-aos="fade-up">
                <h2 class="text-4xl font-bold text-slate-900 mb-4">Simple, Transparent Pricing</h2>
                <p class="text-xl text-slate-600">Choose the perfect plan for your academy size</p>
            </div>
            
            <div class="grid md:grid-cols-3 gap-8 max-w-6xl mx-auto">
                <!-- Starter Plan -->
                <div class="bg-white rounded-2xl shadow-lg p-8" data-aos="fade-up" data-aos-delay="100">
                    <div class="text-center mb-8">
                        <h3 class="text-2xl font-bold text-slate-900 mb-2">Starter</h3>
                        <p class="text-slate-600 mb-6">Perfect for small academies</p>
                        <div class="text-4xl font-bold text-slate-900">$49<span class="text-lg text-slate-600">/month</span></div>
                    </div>
                    <ul class="space-y-4 mb-8">
                        <li class="flex items-center">
                            <i class="fas fa-check text-emerald-500 mr-3"></i>
                            Up to 50 students
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check text-emerald-500 mr-3"></i>
                            5 teachers
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check text-emerald-500 mr-3"></i>
                            Virtual classroom
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check text-emerald-500 mr-3"></i>
                            Attendance tracking
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check text-emerald-500 mr-3"></i>
                            Basic reports
                        </li>
                    </ul>
                    <button class="w-full bg-slate-200 text-slate-700 py-3 rounded-lg font-semibold hover:bg-slate-300 transition-colors">
                        Start Free Trial
                    </button>
                </div>

                <!-- Professional Plan -->
                <div class="bg-primary-600 text-white rounded-2xl shadow-lg p-8 relative" data-aos="fade-up" data-aos-delay="200">
                    <div class="absolute -top-4 left-1/2 transform -translate-x-1/2 bg-emerald-500 text-white px-4 py-2 rounded-full text-sm font-semibold">
                        Most Popular
                    </div>
                    <div class="text-center mb-8">
                        <h3 class="text-2xl font-bold mb-2">Professional</h3>
                        <p class="text-primary-100 mb-6">For growing academies</p>
                        <div class="text-4xl font-bold">$149<span class="text-lg text-primary-200">/month</span></div>
                    </div>
                    <ul class="space-y-4 mb-8">
                        <li class="flex items-center">
                            <i class="fas fa-check text-emerald-400 mr-3"></i>
                            Up to 200 students
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check text-emerald-400 mr-3"></i>
                            20 teachers
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check text-emerald-400 mr-3"></i>
                            Advanced analytics
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check text-emerald-400 mr-3"></i>
                            Parent portal
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check text-emerald-400 mr-3"></i>
                            Complaint management
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check text-emerald-400 mr-3"></i>
                            Priority support
                        </li>
                    </ul>
                    <button class="w-full bg-white text-primary-600 py-3 rounded-lg font-semibold hover:bg-gray-50 transition-colors">
                        Start Free Trial
                    </button>
                </div>

                <!-- Enterprise Plan -->
                <div class="bg-white rounded-2xl shadow-lg p-8" data-aos="fade-up" data-aos-delay="300">
                    <div class="text-center mb-8">
                        <h3 class="text-2xl font-bold text-slate-900 mb-2">Enterprise</h3>
                        <p class="text-slate-600 mb-6">For large institutions</p>
                        <div class="text-4xl font-bold text-slate-900">$399<span class="text-lg text-slate-600">/month</span></div>
                    </div>
                    <ul class="space-y-4 mb-8">
                        <li class="flex items-center">
                            <i class="fas fa-check text-emerald-500 mr-3"></i>
                            Unlimited students
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check text-emerald-500 mr-3"></i>
                            Unlimited teachers
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check text-emerald-500 mr-3"></i>
                            Custom branding
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check text-emerald-500 mr-3"></i>
                            API access
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check text-emerald-500 mr-3"></i>
                            Dedicated support
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check text-emerald-500 mr-3"></i>
                            Custom integrations
                        </li>
                    </ul>
                    <button class="w-full bg-slate-200 text-slate-700 py-3 rounded-lg font-semibold hover:bg-slate-300 transition-colors">
                        Contact Sales
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 bg-gradient-to-br from-primary-600 to-primary-700">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-white">
            <div data-aos="fade-up">
                <h2 class="text-4xl font-bold mb-6">Ready to Transform Your Quran Academy?</h2>
                <p class="text-xl mb-8 text-primary-100">
                    Join 500+ successful academies using QuranFlow to scale their operations and improve student outcomes.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="#signup" class="bg-white text-primary-600 px-8 py-4 rounded-xl hover:bg-gray-50 font-semibold text-lg shadow-lg transition-all">
                        Start Your Free Trial Today
                    </a>
                    <a href="#contact" class="border-2 border-white text-white px-8 py-4 rounded-xl hover:bg-white hover:text-primary-600 font-semibold text-lg transition-all">
                        Schedule a Demo
                    </a>
                </div>
                <p class="text-sm text-primary-200 mt-4">✅ No credit card required • ✅ 14-day free trial • ✅ Cancel anytime</p>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-slate-900 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-4 gap-8">
                <!-- Company Info -->
                <div class="md:col-span-2">
                    <div class="flex items-center space-x-3 mb-6">
                        <div class="w-12 h-12 bg-primary-600 rounded-xl flex items-center justify-center">
                            <i class="fas fa-book-quran text-white text-xl"></i>
                        </div>
                        <span class="text-2xl font-bold">QuranFlow</span>
                    </div>
                    <p class="text-slate-400 mb-6 max-w-md">
                        Empowering Quran academies worldwide with cutting-edge technology to deliver exceptional Islamic education and streamline operations.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="w-10 h-10 bg-slate-800 rounded-lg flex items-center justify-center text-slate-400 hover:text-white hover:bg-primary-600 transition-all">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-slate-800 rounded-lg flex items-center justify-center text-slate-400 hover:text-white hover:bg-primary-600 transition-all">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-slate-800 rounded-lg flex items-center justify-center text-slate-400 hover:text-white hover:bg-primary-600 transition-all">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div>
                    <h3 class="text-lg font-semibold mb-6">Product</h3>
                    <ul class="space-y-3">
                        <li><a href="#features" class="text-slate-400 hover:text-white transition-colors">Features</a></li>
                        <li><a href="#pricing" class="text-slate-400 hover:text-white transition-colors">Pricing</a></li>
                        <li><a href="#" class="text-slate-400 hover:text-white transition-colors">API Docs</a></li>
                        <li><a href="#" class="text-slate-400 hover:text-white transition-colors">Integrations</a></li>
                    </ul>
                </div>

                <!-- Support -->
                <div>
                    <h3 class="text-lg font-semibold mb-6">Support</h3>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-slate-400 hover:text-white transition-colors">Help Center</a></li>
                        <li><a href="#" class="text-slate-400 hover:text-white transition-colors">Contact Us</a></li>
                        <li><a href="#" class="text-slate-400 hover:text-white transition-colors">Live Chat</a></li>
                        <li><a href="#" class="text-slate-400 hover:text-white transition-colors">Status Page</a></li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-slate-800 mt-12 pt-8 flex flex-col md:flex-row justify-between items-center">
                <p class="text-slate-400">&copy; 2025 QuranFlow. All rights reserved.</p>
                <div class="flex space-x-6 mt-4 md:mt-0">
                    <a href="#" class="text-slate-400 hover:text-white transition-colors">Privacy Policy</a>
                    <a href="#" class="text-slate-400 hover:text-white transition-colors">Terms of Service</a>
                    <a href="#" class="text-slate-400 hover:text-white transition-colors">Cookie Policy</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script>
        // Initialize AOS
        AOS.init({
            once: true,
            offset: 100,
            duration: 800
        });

        // Mobile menu functionality
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        const mobileMenu = document.getElementById('mobileMenu');
        const hamburgerMenu = mobileMenuBtn.querySelector('.hamburger-menu');
        
        mobileMenuBtn.addEventListener('click', function() {
            mobileMenu.classList.toggle('show');
            hamburgerMenu.classList.toggle('active');
        });
        
        // Close mobile menu when clicking on a link
        document.querySelectorAll('.mobile-nav-link').forEach(link => {
            link.addEventListener('click', () => {
                mobileMenu.classList.remove('show');
                hamburgerMenu.classList.remove('active');
            });
        });
        
        // Close mobile menu when clicking outside
        document.addEventListener('click', function(event) {
            if (!mobileMenuBtn.contains(event.target) && !mobileMenu.contains(event.target)) {
                mobileMenu.classList.remove('show');
                hamburgerMenu.classList.remove('active');
            }
        });

        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start',
                        inline: 'nearest'
                    });
                }
            });
        });

        // Navbar scroll effects and active section highlighting
        const navbar = document.getElementById('navbar');
        const navLinks = document.querySelectorAll('.nav-link, .mobile-nav-link');
        const sections = document.querySelectorAll('section[id]');
        
        window.addEventListener('scroll', function() {
            // Add scrolled class for navbar styling
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
            
            // Highlight active section in navigation
            let current = '';
            sections.forEach(section => {
                const sectionTop = section.offsetTop;
                const sectionHeight = section.clientHeight;
                if (window.scrollY >= (sectionTop - 200)) {
                    current = section.getAttribute('id');
                }
            });
            
            navLinks.forEach(link => {
                link.classList.remove('active');
                if (link.getAttribute('href') === `#${current}`) {
                    link.classList.add('active');
                }
            });
        });
        
        // Add home section for navigation
        const heroSection = document.querySelector('section');
        if (heroSection) {
            heroSection.id = 'home';
        }
    </script>
</body>
</html>