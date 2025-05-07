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
    </style>
</head>

<body class="bg-light dark:bg-dark transition-colors duration-300 font-sans">
    <!-- Navbar -->
    @include('partials.nav')


    <!-- Hero Section -->
    <section id="home"
        class="min-h-screen flex items-center bg-gradient-to-br from-primary to-secondary text-white pt-20 hero-pattern">
        <div class="container mx-auto px-6 py-12 max-w-7xl flex flex-col lg:flex-row items-center">
            <div class="lg:w-1/2 mb-12 lg:mb-0" data-aos="fade-right" data-aos-duration="1000">
                <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 mb-8 inline-block">
                    <p class="text-sm font-semibold uppercase tracking-wider">Since 2015</p>
                </div>
                <h1 class="text-4xl md:text-6xl font-bold mb-6 leading-tight">Master the Quran with <span
                        class="gradient-text">Expert Guidance</span></h1>
                <p class="text-xl md:text-2xl mb-8 text-white/90">Personalized online Quran education with certified
                    teachers. Learn Tajweed, Hifz, and Arabic from anywhere in the world.</p>
                <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-6">
                    <a href="signup.html"
                        class="bg-white text-primary px-8 py-4 rounded-xl hover:bg-gray-100 inline-flex items-center justify-center text-lg font-medium transition-all duration-300 hover:shadow-lg">
                        <i class="fas fa-user-graduate mr-3"></i> Start Learning
                    </a>
                    <a href="#programs"
                        class="bg-transparent border-2 border-white text-white px-8 py-4 rounded-xl hover:bg-white/10 inline-flex items-center justify-center text-lg font-medium transition-all duration-300 hover:shadow-lg">
                        <i class="fas fa-book-open mr-3"></i> Explore Programs
                    </a>
                </div>
                <!--
                <div class="mt-12 flex items-center space-x-6">
                    <div class="flex -space-x-3">
                        <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="Student"
                            class="w-12 h-12 rounded-full border-2 border-white">
                        <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Student"
                            class="w-12 h-12 rounded-full border-2 border-white">
                        <img src="https://randomuser.me/api/portraits/women/68.jpg" alt="Student"
                            class="w-12 h-12 rounded-full border-2 border-white">
                    </div>
                     <div>
                        <p class="font-medium">Join <span class="font-bold">1,200+</span> satisfied students</p>
                        <div class="flex items-center mt-1">
                            <i class="fas fa-star text-yellow-300 mr-1"></i>
                            <i class="fas fa-star text-yellow-300 mr-1"></i>
                            <i class="fas fa-star text-yellow-300 mr-1"></i>
                            <i class="fas fa-star text-yellow-300 mr-1"></i>
                            <i class="fas fa-star text-yellow-300 mr-1"></i>
                            <span class="ml-2">4.9/5 (230 reviews)</span>
                        </div>
                    </div>
                </div> -->
            </div>
            <div class="lg:w-1/2 relative" data-aos="fade-left" data-aos-duration="1000">
                <div class="relative">
                    <img src="https://images.unsplash.com/photo-1564121211835-e88c852648ab?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80"
                        alt="Quran Learning" class="rounded-2xl shadow-2xl w-full h-auto">
                    <div class="absolute -bottom-6 -right-6 bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-xl w-3/4">
                        <div class="flex items-center mb-3">
                            <div class="bg-primary/10 p-3 rounded-lg mr-4">
                                <i class="fas fa-calendar-check text-primary text-xl"></i>
                            </div>
                            <h3 class="font-bold text-gray-800 dark:text-white">Flexible Schedule</h3>
                        </div>
                        <p class="text-gray-600 dark:text-gray-300">Choose class times that fit your routine. Available
                            24/7.</p>
                    </div>
                </div>
                <div
                    class="absolute -top-12 -left-12 bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-xl w-2/3 hidden md:block">
                    <div class="flex items-center mb-3">
                        <div class="bg-secondary/10 p-3 rounded-lg mr-4">
                            <i class="fas fa-user-tie text-secondary text-xl"></i>
                        </div>
                        <h3 class="font-bold text-gray-800 dark:text-white">Certified Teachers</h3>
                    </div>
                    <p class="text-gray-600 dark:text-gray-300">Learn from Alimiyyah graduates with 10+ years
                        experience.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Quran Verse -->
    <section class="py-16 bg-white dark:bg-gray-900">
        <div class="container mx-auto px-6 max-w-5xl text-center">
            <div class="bg-gray-50 dark:bg-gray-800 p-8 md:p-12 rounded-3xl shadow-sm">
                <p class="arabic-text text-2xl md:text-4xl  text-gray-800 dark:text-white mb-6 quran-verse">
                    وَقُرْآنًا فَرَقْنَاهُ لِتَقْرَأَهُ عَلَى النَّاسِ عَلَىٰ مُكْثٍ وَنَزَّلْنَاهُ تَنْزِيلًا
                </p>
                <p class="text-lg text-gray-600 dark:text-gray-300 italic">"And We have spaced out the Quran (gradually
                    revealed it) so that you may recite it to the people in intervals, and We have sent it down in
                    successive revelations."</p>
                <p class="text-lg text-gray-500 dark:text-gray-400 mt-4">- Surah Al-Isra (17:106)</p>
            </div>
        </div>
    </section>

    <!-- Programs Section -->
    <section id="programs" class="py-20 bg-gray-50 dark:bg-gray-900">
        <div class="container mx-auto px-6 max-w-7xl">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-bold text-gray-800 dark:text-white mb-6" data-aos="fade-up">Our
                    Comprehensive Programs</h2>
                <p class="text-xl text-gray-600 dark:text-gray-300 max-w-3xl mx-auto" data-aos="fade-up"
                    data-aos-delay="100">Structured learning paths tailored to all ages and levels, from beginners to
                    advanced students.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Program 1 -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden transition-all duration-300 hover:shadow-xl hover:-translate-y-2"
                    data-aos="fade-up" data-aos-delay="200">
                    <div class="h-48 bg-gradient-to-r from-blue-500 to-blue-600 flex items-center justify-center">
                        <i class="fas fa-book-quran text-white text-6xl"></i>
                    </div>
                    <div class="p-8">
                        <h3 class="text-2xl font-bold text-gray-800 dark:text-white mb-4">Quran Recitation</h3>
                        <p class="text-gray-600 dark:text-gray-300 mb-6">Master proper pronunciation and fluency in
                            Quran reading with Tajweed rules.</p>
                        <ul class="space-y-3 mb-8">
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-primary mt-1 mr-3"></i>
                                <span class="text-gray-700 dark:text-gray-300">Correct pronunciation (Makharij)</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-primary mt-1 mr-3"></i>
                                <span class="text-gray-700 dark:text-gray-300">Tajweed rules application</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-primary mt-1 mr-3"></i>
                                <span class="text-gray-700 dark:text-gray-300">Fluency development</span>
                            </li>
                        </ul>
                        <a href="#"
                            class="text-primary dark:text-primary-light font-medium hover:text-primary-dark dark:hover:text-primary transition-colors duration-300 inline-flex items-center">
                            Learn more <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    </div>
                </div>

                <!-- Program 2 -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden transition-all duration-300 hover:shadow-xl hover:-translate-y-2"
                    data-aos="fade-up" data-aos-delay="300">
                    <div class="h-48 bg-gradient-to-r from-green-500 to-green-600 flex items-center justify-center">
                        <i class="fas fa-brain text-white text-6xl"></i>
                    </div>
                    <div class="p-8">
                        <h3 class="text-2xl font-bold text-gray-800 dark:text-white mb-4">Hifz Program</h3>
                        <p class="text-gray-600 dark:text-gray-300 mb-6">Systematic Quran memorization with proven
                            techniques and revision plans.</p>
                        <ul class="space-y-3 mb-8">
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-secondary mt-1 mr-3"></i>
                                <span class="text-gray-700 dark:text-gray-300">Personalized memorization plan</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-secondary mt-1 mr-3"></i>
                                <span class="text-gray-700 dark:text-gray-300">Effective memorization techniques</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-secondary mt-1 mr-3"></i>
                                <span class="text-gray-700 dark:text-gray-300">Revision tracking system</span>
                            </li>
                        </ul>
                        <a href="#"
                            class="text-secondary dark:text-secondary-light font-medium hover:text-secondary-dark dark:hover:text-secondary transition-colors duration-300 inline-flex items-center">
                            Learn more <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    </div>
                </div>

                <!-- Program 3 -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden transition-all duration-300 hover:shadow-xl hover:-translate-y-2"
                    data-aos="fade-up" data-aos-delay="400">
                    <div class="h-48 bg-gradient-to-r from-purple-500 to-purple-600 flex items-center justify-center">
                        <i class="fas fa-language text-white text-6xl"></i>
                    </div>
                    <div class="p-8">
                        <h3 class="text-2xl font-bold text-gray-800 dark:text-white mb-4">Arabic Language</h3>
                        <p class="text-gray-600 dark:text-gray-300 mb-6">Understand the Quran in its original language
                            through comprehensive Arabic courses.</p>
                        <ul class="space-y-3 mb-8">
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-purple-500 mt-1 mr-3"></i>
                                <span class="text-gray-700 dark:text-gray-300">Classical Arabic grammar</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-purple-500 mt-1 mr-3"></i>
                                <span class="text-gray-700 dark:text-gray-300">Quranic vocabulary building</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-purple-500 mt-1 mr-3"></i>
                                <span class="text-gray-700 dark:text-gray-300">Sentence structure analysis</span>
                            </li>
                        </ul>
                        <a href="#"
                            class="text-purple-500 dark:text-purple-400 font-medium hover:text-purple-700 dark:hover:text-purple-300 transition-colors duration-300 inline-flex items-center">
                            Learn more <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="text-center mt-16" data-aos="fade-up">
                <a href="programs"
                    class="inline-flex items-center justify-center px-8 py-4 bg-primary text-white rounded-xl hover:bg-primary-dark transition-all duration-300 hover:shadow-lg text-lg font-medium">
                    <i class="fas fa-list mr-3"></i> View All Programs
                </a>
            </div>
        </div>
    </section>

    <!-- Methodology Section -->
    <section id="methodology" class="py-20 bg-white dark:bg-gray-900">
        <div class="container mx-auto px-6 max-w-7xl">
            <div class="flex flex-col lg:flex-row items-center gap-12">
                <div class="lg:w-1/2" data-aos="fade-right">
                    <h2 class="text-4xl md:text-5xl font-bold text-gray-800 dark:text-white mb-8">Our Proven <span
                            class="gradient-text">Teaching Methodology</span></h2>
                    <p class="text-xl text-gray-600 dark:text-gray-300 mb-8 leading-relaxed">At Al-Qalam Academy, we
                        combine traditional Islamic teaching methods with modern educational technology to create an
                        effective and engaging learning experience.</p>

                    <div class="space-y-6">
                        <div class="flex items-start">
                            <div class="bg-primary/10 p-4 rounded-xl mr-6">
                                <i class="fas fa-user-check text-primary text-xl"></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-2">One-on-One Attention
                                </h3>
                                <p class="text-gray-600 dark:text-gray-300">Personalized lessons tailored to your
                                    learning style and pace.</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="bg-secondary/10 p-4 rounded-xl mr-6">
                                <i class="fas fa-chart-line text-secondary text-xl"></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-2">Progress Tracking</h3>
                                <p class="text-gray-600 dark:text-gray-300">Regular assessments and detailed progress
                                    reports.</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="bg-accent/10 p-4 rounded-xl mr-6">
                                <i class="fas fa-laptop text-accent text-xl"></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-2">Interactive Learning
                                </h3>
                                <p class="text-gray-600 dark:text-gray-300">Engaging digital tools and resources for
                                    effective learning.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="lg:w-1/2 relative" data-aos="fade-left">
                    <div class="relative">
                        <img src="https://images.unsplash.com/photo-1588072432836-e10032774350?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1472&q=80"
                            alt="Teaching Methodology" class="rounded-2xl shadow-xl w-full h-auto">
                    </div>
                    <div
                        class="absolute -bottom-8 -left-8 bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-xl w-3/4 hidden md:block">
                        <div class="flex items-center">
                            <div class="bg-primary/10 p-3 rounded-lg mr-4">
                                <i class="fas fa-star text-primary text-xl"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-800 dark:text-white">95% Success Rate</h3>
                                <p class="text-gray-600 dark:text-gray-300 text-sm">Students achieve their learning
                                    goals</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    

    <!-- Stats Section -->
    <section class="py-16 bg-gradient-to-r from-primary to-secondary text-white">
        <div class="container mx-auto px-6 max-w-7xl">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                <div class="p-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="text-4xl md:text-5xl font-bold mb-3">1,200+</div>
                    <div class="text-lg md:text-xl">Active Students</div>
                </div>
                <div class="p-6" data-aos="fade-up" data-aos-delay="200">

                    <div class="text-4xl md:text-5xl font-bold mb-3">50+</div>
                    <div class="text-lg md:text-xl">Certified Teachers</div>
                </div>
                <div class="p-6" data-aos="fade-up" data-aos-delay="300">
                    <div class="text-4xl md:text-5xl font-bold mb-3">10+</div>
                    <div class="text-lg md:text-xl">Years of Experience</div>
                </div>
                <div class="p-6" data-aos="fade-up" data-aos-delay="400">
                    <div class="text-4xl md:text-5xl font-bold mb-3">95%</div>
                    <div class="text-lg md:text-xl">Student Satisfaction</div>
                </div>
            </div>
        </div>
    </section> 
    
    <!-- Testimonials Section -->
    <!-- <section id="testimonials" class="py-20 bg-white dark:bg-gray-900">
        <div class="container mx-auto px-6 max-w-7xl">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-bold text-gray-800 dark:text-white mb-6" data-aos="fade-up">What
                    Our Students Say</h2>
                <p class="text-xl text-gray-600 dark:text-gray-300 max-w-3xl mx-auto" data-aos="fade-up"
                    data-aos-delay="100">Hear from students worldwide who have transformed their Quranic learning
                    journey with Al-Qalam Academy.</p>
            </div>
            <div class="swiper testimonialSwiper">
                <div class="swiper-wrapper py-4"> 



                    <div class="swiper-slide">
                        <div class="bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-lg mx-4 transition-all duration-300 hover:shadow-xl"
                            data-aos="fade-up" data-aos-delay="200">
                            <div class="flex items-center mb-6"> <img
                                    src="https://randomuser.me/api/portraits/women/50.jpg" alt="Student"
                                    class="w-16 h-16 rounded-full mr-4 border-2 border-primary">
                                <div>
                                    <h3 class="text-xl font-bold text-gray-800 dark:text-white">Sarah M.</h3>
                                    <p class="text-gray-600 dark:text-gray-300">Canada</p>
                                </div>
                            </div>
                            <p class="text-gray-600 dark:text-gray-300 mb-4">"Al-Qalam Academy has been a blessing. The
                                one-on-one classes helped me perfect my Tajweed, and the teachers are incredibly patient
                                and knowledgeable."</p>
                            <div class="flex items-center"> <i class="fas fa-star text-yellow-300 mr-1"></i> <i
                                    class="fas fa-star text-yellow-300 mr-1"></i> <i
                                    class="fas fa-star text-yellow-300 mr-1"></i> <i
                                    class="fas fa-star text-yellow-300 mr-1"></i> <i
                                    class="fas fa-star text-yellow-300"></i> </div>
                        </div>
                    </div> 



                    <div class="swiper-slide">
                        <div class="bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-lg mx-4 transition-all duration-300 hover:shadow-xl"
                            data-aos="fade-up" data-aos-delay="300">
                            <div class="flex items-center mb-6"> <img
                                    src="https://randomuser.me/api/portraits/men/60.jpg" alt="Student"
                                    class="w-16 h-16 rounded-full mr-4 border-2 border-primary">
                                <div>
                                    <h3 class="text-xl font-bold text-gray-800 dark:text-white">Ahmed R.</h3>
                                    <p class="text-gray-600 dark:text-gray-300">UK</p>
                                </div>
                            </div>
                            <p class="text-gray-600 dark:text-gray-300 mb-4">"The Hifz program is exceptional. My
                                teacher created a personalized plan that made memorizing the Quran so much easier.
                                Highly recommended!"</p>
                            <div class="flex items-center"> <i class="fas fa-star text-yellow-300 mr-1"></i> <i
                                    class="fas fa-star text-yellow-300 mr-1"></i> <i
                                    class="fas fa-star text-yellow-300 mr-1"></i> <i
                                    class="fas fa-star text-yellow-300 mr-1"></i> <i
                                    class="fas fa-star text-yellow-300"></i> </div>
                        </div>
                    </div> 



                    <div class="swiper-slide">
                        <div class="bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-lg mx-4 transition-all duration-300 hover:shadow-xl"
                            data-aos="fade-up" data-aos-delay="400">
                            <div class="flex items-center mb-6"> <img
                                    src="https://randomuser.me/api/portraits/women/70.jpg" alt="Student"
                                    class="w-16 h-16 rounded-full mr-4 border-2 border-primary">
                                <div>
                                    <h3 class="text-xl font-bold text-gray-800 dark:text-white">Fatima Z.</h3>
                                    <p class="text-gray-600 dark:text-gray-300">USA</p>
                                </div>
                            </div>
                            <p class="text-gray-600 dark:text-gray-300 mb-4">"Learning Arabic with Al-Qalam has deepened
                                my understanding of the Quran. The interactive lessons are engaging and effective."</p>
                            <div class="flex items-center"> <i class="fas fa-star text-yellow-300 mr-1"></i> <i
                                    class="fas fa-star text-yellow-300 mr-1"></i> <i
                                    class="fas fa-star text-yellow-300 mr-1"></i> <i
                                    class="fas fa-star text-yellow-300 mr-1"></i> <i
                                    class="fas fa-star-half-alt text-yellow-300"></i> </div>
                        </div>
                    </div>
                </div>
                <div class="swiper-pagination"></div>
                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>
            </div>
        </div>
    </section>  -->
    
    <!-- Contact Section -->
    <section id="contact" class="py-20 bg-gray-50 dark:bg-gray-900">
        <div class="container mx-auto px-6 max-w-7xl">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-bold text-gray-800 dark:text-white mb-6" data-aos="fade-up">Get in
                    Touch</h2>
                <p class="text-xl text-gray-600 dark:text-gray-300 max-w-3xl mx-auto" data-aos="fade-up"
                    data-aos-delay="100">Have questions or ready to start your Quranic journey? Contact us today!</p>
            </div>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12"> <!-- Contact Form -->
                <div class="bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-lg" data-aos="fade-right">
                    <form id="contactForm">
                        <div class="mb-6"> <label for="name"
                                class="block text-gray-700 dark:text-gray-300 font-medium mb-2">Full Name</label> <input
                                type="text" id="name" name="name"
                                class="w-full p-4 rounded-lg border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-primary"
                                required> </div>
                        <div class="mb-6"> <label for="email"
                                class="block text-gray-700 dark:text-gray-300 font-medium mb-2">Email Address</label>
                            <input type="email" id="email" name="email"
                                class="w-full p-4 rounded-lg border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-primary"
                                required>
                        </div>
                        <div class="mb-6"> <label for="message"
                                class="block text-gray-700 dark:text-gray-300 font-medium mb-2">Your Message</label>
                            <textarea id="message" name="message" rows="5"
                                class="w-full p-4 rounded-lg border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-primary"
                                required></textarea>
                        </div> <button type="submit"
                            class="w-full bg-primary text-white px-6 py-4 rounded-lg hover:bg-primary-dark transition-all duration-300 hover:shadow-lg text-lg font-medium">Send
                            Message</button>
                    </form>
                </div> <!-- Contact Info -->
                <div class="space-y-8" data-aos="fade-left">
                    <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-lg">
                        <div class="flex items-center mb-4">
                            <div class="bg-primary/10 p-4 rounded-xl mr-4"> <i
                                    class="fas fa-envelope text-primary text-xl"></i> </div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-800 dark:text-white">Email Us</h3>
                                <p class="text-gray-600 dark:text-gray-300">support@alqalamacademy.com</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-lg">
                        <div class="flex items-center mb-4">
                            <div class="bg-primary/10 p-4 rounded-xl mr-4"> <i
                                    class="fas fa-phone text-primary text-xl"></i> </div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-800 dark:text-white">Call Us</h3>
                                <p class="text-gray-600 dark:text-gray-300">+1 (800) 123-4567</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-lg">
                        <div class="flex items-center mb-4">
                            <div class="bg-primary/10 p-4 rounded-xl mr-4"> <i
                                    class="fas fa-map-marker-alt text-primary text-xl"></i> </div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-800 dark:text-white">Visit Us</h3>
                                <p class="text-gray-600 dark:text-gray-300">123 Quran Street, Knowledge City, QC</p>
                            </div>
                        </div>
                    </div>
                </div>
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