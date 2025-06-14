<!DOCTYPE html>
<html lang="en" class="light">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>@yield('title') — quranLMS</title>

  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet"/>

    {{-- Toastify.js CDN --}}
    <link href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css" rel="stylesheet"/>
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
  <script>
    tailwind.config = {
      darkMode: 'class',
      theme: {
        extend: {
          colors: {
            primary: '#3B82F6',
            secondary: '#10B981',
            dark: '#1E293B',
          }
        }
      }
    }
  </script>
  
</head>
<body class="bg-gray-50 dark:bg-dark text-gray-800 dark:text-gray-200 transition-colors duration-300">
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
  @include('partials.sidebar')

  <div id="mainContent" class="p-6 md:ml-64 transition-all duration-300">
    <!-- Mobile hamburger -->
    <button
      id="sidebarOpen"
      class="md:hidden mb-4 p-2 rounded bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600"
      aria-label="Open sidebar"
    >
      <i class="fas fa-bars text-gray-700 dark:text-gray-200"></i>
    </button>
    @yield('content')
  </div>
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const sidebar       = document.getElementById('sidebar');
      const sidebarClose  = document.getElementById('sidebarToggle');
      const sidebarOpen   = document.getElementById('sidebarOpen');
      const profileBtn    = document.getElementById('profileDropdown');
      const dropdownMenu  = document.getElementById('dropdownMenu');
      const themeToggle   = document.getElementById('themeToggle');

      // open & close sidebar
      sidebarClose?.addEventListener('click', () => sidebar.classList.toggle('-translate-x-full'));
      sidebarOpen?.addEventListener('click',  () => sidebar.classList.toggle('-translate-x-full'));

      // profile dropdown
      profileBtn?.addEventListener('click', e => {
        e.stopPropagation();
        dropdownMenu.classList.toggle('hidden');
      });
      document.addEventListener('click', () => dropdownMenu?.classList.add('hidden'));

      // theme toggle
    });
  </script>
  @stack('scripts')
</body>
</html>
