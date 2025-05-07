<!DOCTYPE html>
<html lang="en" class="light">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <title>Sign Up - quranLMS</title>

  {{-- Tailwind + FontAwesome + AOS --}}
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet"/>
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet"/>
  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

  {{-- Toastify.js CDN --}}
  <link href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css" rel="stylesheet"/>
  <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

  <script>
    tailwind.config = {
      darkMode: 'class',
      theme: {
        fontFamily: { sans:['Poppins','sans-serif'], arabic:['Amiri','serif'] },
        extend: {
          colors: {
            primary:{DEFAULT:'#2563EB'}, secondary:{DEFAULT:'#059669'},
            dark:'#0F172A', light:'#F8FAFC', accent:'#D97706'
          },
          animation:{ 'gradient-x':'gradientX 15s ease infinite' },
          keyframes:{ gradientX:{ '0%,100%':{'background-position':'0% 50%'}, '50%':{'background-position':'100% 50%'} } }
        }
      }
    }
  </script>
  <style>
    .hero-pattern {
      background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' ...%3E");
    }
    .backdrop-blur-lg { backdrop-filter: blur(12px); }
    .gradient-text {
      background-clip: text; -webkit-background-clip: text; color:transparent;
      background-image: linear-gradient(90deg,#2563EB,#059669);
    }
    .toastify {
  font-family: 'Poppins', sans-serif !important;
  backdrop-filter: blur(8px);
  background: linear-gradient(90deg, rgba(239, 68, 68, 0.9), rgba(220, 38, 38, 0.9)) !important; /* Error gradient */
  border-radius: 0.75rem !important;
  box-shadow: 0 4px 12px rgba(0,0,0,0.2) !important;
  top: 100px !important;
  right: 50px !important;
  padding: 0.75rem 3rem 0.75rem 1rem !important; /* Adjusted padding for close button */
  position: fixed !important;
  color: #F8FAFC !important; /* Text color for readability */
}
.toastify-progress-bar {
  background: #F8FAFC !important;
  height: 3px !important;
  position: absolute !important;
  bottom: 0 !important;
  left: 0 !important;
  right: 0 !important;
  opacity: 1 !important; /* Ensure visibility */
}
.toastify-close {
  color: #F8FAFC !important;
  opacity: 0.8 !important;
  font-size: 1rem !important;
  cursor: pointer !important;
  transition: opacity 0.2s ease !important;
  position: absolute !important;
  top: 0.75rem !important; /* Align with top padding */
  right: 0.2rem !important; /* Position in right corner */
}
.toastify-close:hover {
  opacity: 1 !important;
}
  </style>
</head>
<body class="bg-light dark:bg-dark font-sans transition-colors duration-300">

  @include('partials.nav')

  {{-- Signup Section --}}
  <section class="min-h-screen flex items-center justify-center bg-gradient-to-br from-primary to-secondary text-white pt-16 hero-pattern overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-br from-primary/20 to-secondary/20 animate-gradient-x"></div>
    <div class="relative z-10 max-w-md w-full p-8 bg-white/2 border border-white/20 dark:bg-gray-800/10 dark:border-gray-700/20 rounded-3xl shadow-2xl" data-aos="fade-up" data-aos-duration="1000">
      <h2 class="text-3xl font-bold text-center mb-2">Join quranLMS</h2>
      <p class="text-center text-gray-200 dark:text-gray-300 mb-6 text-sm">Start your Quranic journey!</p>

      <form method="POST" action="{{ route('signup') }}" class="space-y-4" aria-label="Signup form">
        @csrf

        <div class="relative">
          <label for="name" class="block text-gray-200 dark:text-gray-300 text-sm mb-1">Full Name</label>
          <i class="fas fa-user absolute left-4 top-2/3 -translate-y-1/2 text-gray-400"></i>
          <input id="name" name="name" type="text" required
            class="w-full pl-12 pr-4 py-2 rounded-lg bg-white dark:bg-gray-700/50 text-gray-800 dark:text-gray-200 border border-gray-300/50 dark:border-gray-600/50 focus:ring-2 focus:ring-primary/50 transition"
            placeholder="Enter your full name" value="{{ old('name') }}">
        </div>

        <div class="relative">
          <label for="email" class="block text-gray-200 dark:text-gray-300 text-sm mb-1">Email Address</label>
          <i class="fas fa-envelope absolute left-4 top-2/3 -translate-y-1/2 text-gray-400"></i>
          <input id="email" name="email" type="email" required
            class="w-full pl-12 pr-4 py-2 rounded-lg bg-white dark:bg-gray-700/50 text-gray-800 dark:text-gray-200 border border-gray-300/50 dark:border-gray-600/50 focus:ring-2 focus:ring-primary/50 transition"
            placeholder="Enter your email" value="{{ old('email') }}">
        </div>

        <div class="relative">
          <label for="password" class="block text-gray-200 dark:text-gray-300 text-sm mb-1">Password</label>
          <i class="fas fa-lock absolute left-4 top-2/3 -translate-y-1/2 text-gray-400"></i>
          <input id="password" name="password" type="password" minlength="8" required
            class="w-full pl-12 pr-12 py-2 rounded-lg bg-white dark:bg-gray-700/50 text-gray-800 dark:text-gray-200 border border-gray-300/50 dark:border-gray-600/50 focus:ring-2 focus:ring-primary/50 transition"
            placeholder="Create a password">
          <i class="fas fa-eye absolute right-4 top-2/3 -translate-y-1/2 text-gray-400 cursor-pointer hover:text-gray-300 transition-colors" 
             id="toggle-password" 
             aria-label="Toggle password visibility"></i>
        </div>
        
        <div class="relative">
          <label for="password_confirmation" class="block text-gray-200 dark:text-gray-300 text-sm mb-1">Confirm Password</label>
          <i class="fas fa-lock absolute left-4 top-2/3 -translate-y-1/2 text-gray-400"></i>
          <input id="password_confirmation" name="password_confirmation" type="password" required
            class="w-full pl-12 pr-12 py-2 rounded-lg bg-white dark:bg-gray-700/50 text-gray-800 dark:text-gray-200 border border-gray-300/50 dark:border-gray-600/50 focus:ring-2 focus:ring-primary/50 transition"
            placeholder="Confirm your password">
          <i class="fas fa-eye absolute right-4 top-2/3 -translate-y-1/2 text-gray-400 cursor-pointer hover:text-gray-300 transition-colors" 
             id="toggle-password-confirmation" 
             aria-label="Toggle password confirmation visibility"></i>
        </div>
        
        <script>
          document.addEventListener('DOMContentLoaded', () => {
            // Function to initialize toggle for a given input and icon
            const setupPasswordToggle = (inputId, toggleId) => {
              const input = document.getElementById(inputId);
              const toggle = document.getElementById(toggleId);
        
              if (!input || !toggle) {
                console.error(`Element not found: inputId=${inputId}, toggleId=${toggleId}`);
                return;
              }
        
              toggle.addEventListener('click', () => {
                const isPassword = input.type === 'password';
                input.type = isPassword ? 'text' : 'password';
                // Explicitly remove and add classes to avoid toggle issues
                toggle.classList.remove(isPassword ? 'fa-eye' : 'fa-eye-slash');
                toggle.classList.add(isPassword ? 'fa-eye-slash' : 'fa-eye');
                console.log(`Toggled ${inputId}: type=${input.type}, icon=${toggle.className}`);
              });
            };
        
            // Initialize toggles for both fields
            setupPasswordToggle('password', 'toggle-password');
            setupPasswordToggle('password_confirmation', 'toggle-password-confirmation');
          });
        </script>
        

        <div class="flex items-center text-gray-200 dark:text-gray-300 text-xs">
          <input id="terms" name="terms" type="checkbox" required class="mr-2 rounded text-primary focus:ring-primary">
          <label for="terms">I agree to the<br>
            <a href="#" class="text-primary hover slugg">Terms & Conditions</a>
          </label>
        </div>

        <button type="submit"
          class="w-full flex items-center justify-center space-x-2 bg-primary text-white py-3 rounded-lg hover:scale-105 transition">
          <span>Sign Up</span><i class="fas fa-arrow-right"></i>
        </button>
      </form>

      <p class="text-center text-gray-200 dark:text-gray-300 text-sm mt-4">
        Already have an account?
        <a href="{{ route('login') }}" class="text-primary hover:underline">Login</a>
      </p>
    </div>
  </section>

  @include('partials.footer')

  <script>
    AOS.init({ once: true, offset: 100 });

  </script>
        @if ($errors->any())
        <script>
          document.addEventListener('DOMContentLoaded', () => {
            const errors = @json($errors->all());
            errors.forEach(error => {
              Toastify({
                text: `${error}`,
                duration: 3000,
                gravity: "top",
                position: "right",
                backgroundColor: "transparent", /* Use CSS for background */
                className: "rounded-lg shadow-lg",
                stopOnFocus: true,
                closeOnClick: false, /* Allow close button to handle dismissal */
                close: true, /* Enable close button */
                progressBar: true /* Enable progress bar */
              }).showToast();
            });
          });
        </script>
      @endif
</body>
</html>