{{-- resources/views/admin/students_list.blade.php --}}
@extends('layouts.admin')

@section('title', 'Student List')

@section('content')
    <div class="mb-8 bg-white dark:bg-gray-700 shadow-lg rounded-xl p-4">
        <h1 class="text-3xl font-bold text-gray-800 text-white">My Students</h1>
    </div>


    <div id="assign-class-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="bg-white dark:bg-gray-700 rounded-2xl p-6 w-full max-w-md backdrop-blur-lg shadow-xl relative">
            <button id="close-assign-class-modal"
                class="absolute top-4 right-4 text-gray-500 dark:text-gray-300 hover:text-gray-700 dark:hover:text-gray-100">
                <i class="fas fa-times text-xl"></i>
            </button>
            <h3 class="text-xl font-bold text-gray-800 dark:text-gray-100 mb-4">Assign Class to <span
                    id="modal-student-name"></span></h3>
            <div class="mb-4">
                <label class="block text-sm text-gray-600 dark:text-gray-300 mb-1">Student Availability:</label>
                <div id="modal-availability" class="text-gray-800 dark:text-gray-200"></div>
            </div>
            <form id="assign-class-form" method="POST" action="{{ route('teacher.student.assign-class') }}"
                class="space-y-4">

                @csrf
                <input type="hidden" name="student_id" id="modal-student-id">
                <div>
                    <label for="class_time_from" class="block text-sm text-gray-600 dark:text-gray-300 mb-1">Class Start
                        Time</label>
                    <input type="time" name="class_time_from" id="class_time_from" required
                        class="w-full px-4 py-2 rounded-lg bg-gray-100 dark:bg-gray-600 text-gray-800 dark:text-gray-200 border border-gray-300/50 dark:border-gray-600/50 focus:ring-2 focus:ring-primary transition">
                </div>
                <div>
                    <label for="class_time_to" class="block text-sm text-gray-600 dark:text-gray-300 mb-1">Class End
                        Time</label>
                    <input type="time" name="class_time_to" id="class_time_to" required
                        class="w-full px-4 py-2 rounded-lg bg-gray-100 dark:bg-gray-600 text-gray-800 dark:text-gray-200 border border-gray-300/50 dark:border-gray-600/50 focus:ring-2 focus:ring-primary transition">
                </div>
                <div id="assign-class-error" class="text-red-600 dark:text-red-400 mb-2 hidden"></div>
                <button type="submit"
                    class="w-full bg-primary text-white py-2 rounded-lg hover:bg-primary-dark transition">
                    Set Class
                </button>
            </form>
        </div>
    </div>




    <div class="bg-white dark:bg-gray-700 shadow rounded-lg overflow-hidden">
        <table class="min-w-full">
            <thead>
                <tr class="bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-300">
                    <th class="px-4 py-3 text-left">Name</th>
                    <th class="px-4 py-3 text-left">Email</th>
                    <th class="px-4 py-3 text-left">Available From</th>
                    <th class="px-4 py-3 text-left">Available To</th>
                    <th class="px-4 py-3 text-left">Registered</th>
                    <th class="px-4 py-3 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($students as $student)
                    <tr class="border-t border-gray-200 dark:border-gray-600">
                        <td class="px-4 py-2">{{ $student->student->name }}</td>
                        <td class="px-4 py-2">{{ $student->student->email }}</td>
                        <td class="px-4 py-2">{{ $student->student->available_from }}</td>
                        <td class="px-4 py-2">{{ $student->student->available_to }}</td>
                        <td class="px-4 py-2">{{ $student->created_at->format('Y-m-d') }}</td>
                        <td class="px-4 py-2">
                            @if ($student->student->assignedClass)
                                <div class="flex items-center gap-2">
                                    <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm">
                                        <i class="fas fa-clock mr-1"></i>
                                        {{ $student->student->assignedClass->time }} 
                                    </span>
                                    <form action="{{ route('teacher.student.remove-class', $student->student->id) }}" method="POST" class="inline">
                                        @csrf
                                        <input type="hidden" name="klass_id" value="{{ $student->student->assignedClass->id }}">
                                        <button type="submit" class="px-3 py-1 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                                            <i class="fas fa-times mr-1"></i> Remove
                                        </button>
                                    </form>
                                </div>
                            @else
                            <button
                                class="assign-class-btn px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition"
                                data-student-id="{{ $student->student->id }}"
                                data-student-name="{{ $student->student->name }}"
                                data-available-from="{{ $student->student->available_from }}"
                                data-available-to="{{ $student->student->available_to }}">
                                <i class="fas fa-calendar-check mr-2"></i> Assign Class
                            </button>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-8 py-12 text-center">
                            <div class="flex flex-col items-center justify-center space-y-3">
                                <i class="fas fa-user-slash text-4xl text-gray-400 dark:text-gray-500"></i>
                                <p class="text-gray-500 dark:text-gray-400 text-lg font-medium">No students found</p>
                                <p class="text-gray-400 dark:text-gray-500 text-sm">Click on "New Student" button to add a
                                    student</p>
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Open Assign Class Modal
            document.querySelectorAll('.assign-class-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const studentId = this.dataset.studentId;
                    const studentName = this.dataset.studentName;
                    const availableFrom = this.dataset.availableFrom;
                    const availableTo = this.dataset.availableTo;
                    document.getElementById('modal-student-name').textContent = studentName;
                    document.getElementById('modal-availability').textContent =
                        `${availableFrom} to ${availableTo}`;
                    document.getElementById('modal-student-id').value = studentId;
                    document.getElementById('class_time_from').value = '';
                    document.getElementById('class_time_to').value = '';
                    document.getElementById('assign-class-error').classList.add('hidden');
                    document.getElementById('assign-class-modal').classList.remove('hidden');

                    // Save available from/to for validation
                    document.getElementById('assign-class-form').dataset.availableFrom =
                        availableFrom;
                    document.getElementById('assign-class-form').dataset.availableTo = availableTo;
                });
            });

            // Close modal
            document.getElementById('close-assign-class-modal').onclick = function() {
                document.getElementById('assign-class-modal').classList.add('hidden');
            };

            // Validate before submit
            document.getElementById('assign-class-form').onsubmit = function(e) {
                const availableFrom = this.dataset.availableFrom;
                const availableTo = this.dataset.availableTo;
                const classFrom = document.getElementById('class_time_from').value;
                const classTo = document.getElementById('class_time_to').value;
                // Time comparison
                if (classFrom < availableFrom || classTo > availableTo || classFrom >= classTo) {
                    e.preventDefault();
                    const errDiv = document.getElementById('assign-class-error');
                    errDiv.textContent = 'Class time must be within student availability and valid!';
                    errDiv.classList.remove('hidden');
                }
            };
        });
    </script>
@endsection
