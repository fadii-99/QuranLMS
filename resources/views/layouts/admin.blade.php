<!DOCTYPE html>
<html lang="en" class="light">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>@yield('title') — quranLMS</title>

  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet"/>

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
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- <script>
      // 1) Generic showToast helper
      

      // 2) Flash from session (Laravel redirect()->with(...))
       @if(session('success'))
        showToast('success', @json(session('success')));
      @elseif(session('error'))
        showToast('error', @json(session('error')));
      @endif

      // 3) Optional: catch any unhandled JS errors and toast them
      window.addEventListener('error', e => {
        // skip if it’s originating in SweetAlert itself
        if (!e.filename.includes('sweetalert2')) {
          showToast('error', e.message);
        }
      });
    </script> --}}

</head>
<body class="bg-gray-50 dark:bg-dark text-gray-800 dark:text-gray-200 transition-colors duration-300">
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
<script>
  function showToast(type, message) {
        Swal.fire({
          icon: type,               // "success", "error", "warning", "info", "question"
          title: message,
          toast: true,
          position: 'top-right',
          timer: 2000,
          timerProgressBar: true,
          showConfirmButton: false,
          customClass: { popup: 'swal-popup-custom' }
        });
      }
  @if(session('success'))
    showToast('success', @json(session('success')));
  @elseif(session('error'))
    showToast('error', @json(session('error')));
  @endif
</script>
</body>
</html>

