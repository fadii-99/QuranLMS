{{-- resources/views/admin/students_list.blade.php --}}
@extends('layouts.admin')

@section('title', 'Student List')

@section('content')
    <div class="mb-8 bg-white dark:bg-gray-700 shadow-lg rounded-xl p-4">
    <h1 class="text-3xl font-bold text-gray-800 text-white">My Students</h1>
</div>
    <div class="bg-white dark:bg-gray-700 shadow rounded-lg overflow-hidden">
        <table class="min-w-full">
            <thead>
                <tr class="bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-300">
                    <th class="px-4 py-3 text-left">Name</th>
                    <th class="px-4 py-3 text-left">Email</th>
                    <th class="px-4 py-3 text-left">Teacher</th>
                    <th class="px-4 py-3 text-left">Registered</th>
                    <th class="px-4 py-3 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($students as $student)
                    <tr class="border-t border-gray-200 dark:border-gray-600">
                        <td class="px-4 py-2">{{ $student->student->name }}</td>
                        <td class="px-4 py-2">{{ $student->student->email }}</td>
                        <td class="px-4 py-2">{{ $student->teacher ? $student->teacher->name : 'Not Assigned' }}</td>
                        <td class="px-4 py-2">{{ $student->created_at->format('Y-m-d') }}</td>
                        <td class="px-4 py-2">
                            <a href="" 
                               class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                                <i class="fas fa-play mr-2"></i>
                                Start Class
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-8 py-12 text-center">
                            <div class="flex flex-col items-center justify-center space-y-3">
                                <i class="fas fa-user-slash text-4xl text-gray-400 dark:text-gray-500"></i>
                                <p class="text-gray-500 dark:text-gray-400 text-lg font-medium">No students found</p>
                                <p class="text-gray-400 dark:text-gray-500 text-sm">Click on "New Student" button to add a student</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="px-4 py-3 border-t border-gray-200 dark:border-gray-600">
            {{ $students->links() }}
        </div>
    </div>


@endsection
