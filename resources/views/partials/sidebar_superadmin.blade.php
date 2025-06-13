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
             <a href="{{ route('admin.subject.index') }}"
                class="flex items-center p-3 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 mb-2 {{ request()->routeIs('admin.subject.*') ? 'bg-blue-50 dark:bg-gray-700 text-primary dark:text-white' : '' }}">
                <i class="fas fa-book mr-3"></i> Subjects
            </a>
            <a href="{{ route('admin.teacher.index') }}"
                class="flex items-center p-3 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 mb-2 {{ request()->routeIs('admin.teacher.*') ? 'bg-blue-50 dark:bg-gray-700 text-primary dark:text-white' : '' }}">
                <i class="fas fa-chalkboard-teacher mr-3"></i> Teachers
            </a>
            <a href="{{ route('admin.student.index') }}"
                class="flex items-center p-3 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 mb-2 {{ request()->routeIs('admin.student.*') ? 'bg-blue-50 dark:bg-gray-700 text-primary dark:text-white' : '' }}">
                <i class="fas fa-user-graduate  mr-3"></i> Students
            </a>
            <a href="{{ route('admin.attendance.index') }}"
                class="flex items-center p-3 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 mb-2 {{ request()->routeIs('admin.attendance.*') ? 'bg-blue-50 dark:bg-gray-700 text-primary dark:text-white' : '' }}">
                <i class="fas fa-calendar-check mr-3"></i> Attendance
            </a>
           
            <a href="{{ route('admin.request.index') }}"
                class="flex items-center p-3 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 mb-2 {{ request()->routeIs('admin.request.*') ? 'bg-blue-50 dark:bg-gray-700 text-primary dark:text-white' : '' }}">
                <i class="fas fa-inbox mr-3"></i> Messages
                @if(pending_request_count(auth()->user()->id) > 0)
                    <span class="ml-2 bg-red-500 text-white text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center">
                        {{ pending_request_count(auth()->user()->id) }}
                    </span>
                @endif
            </a>
            <a href="{{  route('admin.payment.index')  }}"
                class="flex items-center p-3 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 mb-2 {{ request()->routeIs('admin.payment.*') ? 'bg-blue-50 dark:bg-gray-700 text-primary dark:text-white' : '' }}">
                <i class="fas fa-credit-card mr-3"></i> Payments
                @if(pending_request_count(auth()->user()->id) > 0)
                    <span class="ml-2 bg-red-500 text-white text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center">
                        {{ pending_request_count(auth()->user()->id) }}
                    </span>
                @endif
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
            <a href="{{ route('teacher.students.index') }}"
                class="flex items-center p-3 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 mb-2 {{ request()->routeIs('teacher.students.*') ? 'bg-blue-50 dark:bg-gray-700 text-primary dark:text-white' : '' }}">
                <i class="fas fa-user-graduate  mr-3"></i> Students
            </a>
            <a href="{{ route('teacher.class.index') }}"
                class="flex items-center p-3 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 mb-2 {{ request()->routeIs('teacher.class.*') ? 'bg-blue-50 dark:bg-gray-700 text-primary dark:text-white' : '' }}">
                <i class="fas fa-chalkboard mr-3"></i> Classes
            </a>
        </nav>
    @elseif(auth()->check() && auth()->user()->role === App\Models\User::ROLE_STUDENT)
        <nav class="flex-1">
            <a href="{{ route('student.dashboard') }}"
                class="flex items-center p-3 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 mb-2 {{ request()->routeIs('student.dashboard') ? 'bg-blue-50 dark:bg-gray-700 text-primary dark:text-white' : '' }}">
                <i class="fas fa-tachometer-alt mr-3"></i> Dashboard
            </a>
             <a href="{{ route('student.class.index') }}"
                class="flex items-center p-3 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 mb-2 {{ request()->routeIs('student.class.*') ? 'bg-blue-50 dark:bg-gray-700 text-primary dark:text-white' : '' }}">
                <i class="fas fa-chalkboard mr-3"></i> Classes
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
<!-- Floating Chat Icon & Popup Form -->
<style>
    #chatbot-btn {
        position: fixed;
        bottom: 30px;
        right: 30px;
        z-index: 9999;
        width: 60px; height: 60px;
        background: #2563eb;
        color: #fff; border-radius: 50%;
        box-shadow: 0 6px 30px rgba(0,0,0,0.2);
        border: none; display: flex;
        align-items: center; justify-content: center;
        font-size: 2rem; cursor: pointer;
        transition: background 0.2s;
    }
    #chatbot-btn:hover { background: #1e40af; }
    #chatbot-popup {
        position: fixed; bottom: 100px; right: 30px; z-index: 10000;
        width: 320px; max-width: 94vw;
        background: #fff; 
        border-radius: 1rem;
        box-shadow: 0 8px 32px rgba(0,0,0,0.24);
        display: none; flex-direction: column;
        padding: 24px 20px 16px 20px;
        border: 1px solid #e5e7eb;
    }
    .dark #chatbot-popup {
        background: #1f2937;
        border-color: #374151;
    }
    #chatbot-popup.active { display: flex; }
    #chatbot-popup .close-btn {
        position: absolute; top: 14px; right: 18px;
        background: none; border: none;
        font-size: 1.2rem; color: #444;
        cursor: pointer;
    }
    .dark #chatbot-popup .close-btn {
        color: #9ca3af;
    }
</style>
@if (auth()->check() && auth()->user()->role !== App\Models\User::ROLE_SUPER_ADMIN && auth()->user()->role !== App\Models\User::ROLE_ADMIN)
    
    
<button id="chatbot-btn" title="Request to Admin">
    <i class="fas fa-comment-alt"></i>
</button>
<div id="chatbot-popup">
    <button class="close-btn" id="close-chatbot-popup"><i class="fas fa-times"></i></button>
    <h3 class="text-lg font-bold mb-2 dark:text-white">Send Request to Admin</h3>
    <form id="teacher-request-form" class="space-y-3">
        @csrf
        <div>
            <input name="subject" type="text" placeholder="Subject"
                   class="w-full border border-gray-300 rounded px-3 py-2 text-gray-700 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300" required maxlength="255">
        </div>
        <div>
            <textarea name="message" rows="3" placeholder="Your message..."
                      class="w-full border border-gray-300 rounded px-3 py-2 text-gray-700 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300" required maxlength="2000"></textarea>
        </div>
        <button type="submit"
            class="w-full py-2 bg-blue-600 text-white font-semibold rounded hover:bg-blue-700 transition">
            Send
        </button>
        <div id="chatbot-msg" class="text-sm mt-2 dark:text-gray-300"></div>
    </form>
</div>
@endif

<script>
    // Show/Hide logic
    const btn = document.getElementById('chatbot-btn');
    const popup = document.getElementById('chatbot-popup');
    const closeBtn = document.getElementById('close-chatbot-popup');
    btn.onclick = () => popup.classList.add('active');
    closeBtn.onclick = () => popup.classList.remove('active');

    // AJAX Form submit
    document.getElementById('teacher-request-form').onsubmit = async function(e){
        e.preventDefault();
        let fd = new FormData(this);
        let msgDiv = document.getElementById('chatbot-msg');
        msgDiv.textContent = '';
        try {
            let url = '{{ auth()->user()->role === App\Models\User::ROLE_TEACHER ? route("teacher.request.store") : route("student.request.store") }}';
            let res = await fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: fd
            });
            let data = await res.json();
            if(data.success){
                msgDiv.textContent = data.message;
                msgDiv.style.color = 'green';
                this.reset();
                setTimeout(()=> popup.classList.remove('active'), 1500);
            } else {
                msgDiv.textContent = data.message || 'Failed. Try again!';
                msgDiv.style.color = 'red';
            }
        } catch(err){
            msgDiv.textContent = 'Network error. Try again!';
            msgDiv.style.color = 'red';
        }
    };
</script>
