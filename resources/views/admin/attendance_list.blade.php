@extends('layouts.admin')

@section('title', 'Attendance Record')

@section('content')
    <div class="mb-8 bg-white dark:bg-gray-700 shadow-lg rounded-xl p-4">
        <div class="flex justify-between items-center">
            <h1 class="text-3xl font-bold text-gray-800 dark:text-white">Attendance Record</h1>
            <div class="text-sm text-gray-600 dark:text-gray-300">
                <i class="fas fa-calendar-alt mr-2"></i>
                {{ \Carbon\Carbon::now()->format('l, F j, Y') }}
            </div>
        </div>
        
        <!-- Toggle Buttons -->
        <div class="mt-4 flex space-x-2">
            <button id="teacher-btn" 
                class="group relative px-8 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-200 active-tab">
                <i class="fas fa-chalkboard-teacher mr-2"></i>
                Teachers
            </button>
            <button id="student-btn" 
                class="group relative px-8 py-3 bg-gray-200 dark:bg-gray-600 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-500 transition duration-200">
                <i class="fas fa-user-graduate mr-2"></i>
                Students
            </button>
        </div>
    </div>

    <!-- Teachers Attendance Table -->
    <div id="teacher-table" class="bg-white dark:bg-gray-700 shadow rounded-lg overflow-hidden overflow-x-auto">
        <div class="px-4 py-3 bg-gray-50 dark:bg-gray-800 border-b">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white">
                <i class="fas fa-chalkboard-teacher mr-2"></i>
                Teacher Attendance Records
            </h3>
        </div>
        <table class="min-w-full">
            <thead>
                <tr class="bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-300">
                    <th class="px-4 py-3 text-left">Teacher Name</th>
                    <th class="px-4 py-3 text-left">Student</th>
                    <th class="px-4 py-3 text-left">Date</th>
                    <th class="px-4 py-3 text-left">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($teacherAttendance ?? [] as $attendance)
                    <tr class="border-t border-gray-200 dark:border-gray-600">
                        <td class="px-4 py-2 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center mr-3">
                                    <i class="fas fa-user text-blue-600 dark:text-blue-300 text-sm"></i>
                                </div>
                                {{ $attendance->teacher->name ?? 'N/A' }}
                            </div>
                        </td>
                        <td class="px-4 py-2">{{ $attendance->student->name}}</td>
                        <td class="px-4 py-2 whitespace-nowrap">{{ \Carbon\Carbon::parse($attendance->date)->format('M d, Y') }}</td>
                        <td class="px-4 py-2 whitespace-nowrap">
                            <span class="px-2 py-1 rounded-full text-xs font-medium
                                {{ $attendance->status == 'present' ? 'bg-green-200 text-green-800' : '' }}
                                {{ $attendance->status == 'absent' ? 'bg-red-200 text-red-800' : '' }}
                                {{ $attendance->status == 'late' ? 'bg-yellow-200 text-yellow-800' : '' }}
                                {{ $attendance->status == 'half_day' ? 'bg-orange-200 text-orange-800' : '' }}">
                                {{ ucfirst(str_replace('_', ' ', $attendance->status)) }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-8 py-12 text-center">
                            <div class="flex flex-col items-center justify-center space-y-3">
                                <i class="fas fa-calendar-times text-4xl text-gray-400 dark:text-gray-500"></i>
                                <p class="text-gray-500 dark:text-gray-400 text-lg font-medium">No teacher attendance records found</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        @if(isset($teacherAttendance) && method_exists($teacherAttendance, 'links'))
            <div class="px-4 py-3 border-t border-gray-200 dark:border-gray-600">
                {{ $teacherAttendance->links() }}
            </div>
        @endif
    </div>

    <!-- Students Attendance Table -->
    <div id="student-table" class="bg-white dark:bg-gray-700 shadow rounded-lg overflow-hidden overflow-x-auto hidden">
        <div class="px-4 py-3 bg-gray-50 dark:bg-gray-800 border-b">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white">
                <i class="fas fa-user-graduate mr-2"></i>
                Student Attendance Records
            </h3>
        </div>
        <table class="min-w-full">
            <thead>
                <tr class="bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-300">
                    <th class="px-4 py-3 text-left">Student Name</th>
                    <th class="px-4 py-3 text-left">Teacher</th>
                    <th class="px-4 py-3 text-left">Date</th>
                    <th class="px-4 py-3 text-left">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($studentAttendance ?? [] as $attendance)
                    <tr class="border-t border-gray-200 dark:border-gray-600">
                        <td class="px-4 py-2 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-green-100 dark:bg-green-900 rounded-full flex items-center justify-center mr-3">
                                    <i class="fas fa-user-graduate text-green-600 dark:text-green-300 text-sm"></i>
                                </div>
                                {{ $attendance->student->name }}
                            </div>
                        </td>
                        <td class="px-4 py-2">{{ $attendance->teacher->name }}</td>
                        <td class="px-4 py-2 whitespace-nowrap">{{ \Carbon\Carbon::parse($attendance->date)->format('M d, Y') }}</td>
                        <td class="px-4 py-2 whitespace-nowrap">
                            <span class="px-2 py-1 rounded-full text-xs font-medium
                                {{ $attendance->status == 'present' ? 'bg-green-200 text-green-800' : '' }}
                                {{ $attendance->status == 'absent' ? 'bg-red-200 text-red-800' : '' }}
                                {{ $attendance->status == 'late' ? 'bg-yellow-200 text-yellow-800' : '' }}
                                {{ $attendance->status == 'half_day' ? 'bg-orange-200 text-orange-800' : '' }}">
                                {{ ucfirst(str_replace('_', ' ', $attendance->status)) }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-8 py-12 text-center">
                            <div class="flex flex-col items-center justify-center space-y-3">
                                <i class="fas fa-calendar-times text-4xl text-gray-400 dark:text-gray-500"></i>
                                <p class="text-gray-500 dark:text-gray-400 text-lg font-medium">No student attendance records found</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        @if(isset($studentAttendance) && method_exists($studentAttendance, 'links'))
            <div class="px-4 py-3 border-t border-gray-200 dark:border-gray-600">
                {{ $studentAttendance->links() }}
            </div>
        @endif
    </div>

    <script>
        // Tab switching functionality
        document.getElementById('teacher-btn').addEventListener('click', function() {
            // Show teacher table, hide student table
            document.getElementById('teacher-table').classList.remove('hidden');
            document.getElementById('student-table').classList.add('hidden');
            
            // Update button styles
            this.classList.add('bg-blue-600', 'text-white', 'active-tab');
            this.classList.remove('bg-gray-200', 'dark:bg-gray-600', 'text-gray-700', 'dark:text-gray-200');
            
            document.getElementById('student-btn').classList.remove('bg-blue-600', 'text-white', 'active-tab');
            document.getElementById('student-btn').classList.add('bg-gray-200', 'dark:bg-gray-600', 'text-gray-700', 'dark:text-gray-200');
        });

        document.getElementById('student-btn').addEventListener('click', function() {
            // Show student table, hide teacher table
            document.getElementById('student-table').classList.remove('hidden');
            document.getElementById('teacher-table').classList.add('hidden');
            
            // Update button styles
            this.classList.add('bg-blue-600', 'text-white', 'active-tab');
            this.classList.remove('bg-gray-200', 'dark:bg-gray-600', 'text-gray-700', 'dark:text-gray-200');
            
            document.getElementById('teacher-btn').classList.remove('bg-blue-600', 'text-white', 'active-tab');
            document.getElementById('teacher-btn').classList.add('bg-gray-200', 'dark:bg-gray-600', 'text-gray-700', 'dark:text-gray-200');
        });
    </script>

    <style>
        .active-tab {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
    </style>
@endsection