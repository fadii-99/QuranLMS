{{-- resources/views/admin/students_list.blade.php --}}
@extends('layouts.admin')

@section('title', 'Student List')

@section('content')
    <div class="mb-8 bg-white dark:bg-gray-700 shadow-lg rounded-xl p-4">
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
                <div class="flex space-x-2">
                    <div class="w-1/2">
                        <label for="available_from" class="block text-sm text-gray-600 dark:text-gray-300 mb-1">Available
                            From</label>
                        <input id="available_from" name="available_from" type="time" required
                            class="w-full px-4 py-2 rounded-lg bg-gray-100 dark:bg-gray-600 text-gray-800 dark:text-gray-200 border border-gray-300/50 dark:border-gray-600/50 focus:ring-2 focus:ring-primary transition">
                    </div>
                    <div class="w-1/2">
                        <label for="available_to" class="block text-sm text-gray-600 dark:text-gray-300 mb-1">Available
                            To</label>
                        <input id="available_to" name="available_to" type="time" required
                            class="w-full px-4 py-2 rounded-lg bg-gray-100 dark:bg-gray-600 text-gray-800 dark:text-gray-200 border border-gray-300/50 dark:border-gray-600/50 focus:ring-2 focus:ring-primary transition">
                    </div>
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
                <div class="flex space-x-2">
                    <div class="w-1/2">
                        <label for="edit-available_from"
                            class="block text-sm text-gray-600 dark:text-gray-300 mb-1">Available From</label>
                        <input id="edit-available_from" name="available_from" type="time" required
                            class="w-full px-4 py-2 rounded-lg bg-gray-100 dark:bg-gray-600 text-gray-800 dark:text-gray-200 border border-gray-300/50 dark:border-gray-600/50 focus:ring-2 focus:ring-primary transition">
                    </div>
                    <div class="w-1/2">
                        <label for="edit-available_to" class="block text-sm text-gray-600 dark:text-gray-300 mb-1">Available
                            To</label>
                        <input id="edit-available_to" name="available_to" type="time" required
                            class="w-full px-4 py-2 rounded-lg bg-gray-100 dark:bg-gray-600 text-gray-800 dark:text-gray-200 border border-gray-300/50 dark:border-gray-600/50 focus:ring-2 focus:ring-primary transition">
                    </div>
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

            <div id="remove-teacher-section" class="mb-4">
                <p class="mb-2 text-gray-600 dark:text-gray-300 font-semibold">Currently Assigned Teachers:</p>
                <div id="current-teacher-list" class="space-y-2">
                    {{-- Filled by JS --}}
                </div>
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

    {{-- Assign Subject Modal --}}
    <div id="assignSubjectModal"
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="bg-white dark:bg-gray-700 rounded-2xl p-6 w-full max-w-md shadow-xl relative">
            <button id="close-assign-modal1"
                class="absolute top-4 right-4 text-gray-500 dark:text-gray-300 hover:text-gray-700 dark:hover:text-gray-100">
                <i class="fas fa-times text-xl"></i>
            </button>
            <h3 class="text-xl font-bold text-gray-800 dark:text-gray-100 mb-4">
                Assign Subject
            </h3>
            <div id="current-subjects" class="mb-4">
                <h4 class="text-sm font-semibold text-gray-600 dark:text-gray-300 mb-2">Currently Assigned:</h4>
                <div id="assigned-subjects-list" class="space-y-2">
                    {{-- Filled by JS --}}
                </div>
            </div>
            <div class="max-h-80 overflow-y-auto space-y-2">
                <h4 class="text-sm font-semibold text-gray-600 dark:text-gray-300 mb-2">Available Subjects:</h4>
                @forelse($subjects as $ts)
                    <div class="flex items-center justify-between p-3 bg-gray-100 dark:bg-gray-600 rounded-lg">
                        <span class="text-gray-800 dark:text-gray-200">
                            {{ $ts->subject->name }}
                            <span class="text-sm text-white-500">
                                ({{ $ts->teacher->name ?? 'N/A' }})
                            </span>
                        </span>
                        <button type="button" class="assign-subject-btn text-green-500 hover:text-green-700"
                            data-subject-id="{{ $ts->id }}">
                            <i class="fas fa-arrow-right"></i>
                        </button>
                    </div>
                @empty
                    <p class="text-gray-500 dark:text-gray-400 text-center">No subjects available</p>
                @endforelse
            </div>
            <input type="hidden" name="student_id" id="modalStudentId" />
        </div>
    </div>

    {{-- Students Data Table --}}
    <div class="bg-white dark:bg-gray-700 shadow rounded-lg overflow-hidden overflow-x-auto">
        <table class="min-w-full">
            <thead>
                <tr class="bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-300">
                    <th class="px-4 py-3 text-left">Name</th>
                    <th class="px-4 py-3 text-left">Email</th>
                    <th class="px-4 py-3 text-left">Teacher</th>
                    <th class="px-4 py-3 text-left">Subject</th>
                    <th class="px-4 py-3 text-left">Registered</th>
                    <th class="px-4 py-3 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($students as $student)
                    @php
                        $assignedSubjectsForModal = $student->subjectsSS
                            ->map(function ($subject) {
                                return [
                                    'id' => $subject->pivot->id,
                                    'name' => $subject->name,
                                    'teacher' => optional($subject->teacher)->name ?? 'N/A',
                                ];
                            })
                            ->toArray();

                        $assignedTeachersForModal = $student->teachersSS
                            ? $student->teachersSS
                                ->map(function ($t) {
                                    return [
                                        'id' => $t->id,
                                        'name' => $t->name,
                                        'pivot_id' => $t->pivot->id ?? null, // This will now be set!
                                    ];
                                })
                                ->toArray()
                            : [];
                    @endphp
                    <tr class="border-t border-gray-200 dark:border-gray-600">
                        <td class="px-4 py-2">{{ $student->name }}</td>
                        <td class="px-4 py-2">{{ $student->email }}</td>
                        <td class="px-4 py-2">
                            @if ($student->teachersSS && $student->teachersSS->count())
                                <div class="flex flex-wrap gap-2">
                                    @foreach ($student->teachersSS as $teacher)
                                        <span class="px-2 py-1 rounded bg-green-100 text-green-800 text-xs">
                                            {{ $teacher->name }}
                                        </span>
                                    @endforeach
                                </div>
                            @else
                                <span class="text-red-500 font-semibold">Not Assigned</span>
                            @endif
                        </td>
                        <td class="px-4 py-2">
                            @if (!$student->teachersSS || !$student->teachersSS->count())
                                <span class="text-red-500 font-semibold">Assign Teacher</span>
                            @elseif ($student->teachersSS->count() && !$student->subjectsSS->count())
                                <span class="text-red-500 font-semibold">Assign Subject</span>
                            @elseif ($student->subjectsSS->count())
                                <div class="flex flex-wrap gap-2">
                                    @foreach ($student->subjectsSS as $subject)
                                        <span class="px-2 py-1 rounded bg-blue-100 text-blue-800 text-xs">
                                            {{ $subject->name }}
                                        </span>
                                    @endforeach
                                </div>
                            @else
                                <span class="text-red-500 font-semibold">Not Assigned</span>
                            @endif
                        </td>
                        <td class="px-4 py-2">{{ $student->created_at->format('Y-m-d') }}</td>
                        <td class="px-4 py-2 flex space-x-2">
                            <button class="assign-teacher text-green-500 hover:text-green-700" title="Assign Teacher"
                                data-student-id="{{ $student->id }}" data-student-name="{{ $student->name }}"
                                data-assigned-teachers='@json($assignedTeachersForModal)'>
                                <i class="fas fa-chalkboard-teacher"></i>
                            </button>
                            @if ($student->teachersSS && $student->teachersSS->count())
                                <button class="text-purple-500 hover:text-purple-700 open-assign-subject"
                                    title="Assign Subject" data-student-id="{{ $student->id }}"
                                    data-assigned-subjects='@json($assignedSubjectsForModal)'>
                                    <i class="fas fa-book-open"></i>
                                </button>
                            @endif

                            <button class="edit-student text-blue-500 hover:text-blue-700" data-id="{{ $student->id }}"
                                data-name="{{ $student->name }}" data-email="{{ $student->email }}"
                                data-available-from="{{ $student->available_from }}"
                                data-available-to="{{ $student->available_to }}"
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
        let assignSubjectStudentId = null;

        function openAssignSubjectModal(studentId, assignedSubjects = []) {
            assignSubjectStudentId = studentId;
            document.getElementById('assignSubjectModal').classList.remove('hidden');
            document.getElementById('modalStudentId').value = studentId;

            // Show currently assigned subjects
            let assignedList = document.getElementById('assigned-subjects-list');
            assignedList.innerHTML = '';
            if (assignedSubjects.length > 0) {
                assignedSubjects.forEach(subj => {
                    assignedList.innerHTML += `
                        <div class="flex justify-between items-center p-2 bg-gray-200 dark:bg-gray-800 rounded-lg">
                            <span>${subj.name} </span>
                            <button type="button" class="remove-subject-btn text-red-500" data-pivot-id="${subj.id}">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    `;
                });
            } else {
                assignedList.innerHTML = `<span class="text-gray-500">None assigned</span>`;
            }

            // --- NEW: Fetch only subjects for assigned teacher ---
            let availableSubjectsList = document.querySelector('#assignSubjectModal .max-h-80.overflow-y-auto.space-y-2');
            availableSubjectsList.innerHTML = '<p class="text-gray-500">Loading...</p>';

            fetch('{{ route('admin.student.subjects') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        student_id: studentId
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.subjects && data.subjects.length > 0) {
                        availableSubjectsList.innerHTML = '';
                        data.subjects.forEach(subj => {
                            availableSubjectsList.innerHTML += `
                                <div class="flex items-center justify-between p-3 bg-gray-100 dark:bg-gray-600 rounded-lg">
                                    <span class="text-gray-800 dark:text-gray-200">
                                        ${subj.subject_name}
                                        <span class="text-xs text-gray-500"></span>
                                    </span>
                                    <button type="button" class="assign-subject-btn text-green-500 hover:text-green-700"
                                        data-teacher-subject-id="${subj.id}">
                                        <i class="fas fa-arrow-right"></i>
                                    </button>
                                </div>
                            `;
                        });
                    } else {
                        availableSubjectsList.innerHTML =
                            '<p class="text-gray-500 dark:text-gray-400 text-center">No subjects available</p>';
                    }
                    document.querySelectorAll('.remove-subject-btn').forEach(btn => {
                        btn.onclick = async function() {
                            const pivotId = this.dataset.pivotId;
                            try {
                                const res = await fetch(
                                    '{{ route('admin.student.remove-subject') }}', {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/json',
                                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                        },
                                        body: JSON.stringify({
                                            pivot_id: pivotId
                                        })
                                    });
                                const data = await res.json();
                                if (data.success) {
                                    showToast('success', data.message);
                                    setTimeout(() => location.reload(), 1000);
                                } else {
                                    showToast('error', data.message);
                                }
                            } catch (err) {
                                showToast('error', 'Failed to remove subject.');
                            }
                        };
                    });
                    // Bind click events for new assign buttons
                    document.querySelectorAll('.assign-subject-btn').forEach(btn => {
                        btn.onclick = async function() {
                            const teacherSubjectId = this.dataset.teacherSubjectId;
                            const studentId = document.getElementById('modalStudentId').value ||
                                assignSubjectStudentId;
                            try {
                                const res = await fetch(
                                    '{{ route('admin.student.assign-subject') }}', {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/json',
                                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                        },
                                        body: JSON.stringify({
                                            student_id: studentId,
                                            subject_id: teacherSubjectId
                                        })
                                    });
                                const data = await res.json();
                                if (data.success) {
                                    showToast('success', data.message);
                                    setTimeout(() => location.reload(), 1000);
                                } else {
                                    showToast('error', data.message);
                                }
                            } catch (err) {
                                showToast('error', 'Failed to assign subject.');
                            }
                        };
                    });
                });
        }

        function closeAssignSubjectModal() {
            document.getElementById('assignSubjectModal').classList.add('hidden');
        }

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

            // Password toggle
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
                    const availableFrom = button.dataset.availableFrom || '';
                    const availableTo = button.dataset.availableTo || '';
                    document.getElementById('edit-id').value = id;
                    document.getElementById('edit-name').value = name;
                    document.getElementById('edit-email').value = email;
                    document.getElementById('edit-available_from').value = availableFrom;
                    document.getElementById('edit-available_to').value = availableTo;
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
            cancelDeleteBtn.addEventListener('click', () => {
                deleteModal.classList.add('hidden');
            });
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

            assignButtons.forEach(btn => {
                btn.addEventListener('click', function() {
                    const studentId = btn.dataset.studentId;
                    const studentName = btn.dataset.studentName;
                    let assignedTeachers = [];
                    try {
                        assignedTeachers = btn.dataset.assignedTeachers && btn.dataset
                            .assignedTeachers !== "null" ?
                            JSON.parse(btn.dataset.assignedTeachers) : [];
                    } catch (e) {
                        assignedTeachers = [];
                    }
                    document.getElementById('assign-student-name').textContent = studentName;
                    const teacherList = document.getElementById('current-teacher-list');
                    teacherList.innerHTML = '';
                    if (assignedTeachers.length > 0) {
                        assignedTeachers.forEach(teacher => {
                            teacherList.innerHTML += `
                    <div class="flex justify-between items-center p-2 bg-gray-200 dark:bg-gray-800 rounded-lg">
                        <span class="text-sm text-gray-100">${teacher.name}</span>
                        <button class="remove-assigned-teacher-btn text-red-500 ml-2" data-pivot-id="${teacher.pivot_id}">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                `;
                        });
                    } else {
                        teacherList.innerHTML = `<span class="text-gray-500">None assigned</span>`;
                    }
                    assignTeacherBtns.forEach(a => {
                        a.dataset.studentId = studentId;
                    });
                    assignModal.classList.remove('hidden');

                    // Bind remove-teacher buttons
                    teacherList.querySelectorAll('.remove-assigned-teacher-btn').forEach(rbtn => {
                        rbtn.onclick = async function() {
                            const pivotId = this.dataset.pivotId;
                            try {
                                const res = await fetch(
                                    '{{ route('admin.student.remove-teacher') }}', {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/json',
                                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                        },
                                        body: JSON.stringify({
                                            pivot_id: pivotId
                                        })
                                    });
                                const data = await res.json();
                                if (data.success) {
                                    showToast('success', data.message);
                                    // Remove pill from UI instantly
                                    this.closest('div').remove();
                                    setTimeout(() => location.reload(), 1000);
                                    // If none left, show message
                                    if (!teacherList.querySelector(
                                            '.remove-assigned-teacher-btn')) {
                                        teacherList.innerHTML =
                                            `<span class="text-gray-500">None assigned</span>`;
                                    }
                                } else {
                                    showToast('error', data.message);
                                }
                            } catch (err) {
                                showToast('error',
                                    'Could not remove teacher. Try again.');
                            }
                        };
                    });
                });
            });


            closeAssignBtn.addEventListener('click', () => {
                assignModal.classList.add('hidden');
            });
            const assignSubjectModal = document.getElementById('assignSubjectModal');
            const closeAssignBtn1 = document.getElementById('close-assign-modal1');

            if (closeAssignBtn1 && assignSubjectModal) {
                closeAssignBtn1.addEventListener('click', (e) => {
                    e.stopPropagation();
                    assignSubjectModal.classList.add('hidden');
                });
            }

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

            // Assign Subject
            document.querySelectorAll('.open-assign-subject').forEach(btn => {
                btn.addEventListener('click', function() {
                    const studentId = this.dataset.studentId;
                    let assignedSubjects = [];
                    try {
                        assignedSubjects = this.dataset.assignedSubjects && this.dataset
                            .assignedSubjects !== "null" ?
                            JSON.parse(this.dataset.assignedSubjects) : [];
                    } catch (e) {
                        assignedSubjects = [];
                    }
                    openAssignSubjectModal(studentId, assignedSubjects);
                });
            });
            document.querySelectorAll('.assign-subject-btn').forEach(btn => {
                btn.onclick = async function() {
                    const subjectId = this.dataset.subjectId;
                    const studentId = document.getElementById('modalStudentId').value ||
                        assignSubjectStudentId;
                    try {
                        const res = await fetch(
                            '{{ route('admin.student.assign-subject') }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                body: JSON.stringify({
                                    student_id: studentId,
                                    subject_id: subjectId
                                })
                            });
                        const data = await res.json();
                        if (data.success) {
                            showToast('success', data.message);
                            setTimeout(() => location.reload(), 1000);
                        } else {
                            showToast('error', data.message);
                        }
                    } catch (err) {
                        showToast('error', 'Failed to assign subject.');
                    }
                };
            });

            // Remove Subject
            document.querySelectorAll('.remove-subject-btn').forEach(btn => {
                btn.addEventListener('click', async () => {
                    const pivotId = btn.dataset.pivotId;
                    try {
                        const res = await fetch(
                            '{{ route('admin.student.remove-subject') }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                body: JSON.stringify({
                                    pivot_id: pivotId
                                })
                            });
                        const data = await res.json();
                        if (data.success) {
                            showToast('success', data.message);
                            setTimeout(() => location.reload(), 1000);
                        } else {
                            showToast('error', data.message);
                        }
                    } catch (err) {
                        showToast('error', 'Failed to remove subject.');
                    }
                });
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
