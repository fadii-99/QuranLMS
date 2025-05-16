<!DOCTYPE html>
<html lang="en" class="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Al-Qalam Academy - Premium Online Quran Education</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <link href="https://unpkg.com/swiper@8/swiper-bundle.min.css" rel="stylesheet">
    <script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Amiri:wght@400;700&display=swap"
        rel="stylesheet">

    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                fontFamily: {
                    sans: ['Poppins', 'sans-serif'],
                    arabic: ['Amiri', 'serif'],
                },
                extend: {
                    colors: {
                        primary: {
                            DEFAULT: '#2563EB',
                            light: '#3B82F6',
                            dark: '#1D4ED8'
                        },
                        secondary: {
                            DEFAULT: '#059669',
                            light: '#10B981',
                            dark: '#047857'
                        },
                        dark: '#0F172A',
                        light: '#F8FAFC',
                        accent: '#D97706',
                    },
                    animation: {
                        'fade-in': 'fadeIn 1s ease-in-out',
                        'slide-up': 'slideUp 0.8s ease-in-out',
                        'scale-up': 'scaleUp 0.5s ease-in-out',
                        'bounce-in': 'bounceIn 1s ease-in-out',
                        'float': 'float 6s ease-in-out infinite',
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': { opacity: '0' },
                            '100%': { opacity: '1' },
                        },
                        slideUp: {
                            '0%': { transform: 'translateY(30px)', opacity: '0' },
                            '100%': { transform: 'translateY(0)', opacity: '1' },
                        },
                        scaleUp: {
                            '0%': { transform: 'scale(0.95)' },
                            '100%': { transform: 'scale(1)' },
                        },
                        bounceIn: {
                            '0%': { transform: 'scale(0.8)', opacity: '0' },
                            '50%': { transform: 'scale(1.05)', opacity: '1' },
                            '100%': { transform: 'scale(1)' },
                        },
                        float: {
                            '0%, 100%': { transform: 'translateY(0)' },
                            '50%': { transform: 'translateY(-20px)' },
                        },
                    },
                },
            },
        }
    </script>

    <style>
        .arabic-text {
            font-family: 'Amiri', serif;
            line-height: 2.5;
        }

        .gradient-text {
            background-clip: text;
            -webkit-background-clip: text;
            color: transparent;
            background-image: linear-gradient(90deg, #ca60eb, #4eeebb);
        }

        .hero-pattern {
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%239C92AC' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }

        .quran-verse {
            position: relative;
        }

        .quran-verse::before,
        .quran-verse::after {
            content: '"';
            font-size: 3rem;
            color: rgba(37, 99, 235, 0.2);
            position: absolute;
        }

        .quran-verse::before {
            top: -1rem;
            left: -1.5rem;
        }

        .quran-verse::after {
            bottom: -2rem;
            right: -1.5rem;
        }
        .dashboard-preview {
            background: linear-gradient(45deg, #1a365d 0%, #153e75 100%);
            border-radius: 2rem;
            transform: perspective(1000px) rotateX(10deg);
            box-shadow: 0 45px 100px -20px rgba(0, 0, 0, 0.3);
        }
    </style>
</head>

<body class="bg-light dark:bg-dark transition-colors duration-300 font-sans">
    <!-- Navbar -->
    @include('partials.nav')


       <!-- Hero Section -->
       <section class="pt-32 pb-32">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex flex-col lg:flex-row items-center">
                <div class="lg:w-1/2 mb-16 lg:mb-0">
                    <h1 class="text-5xl font-bold text-gray-900 mb-6 leading-tight">
                        Transform Your Quran Education Business with 
                        <span class="bg-clip-text text-transparent bg-gradient-to-r from-indigo-600 to-blue-500">
                            Smart Management
                        </span>
                    </h1>
                    <p class="text-xl text-gray-600 mb-8">
                        All-in-one platform for Quran schools and independent teachers to manage students, 
                        automate administration, and scale teaching operations.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#signup" class="bg-indigo-600 text-white px-8 py-4 rounded-lg hover:bg-indigo-700">
                            Start 14-Day Free Trial
                        </a>
                        <a href="#demo" class="border border-gray-300 px-8 py-4 rounded-lg hover:bg-gray-50">
                            Watch Demo Video
                        </a>
                    </div>
                    <div class="mt-8 flex items-center space-x-4 text-gray-600">
                        <div class="flex -space-x-2">
                            <div class="w-8 h-8 rounded-full bg-indigo-100"></div>
                            <div class="w-8 h-8 rounded-full bg-blue-100"></div>
                            <div class="w-8 h-8 rounded-full bg-purple-100"></div>
                        </div>
                        <span>Join 250+ Quran education businesses</span>
                    </div>
                </div>
                <div class="lg:w-1/2 relative">
                    <div class="dashboard-preview p-4">
                        <div class="bg-white rounded-xl p-4 shadow-xl">
                            <!-- Mock dashboard content -->
                            <div class="flex justify-between items-center mb-6">
                                <div class="text-sm font-medium">Student Overview</div>
                                <div class="text-indigo-600 text-sm">Last 30 days</div>
                            </div>
                            <div class="grid grid-cols-3 gap-4 mb-6">
                                <div class="p-4 bg-indigo-50 rounded-lg">
                                    <div class="text-2xl font-bold">142</div>
                                    <div class="text-sm text-gray-600">Active Students</div>
                                </div>
                                <div class="p-4 bg-blue-50 rounded-lg">
                                    <div class="text-2xl font-bold">92%</div>
                                    <div class="text-sm text-gray-600">Retention Rate</div>
                                </div>
                                <div class="p-4 bg-purple-50 rounded-lg">
                                    <div class="text-2xl font-bold">$8.2k</div>
                                    <div class="text-sm text-gray-600">Revenue</div>
                                </div>
                            </div>
                            <div class="h-48 bg-gray-100 rounded-lg animate-pulse"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Grid -->
    <section id="features" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">Everything You Need to Scale</h2>
                <p class="text-xl text-gray-600">Integrated tools for modern Quran education management</p>
            </div>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="feature-card p-6 border border-gray-200 rounded-xl hover:border-indigo-100 hover:bg-indigo-50/20 transition-all">
                    <div class="feature-icon w-12 h-12 bg-indigo-600 rounded-lg flex items-center justify-center text-white mb-4 transition-transform">
                        <i class="fas fa-users-class"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Student Management</h3>
                    <p class="text-gray-600">Track progress, manage schedules, and maintain records for all your students in one place.</p>
                </div>
                
                <!-- Add more feature cards -->
                <!-- Virtual Classroom -->
                <!-- Payment Processing -->
                <!-- Automated Reporting -->
                <!-- Course Builder -->
                <!-- API Access -->
            </div>
        </div>
    </section>

    <!-- Integrations Section -->
    <section id="integrations" class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">Seamless Integrations</h2>
                <p class="text-xl text-gray-600">Connect with tools you already use</p>
            </div>
            <div class="grid grid-cols-6 gap-8 place-items-center">
                <img src="zoom-logo.svg" alt="Zoom" class="h-12 opacity-75 hover:opacity-100 transition-opacity">
                <!-- Add other integration logos -->
            </div>
        </div>
    </section>

    <!-- Pricing Section -->
    <section id="pricing" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">Simple, Transparent Pricing</h2>
                <p class="text-xl text-gray-600">Scale with your business needs</p>
            </div>
            <div class="grid md:grid-cols-3 gap-8">
                <!-- Pricing Tiers -->
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 bg-indigo-600 text-white">
        <div class="max-w-4xl mx-auto px-4 text-center">
            <h2 class="text-4xl font-bold mb-6">Start Growing Your Quran School Today</h2>
            <p class="text-xl mb-8">Join hundreds of educators using QuranFlow to manage their teaching businesses</p>
            <div class="flex justify-center space-x-4">
                <a href="#signup" class="bg-white text-indigo-600 px-8 py-4 rounded-lg hover:bg-gray-100">
                    Get Started for Free
                </a>
                <a href="#demo" class="border border-white px-8 py-4 rounded-lg hover:bg-white/10">
                    Schedule a Demo
                </a>
            </div>
        </div>
    </section>
    
    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12">
        <div class="container mx-auto px-6 max-w-7xl">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12"> <!-- About -->
                <div>
                    <div class="flex items-center space-x-3 mb-6">
                        <div
                            class="w-12 h-12 rounded-lg bg-primary flex items-center justify-center text-white font-bold text-xl">
                            ق</div>
                        <h3 class="text-2xl font-bold">Al-Qalam Academy</h3>
                    </div>
                    <p class="text-gray-400">Premium online Quran education since 2015, offering personalized learning
                        with certified teachers worldwide.</p>
                </div> <!-- Quick Links -->
                <div>
                    <h3 class="text-xl font-bold mb-6">Quick Links</h3>
                    <ul class="space-y-3">
                        <li><a href="#home"
                                class="text-gray-400 hover:text-primary transition-colors duration-300">Home</a></li>
                        <li><a href="#programs"
                                class="text-gray-400 hover:text-primary transition-colors duration-300">Programs</a>
                        </li>
                        <li><a href="#methodology"
                                class="text-gray-400 hover:text-primary transition-colors duration-300">Methodology</a>
                        </li>
                        <li><a href="#teachers"
                                class="text-gray-400 hover:text-primary transition-colors duration-300">Teachers</a>
                        </li>
                        <li><a href="#contact"
                                class="text-gray-400 hover:text-primary transition-colors duration-300">Contact</a></li>
                    </ul>
                </div> <!-- Programs -->
                <div>
                    <h3 class="text-xl font-bold mb-6">Our Programs</h3>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-gray-400 hover:text-primary transition-colors duration-300">Quran
                                Recitation</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-primary transition-colors duration-300">Hifz
                                Program</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-primary transition-colors duration-300">Arabic
                                Language</a></li>
                        <li><a href="programs"
                                class="text-gray-400 hover:text-primary transition-colors duration-300">View All</a>
                        </li>
                    </ul>
                </div> <!-- Contact -->
                <div>
                    <h3 class="text-xl font-bold mb-6">Contact Us</h3>
                    <ul class="space-y-3">
                        <li class="flex items-center"> <i class="fas fa-envelope mr-3 text-primary"></i> <a
                                href="mailto:support@alqalamacademy.com"
                                class="text-gray-400 hover:text-primary transition-colors duration-300">support@alqalamacademy.com</a>
                        </li>
                        <li class="flex items-center"> <i class="fas fa-phone mr-3 text-primary"></i> <a
                                href="tel:+18001234567"
                                class="text-gray-400 hover:text-primary transition-colors duration-300">+1 (800)
                                123-4567</a> </li>
                        <li class="flex items-center"> <i class="fas fa-map-marker-alt mr-3 text-primary"></i> <span
                                class="text-gray-400">123 Quran Street, Knowledge City, QC</span> </li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 mt-12 pt-8 flex flex-col md:flex-row justify-between items-center">
                <p class="text-gray-400">&copy; 2025 Al-Qalam Academy. All rights reserved.</p>
                <div class="flex space-x-6 mt-4 md:mt-0"> <a href="#"
                        class="text-gray-400 hover:text-primary transition-colors duration-300"><i
                            class="fab fa-facebook-f"></i></a> <a href="#"
                        class="text-gray-400 hover:text-primary transition-colors duration-300"><i
                            class="fab fa-twitter"></i></a> <a href="#"
                        class="text-gray-400 hover:text-primary transition-colors duration-300"><i
                            class="fab fa-instagram"></i></a> <a href="#"
                        class="text-gray-400 hover:text-primary transition-colors duration-300"><i
                            class="fab fa-linkedin-in"></i></a> </div>
            </div>
        </div>
    </footer> <!-- Scripts -->
    
    <script> // Initialize AOS 
        AOS.init({ once: true, offset: 100, }); // Theme Toggle 
        const themeToggle = document.getElementById('themeToggle'); themeToggle.addEventListener('click', () => { document.documentElement.classList.toggle('dark'); localStorage.setItem('theme', document.documentElement.classList.contains('dark') ? 'dark' : 'light'); }); // Load theme from localStorage 
        if (localStorage.getItem('theme') === 'dark') { document.documentElement.classList.add('dark'); }
        // Mobile Menu Toggle 
        const mobileMenuToggle = document.getElementById('mobileMenuToggle'); const mobileMenu = document.getElementById('mobileMenu'); mobileMenuToggle.addEventListener('click', () => { mobileMenu.classList.toggle('hidden'); const icon = mobileMenuToggle.querySelector('i'); icon.classList.toggle('fa-bars'); icon.classList.toggle('fa-times'); }); // Swiper for Testimonials 
        const swiper = new Swiper('.testimonialSwiper', { slidesPerView: 1, spaceBetween: 20, pagination: { el: '.swiper-pagination', clickable: true, }, navigation: { nextEl: '.swiper-button-next', prevEl: '.swiper-button-prev', }, breakpoints: { 640: { slidesPerView: 2, }, 1024: { slidesPerView: 3, }, }, }); // Smooth Scroll for Anchor Links 
        document.querySelectorAll('a[href^="#"]').forEach(anchor => { anchor.addEventListener('click', function (e) { e.preventDefault(); document.querySelector(this.getAttribute('href')).scrollIntoView({ behavior: 'smooth', }); }); }); // Contact Form Submission 
        const contactForm = document.getElementById('contactForm'); contactForm.addEventListener('submit', async (e) => {
            e.preventDefault(); const formData = new FormData(contactForm); try { // Replace with your form submission endpoint 
                const response = await fetch('/api/contact', { method: 'POST', body: formData, }); if (response.ok) { alert('Message sent successfully!'); contactForm.reset(); } else { alert('Failed to send message. Please try again.'); }
            } catch (error) { alert('An error occurred. Please try again later.'); }
        }); </script>
</body>

</html>