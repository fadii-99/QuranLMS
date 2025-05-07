{{-- resources/views/partials/nav.blade.php --}}
<nav class="fixed top-0 left-0 w-full z-50 bg-white shadow px-6 py-4 flex justify-between items-center">
    {{-- Logo + Site Title --}}
    <div class="flex items-center space-x-3">
        <div class="w-12 h-12 rounded-lg bg-primary flex items-center justify-center text-white font-bold text-xl">
            ق
        </div>
        <h1 class="text-2xl font-bold text-primary dark:text-white">
            <a href="{{ url('/') }}">Al-Qalam Academy</a>
        </h1>
    </div>

    {{-- Links --}}
    @auth
        <ul class="flex space-x-4 items-center">
            @if (auth()->user()->role === App\Models\User::ROLE_SUPER_ADMIN)
                <li>
                    <a href="{{ route('superadmin.dashboard') }}" class="hover:text-blue-600">
                        Dashboard
                    </a>
                </li>
                <li>
                    <a href="{{ route('superadmin.admins.index') }}" class="hover:text-blue-600">
                        Admins
                    </a>
                </li>
            @endif
            {{-- more auth-only links here --}}
            <li>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="hover:text-red-600">
                        Logout
                    </button>
                </form>
            </li>
        </ul>
    @endauth

    @guest
        <div class="flex items-center space-x-4">
            @if(request()->routeIs('signup'))
            <a href="{{ route('login') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Login
            </a>
            @endif

            {{-- Only on the login page, show “Sign Up” --}}
            @if(request()->routeIs('login'))
                <a href="{{ route('signup') }}" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                    Sign Up
                </a>
            @endif
        </div>
    @endguest
</nav>
