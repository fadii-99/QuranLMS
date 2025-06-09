@extends('layouts.admin')

@section('title', 'Classes List')

@section('content')
    <div class="mb-8 bg-white dark:bg-gray-700 shadow-lg rounded-xl p-4">
        <h1 class="text-3xl font-bold text-gray-800 dark:text-white">My Classes</h1>
    </div>

    <div class="bg-white dark:bg-gray-700 shadow rounded-lg overflow-hidden">
        <table class="min-w-full">
            <thead>
                <tr class="bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-300">
                    <th class="px-4 py-3 text-left">Student Name</th>
                    <th class="px-4 py-3 text-left">Class Time</th>
                    <th class="px-4 py-3 text-left">Status</th>
                    <th class="px-6 py-3 text-left">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($classes as $class)
                    <tr class="border-t border-gray-200 dark:border-gray-600">
                        <td class="px-4 py-2">{{ $class->student ? $class->student->name : 'N/A' }}</td>
                        <td class="px-4 py-2">{{ $class->time }}</td>
                        <td class="px-4 py-2">
                            <span class="px-2 py-1 rounded-full text-xs font-medium
                                {{ $class->status == 'pending' ? 'bg-yellow-200 text-yellow-800' : '' }}
                                {{ $class->status == 'completed' ? 'bg-green-200 text-green-800' : '' }}
                                {{ $class->status == 'canceled' ? 'bg-red-200 text-red-800' : '' }}">
                                {{ ucfirst($class->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            @php
                                [$startTime, $endTime] = explode('-', $class->time);
                                $nowTime = \Carbon\Carbon::now()->format('H:i');
                                $classIsLive = $class->teacherStarted;
                            @endphp
                            @if ($classIsLive)
                                <a href="{{ route('teacher.class.jitsi', ['code' => $class->link])}}" target="_blank"
                                    class="px-3 py-1 bg-green-600 text-white rounded-lg hover:bg-green-700 transition text-sm">
                                    Join Class
                                </a>
                            @else
                                <button onclick="startClass({{ $class->id }})"
                                    class="px-3 py-1 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition text-sm">
                                    Start Class
                                </button>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-8 py-12 text-center">
                            <div class="flex flex-col items-center justify-center space-y-3">
                                <i class="fas fa-exclamation-triangle text-4xl text-gray-400 dark:text-gray-500"></i>
                                <p class="text-gray-500 dark:text-gray-400 text-lg font-medium">No Classes found</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="px-4 py-3 border-t border-gray-200 dark:border-gray-600">
            {{ $classes->links() }}
        </div>
    </div>

    <script>
        function startClass(classId) {
            fetch(`/teacher/class/${classId}/start`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    window.location.href = data.link;
                } else {
                    alert(data.message || 'Could not start class');
                }
            })
            .catch(() => alert('Server error!'));
        }
    </script>
@endsection