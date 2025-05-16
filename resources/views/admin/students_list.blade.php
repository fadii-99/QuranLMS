{{-- resources/views/admin/students_list.blade.php --}}
@extends('layouts.admin')

@section('title', 'Student List')

@section('content')
    <div class="flex items-center justify-between mb-8 bg-white dark:bg-gray-700 shadow-lg rounded-xl p-4"
        data-aos="fade-down">
        <h1 class="text-3xl font-extrabold text-gray-800 dark:text-gray-100 tracking-tight">Students</h1>
    </div>
    <div class="flex justify-between items-center mb-6">
        <h2></h2>
        <button id="open-modal"
            class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition flex items-center">
            <i class="fas fa-user-plus mr-2"></i> New Student
        </button>
    </div>

    {{-- New Student Modal --}}
    <div id="student-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="bg-white dark:bg-gray-700 rounded-2xl p-6 w-full max-w-md backdrop-blur-lg shadow-xl relative">
            <button id="close-modal"
                class="absolute top-4 right-4 text-gray-500 dark:text-gray-300 hover:text-gray-700 dark:hover:text-gray-100">
                <i class="fas fa-times text-xl"></i>
            </button>
            <h3 class="text-xl font-bold text-gray-800 dark:text-gray-100 mb-4">Register New Student</h3>
            <form action="{{ route('admin.student.create') }}" method="POST" enctype="multipart/form-data"
                class="space-y-4">
                @csrf
                <div>
                    <label for="name" class="block text-sm text-gray-600 dark:text-gray-300 mb-1">Name</label>
                    <input id="name" name="name" type="text" required
                        class="w-full px-4 py-2 rounded-lg bg-gray-100 dark:bg-gray-600 text-gray-800 dark:text-gray-200 border border-gray-300/50 dark:border-gray-600/50 focus:ring-2 focus:ring-primary transition"
                        placeholder="Enter student name">
                </div>
                <div>
                    <label for="email" class="block text-sm text-gray-600 dark:text-gray-300 mb-1">Email</label>
                    <input id="email" name="email" type="email" required
                        class="w-full px-4 py-2 rounded-lg bg-gray-100 dark:bg-gray-600 text-gray-800 dark:text-gray-200 border border-gray-300/50 dark:border-gray-600/50 focus:ring-2 focus:ring-primary transition"
                        placeholder="Enter student email">
                </div>
                <div class="relative">
                    <label for="password" class="block text-sm text-gray-600 dark:text-gray-300 mb-1">Password</label>
                    <input id="password" name="password" type="password" required
                        class="w-full pr-10 px-4 py-2 rounded-lg bg-gray-100 dark:bg-gray-600 text-gray-800 dark:text-gray-200 border border-gray-300/50 dark:border-gray-600/50 focus:ring-2 focus:ring-primary transition"
                        placeholder="Create a password">
                    <button type="button" id="togglePassword"
                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500 dark:text-gray-400">
                        <i class="fas fa-eye absolute right-4 top-2/3 -translate-y-1/2" id="eyeIcon"></i>
                    </button>
                </div>
                <button type="submit"
                    class="w-full bg-primary text-white py-2 rounded-lg hover:bg-primary-dark transition">
                    Register Student
                </button>
            </form>
        </div>
    </div>

    {{-- Edit Student Modal --}}
    <div id="edit-student-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="bg-white dark:bg-gray-700 rounded-2xl p-6 w-full max-w-md backdrop-blur-lg shadow-xl relative">
            <button id="close-edit-modal"
                class="absolute top-4 right-4 text-gray-500 dark:text-gray-300 hover:text-gray-700 dark:hover:text-gray-100">
                <i class="fas fa-times text-xl"></i>
            </button>
            <h3 class="text-xl font-bold text-gray-800 dark:text-gray-100 mb-4">Edit Student</h3>
            <form action="{{ route('admin.student.update') }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')
                <input type="hidden" id="edit-id" name="id">
                <div>
                    <label for="edit-name" class="block text-sm text-gray-600 dark:text-gray-300 mb-1">Name</label>
                    <input id="edit-name" name="name" type="text" required
                        class="w-full px-4 py-2 rounded-lg bg-gray-100 dark:bg-gray-600 text-gray-800 dark:text-gray-200 border border-gray-300/50 dark:border-gray-600/50 focus:ring-2 focus:ring-primary transition">
                </div>
                <div>
                    <label for="edit-email" class="block text-sm text-gray-600 dark:text-gray-300 mb-1">Email</label>
                    <input id="edit-email" name="email" type="email" required
                        class="w-full px-4 py-2 rounded-lg bg-gray-100 dark:bg-gray-600 text-gray-800 dark:text-gray-200 border border-gray-300/50 dark:border-gray-600/50 focus:ring-2 focus:ring-primary transition">
                </div>
                <button type="submit"
                    class="w-full bg-primary text-white py-2 rounded-lg hover:bg-primary-dark transition">
                    Update Student
                </button>
            </form>
        </div>
    </div>

    {{-- Delete Confirmation Modal --}}
    <div id="delete-student-modal"
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="bg-white dark:bg-gray-700 rounded-2xl p-6 w-full max-w-sm backdrop-blur-lg shadow-xl">
            <h3 class="text-xl font-bold text-gray-800 dark:text-gray-100 mb-4">Confirm Delete</h3>
            <p class="text-gray-600 dark:text-gray-300 mb-6">
                Are you sure you to delete <span id="delete-student-name" class="font-semibold"></span>?
            </p>
            <div class="flex justify-end space-x-4">
                <button id="cancel-delete"
                    class="px-4 py-2 bg-gray-300 dark:bg-gray-600 text-gray-800 dark:text-gray-200 rounded-lg hover:bg-gray-400 dark:hover:bg-gray-500 transition">
                    Cancel
                </button>
                <button id="confirm-delete" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition"
                    data-student-id="">
                    Delete
                </button>
            </div>
        </div>
    </div>

    {{-- Assign Teacher Modal --}}
    <div id="assign-teacher-modal"
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="bg-white dark:bg-gray-700 rounded-2xl p-6 w-full max-w-md shadow-xl relative">
            <button id="close-assign-modal"
                class="absolute top-4 right-4 text-gray-500 dark:text-gray-300 hover:text-gray-700 dark:hover:text-gray-100">
                <i class="fas fa-times text-xl"></i>
            </button>

            <h3 class="text-xl font-bold text-gray-800 dark:text-gray-100 mb-4">
                Assign Teacher to <span id="assign-student-name" class="font-semibold"></span>
            </h3>

            <div id="remove-teacher-section" class="mb-4 hidden">
                <p class="mb-2 text-gray-600 dark:text-gray-300">Current Teacher:
                    <span id="current-teacher-name" class="font-semibold"></span>
                </p>
                <button id="remove-teacher-btn" data-pivot-id=""
                    class="bg-red-600 text-white px-3 py-1 rounded-lg hover:bg-red-700 text-sm">
                    Remove Teacher
                </button>
            </div>

            <div class="max-h-80 overflow-y-auto space-y-2">
                @forelse($teachers as $teacher)
                    <div class="flex items-center justify-between p-3 bg-gray-100 dark:bg-gray-600 rounded-lg">
                        <span class="text-gray-800 dark:text-gray-200">{{ $teacher->name }}</span>
                        <button
                            class="assign-teacher-btn text-green-500 hover:text-green-700 dark:text-green-400 dark:hover:text-green-300"
                            data-teacher-id="{{ $teacher->id }}" data-teacher-name="{{ $teacher->name }}">
                            <i class="fas fa-arrow-right"></i>
                        </button>
                    </div>
                @empty
                    <p class="text-gray-500 dark:text-gray-400 text-center">No teachers available</p>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Students Data Table --}}
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
                        <td class="px-4 py-2">{{ $student->name }}</td>
                        <td class="px-4 py-2">{{ $student->email }}</td>
                        <td class="px-4 py-2">
                            {!! $student->teacherStudent
                                ? $student->teacherStudent->teacher->name
                                : '<span class="text-red-500 font-semibold">Not Assigned</span>' !!}
                        </td>
                        <td class="px-4 py-2">{{ $student->created_at->format('Y-m-d') }}</td>
                        <td class="px-4 py-2 flex space-x-2">
                            <button class="assign-teacher text-green-500 hover:text-green-700" title="Assign Teacher"
                                data-student-id="{{ $student->id }}" data-student-name="{{ $student->name }}"
                                @if ($student->teacherStudent) data-pivot-id="{{ $student->teacherStudent->id }}"
                                    data-teacher-id="{{ $student->teacherStudent->teacher_id }}"
                                    data-teacher-name="{{ $student->teacherStudent->teacher->name }}" @endif>
                                <i class="fas fa-chalkboard-teacher"></i>
                            </button>
                            <button class="edit-student text-blue-500 hover:text-blue-700" data-id="{{ $student->id }}"
                                data-name="{{ $student->name }}" data-email="{{ $student->email }}"
                                data-active="{{ $student->is_active }}">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="delete-student text-red-500 hover:text-red-700" data-id="{{ $student->id }}"
                                data-name="{{ $student->name }}">
                                <i class="fas fa-trash"></i>
                            </button>
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
        document.addEventListener('DOMContentLoaded', () => {
            // New Student Modal
            const openModalBtn = document.getElementById('open-modal');
            const closeModalBtn = document.getElementById('close-modal');
            const newStudentModal = document.getElementById('student-modal');

            openModalBtn.addEventListener('click', () => {
                newStudentModal.classList.remove('hidden');
            });

            closeModalBtn.addEventListener('click', () => {
                newStudentModal.classList.add('hidden');
            });

            // Password toggle functionality
            const pwdInput = document.getElementById('password');
            const toggleBtn = document.getElementById('togglePassword');
            const eyeIcon = document.getElementById('eyeIcon');

            toggleBtn.addEventListener('click', () => {
                const type = pwdInput.getAttribute('type') === 'password' ? 'text' : 'password';
                pwdInput.setAttribute('type', type);
                eyeIcon.classList.toggle('fa-eye');
                eyeIcon.classList.toggle('fa-eye-slash');
            });

            // Edit Student Modal
            const editModal = document.getElementById('edit-student-modal');
            const closeEditModalBtn = document.getElementById('close-edit-modal');
            const editButtons = document.querySelectorAll('.edit-student');

            editButtons.forEach(button => {
                button.addEventListener('click', () => {
                    const id = button.dataset.id;
                    const name = button.dataset.name;
                    const email = button.dataset.email;
                    const active = button.dataset.active;

                    document.getElementById('edit-id').value = id;
                    document.getElementById('edit-name').value = name;
                    document.getElementById('edit-email').value = email;

                    editModal.classList.remove('hidden');
                });
            });

            closeEditModalBtn.addEventListener('click', () => {
                editModal.classList.add('hidden');
            });

            // Delete Student Modal
            const deleteModal = document.getElementById('delete-student-modal');
            const cancelDeleteBtn = document.getElementById('cancel-delete');
            const confirmDeleteBtn = document.getElementById('confirm-delete');
            const csrfToken = '{{ csrf_token() }}';

            document.querySelectorAll('.delete-student').forEach(btn => {
                btn.addEventListener('click', () => {
                    const id = btn.dataset.id;
                    const name = btn.dataset.name;
                    document.getElementById('delete-student-name').textContent = name;
                    confirmDeleteBtn.dataset.studentId = id;
                    deleteModal.classList.remove('hidden');
                });
            });

            // Cancel
            cancelDeleteBtn.addEventListener('click', () => {
                deleteModal.classList.add('hidden');
            });

            // Confirm delete via AJAX
            confirmDeleteBtn.addEventListener('click', async () => {
                const studentId = confirmDeleteBtn.dataset.studentId;

                try {
                    const res = await fetch('{{ route('admin.student.delete') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify({
                            student_id: studentId
                        })
                    });
                    const data = await res.json();

                    if (data.success) {
                        showToast('success', data.message);
                        deleteModal.classList.add('hidden');
                        setTimeout(() => location.reload(), 2000);
                    } else {
                        showToast('error', data.message);
                    }
                } catch (err) {
                    showToast('error', 'Could not delete student. Try again.');
                }
            });

            // Assign Teacher Modal
            const assignModal = document.getElementById('assign-teacher-modal');
            const closeAssignBtn = document.getElementById('close-assign-modal');
            const assignButtons = document.querySelectorAll('.assign-teacher');
            const assignTeacherBtns = document.querySelectorAll('.assign-teacher-btn');
            const removeSection = document.getElementById('remove-teacher-section');
            const currentNameEl = document.getElementById('current-teacher-name');
            const removeBtn = document.getElementById('remove-teacher-btn');
            const studentNameEl = document.getElementById('assign-student-name');

            // Open modal, populate data
            assignButtons.forEach(btn => {
                btn.addEventListener('click', () => {
                    const studentId = btn.dataset.studentId;
                    const studentName = btn.dataset.studentName;
                    const pivotId = btn.dataset.pivotId;
                    const teacherName = btn.dataset.teacherName;

                    studentNameEl.textContent = studentName;

                    // If already assigned, show remove section
                    if (pivotId) {
                        removeSection.classList.remove('hidden');
                        currentNameEl.textContent = teacherName;
                        removeBtn.dataset.pivotId = pivotId;
                    } else {
                        removeSection.classList.add('hidden');
                    }

                    // stash studentId on each "assign-teacher-btn"
                    assignTeacherBtns.forEach(a => {
                        a.dataset.studentId = studentId;
                    });

                    assignModal.classList.remove('hidden');
                });
            });

            // Close modal
            closeAssignBtn.addEventListener('click', () => {
                assignModal.classList.add('hidden');
            });

            // Assign a new teacher
            assignTeacherBtns.forEach(btn => {
                btn.addEventListener('click', async () => {
                    const studentId = btn.dataset.studentId;
                    const teacherId = btn.dataset.teacherId;

                    try {
                        const res = await fetch(
                            '{{ route('admin.student.assign-teacher') }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': csrfToken
                                },
                                body: JSON.stringify({
                                    student_id: studentId,
                                    teacher_id: teacherId
                                })
                            });
                        const data = await res.json();

                        if (data.success) {
                            showToast('success', data.message);
                            setTimeout(() => location.reload(), 2000);
                        } else {
                            showToast('error', data.message);
                        }
                    } catch (err) {
                        showToast('error', 'Network error, please try again.');
                    }
                });
            });

            // Remove current teacher (by pivot id)
            removeBtn.addEventListener('click', async () => {
                const pivotId = removeBtn.dataset.pivotId;

                try {
                    const res = await fetch('{{ route('admin.student.remove-teacher') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify({
                            pivot_id: pivotId
                        })
                    });
                    const data = await res.json();

                    if (data.success) {
                        showToast('success', data.message);
                        setTimeout(() => location.reload(), 2000);
                    } else {
                        showToast('error', data.message);
                    }
                } catch (err) {
                    showToast('error', 'Could not remove teacher. Try again.');
                }
            });

            // Close modals when clicking outside
            window.addEventListener('click', (e) => {
                if (e.target === newStudentModal) newStudentModal.classList.add('hidden');
                if (e.target === editModal) editModal.classList.add('hidden');
                if (e.target === deleteModal) deleteModal.classList.add('hidden');
                if (e.target === assignModal) assignModal.classList.add('hidden');
            });
        });
    </script>
@endsection