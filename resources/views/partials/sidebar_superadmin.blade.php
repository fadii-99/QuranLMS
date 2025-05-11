{{-- resources/views/partials/sidebar_superadmin.blade.php --}}
<div id="sidebar"
    class="fixed inset-y-0 left-0 w-64 bg-white dark:bg-gray-800 shadow-lg p-4 z-20 transform transition-transform duration-300 md:translate-x-0 -translate-x-full flex flex-col">
    <div class="flex items-center justify-between mb-8">
        <a href="{{ route('superadmin.dashboard') }}">
            <h1 class="text-xl font-bold text-primary dark:text-white">quranLMS</h1>
        </a>
        <button id="sidebarToggle"
            class="p-2 rounded-full bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 md:hidden">
            <i class="fas fa-times text-gray-600 dark:text-gray-300"></i>
        </button>
    </div>
    @if (auth()->check() && auth()->user()->role === App\Models\User::ROLE_ADMIN)
        <nav class="flex-1">
            <a href="{{ route('admin.dashboard') }}"
                class="flex items-center p-3 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 mb-2 {{ request()->routeIs('admin.dashboard') ? 'bg-blue-50 dark:bg-gray-700 text-primary dark:text-white' : '' }}">
                <i class="fas fa-tachometer-alt mr-3"></i> Dashboard
            </a>
            <a href="{{ route('admin.teacher.index') }}"
                class="flex items-center p-3 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 mb-2 {{ request()->routeIs('admin.teacher.*') ? 'bg-blue-50 dark:bg-gray-700 text-primary dark:text-white' : '' }}">
                <i class="fas fa-chalkboard-teacher mr-3"></i> Teachers
            </a>
            <a href="{{ route('admin.student.index') }}"
                class="flex items-center p-3 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 mb-2 {{ request()->routeIs('admin.student.*') ? 'bg-blue-50 dark:bg-gray-700 text-primary dark:text-white' : '' }}">
                <i class="fas fa-user-graduate  mr-3"></i> Students
            </a>
        </nav>
    @elseif(auth()->check() && auth()->user()->role === App\Models\User::ROLE_SUPER_ADMIN)
        <nav class="flex-1">
            <a href="{{ route('superadmin.dashboard') }}"
                class="flex items-center p-3 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 mb-2 {{ request()->routeIs('superadmin.dashboard') ? 'bg-blue-50 dark:bg-gray-700 text-primary dark:text-white' : '' }}">
                <i class="fas fa-tachometer-alt mr-3"></i> Dashboard
            </a>
            <a href="{{ route('superadmin.admins.index') }}"
                class="flex items-center p-3 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 mb-2 {{ request()->routeIs('superadmin.admins.*') ? 'bg-blue-50 dark:bg-gray-700 text-primary dark:text-white' : '' }}">
                <i class="fas fa-users mr-3"></i> Admins
            </a>
            <a href="{{ route('superadmin.payment.index') }}"
                class="flex items-center p-3 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 mb-2 {{ request()->routeIs('superadmin.payment.*') ? 'bg-blue-50 dark:bg-gray-700 text-primary dark:text-white' : '' }}">
                <i class="fas fa-university mr-3"></i> Payments
            </a>
            <a href="{{ route('superadmin.recent_activity.index') }}"
                class="flex items-center p-3 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 mb-2 {{ request()->routeIs('superadmin.recent_activity.*') ? 'bg-blue-50 dark:bg-gray-700 text-primary dark:text-white' : '' }}">
                <i class="fas fa-clock mr-3"></i> Recent Activity
            </a>
            {{-- add other superadmin links here --}}
        </nav>
    @elseif(auth()->check() && auth()->user()->role === App\Models\User::ROLE_TEACHER)
        <nav class="flex-1">
            <a href="{{ route('teacher.dashboard') }}"
                class="flex items-center p-3 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 mb-2 {{ request()->routeIs('teacher.dashboard') ? 'bg-blue-50 dark:bg-gray-700 text-primary dark:text-white' : '' }}">
                <i class="fas fa-tachometer-alt mr-3"></i> Dashboard
            </a>
        </nav>
    @endif

    <div class="relative mt-auto">
        <button id="profileDropdown"
            class="w-full flex items-center p-3 rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600">
            <img src="{{ asset('imgs/user.png') }}" alt="Profile" class="rounded-full mr-3 w-8 h-8" />
            <span>{{ auth()->user()->name }}</span>
        </button>
        <div id="dropdownMenu"
            class="hidden absolute bottom-full left-0 w-full bg-white dark:bg-gray-700 rounded-lg shadow-lg py-1 mb-2">
            <button id="themeToggle"
                class="w-full text-left px-4 py-2 text-gray-800 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-600 flex items-center">
                <i class="fas fa-moon block dark:hidden text-xl text-gray-700"></i>
                <!-- Sun: hidden in light, visible in dark -->
                <i class="fas fa-sun hidden dark:block text-xl text-yellow-400"></i>
                Toggle Theme
            </button>
            <script>
                const themeToggle = document.getElementById('themeToggle');
                themeToggle.addEventListener('click', () => {
                    document.documentElement.classList.toggle('dark');
                    localStorage.setItem('theme', document.documentElement.classList.contains('dark') ? 'dark' : 'light');
                }); // Load theme from localStorage 
                if (localStorage.getItem('theme') === 'dark') {
                    document.documentElement.classList.add('dark');
                }
                // Mobile Menu Toggle 
            </script>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="w-full text-left px-4 py-2 text-red-500 hover:bg-gray-100 dark:hover:bg-gray-600">Logout</button>
            </form>
        </div>
    </div>
</div>
