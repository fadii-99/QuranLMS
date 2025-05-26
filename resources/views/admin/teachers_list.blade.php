{{-- resources/views/admin/teachers_list.blade.php --}}
@extends('layouts.admin')

@section('title', 'Teacher List')

@section('content')
  <div class="flex items-center justify-between mb-8 bg-white dark:bg-gray-700 shadow-lg rounded-xl p-4"
    data-aos="fade-down">
    <h1 class="text-3xl font-extrabold text-gray-800 dark:text-gray-100 tracking-tight">Teachers</h1>
  </div>
  <div class="flex justify-between items-center mb-6">
    <h2></h2>
    <button id="open-modal"
      class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition flex items-center">
      <i class="fas fa-user-plus mr-2"></i> New Teacher
    </button>
  </div>

  {{-- New Teacher Modal --}}
  <div id="teacher-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
    <div class="bg-white dark:bg-gray-700 rounded-2xl p-6 w-full max-w-md backdrop-blur-lg shadow-xl relative">
      <button id="close-modal"
        class="absolute top-4 right-4 text-gray-500 dark:text-gray-300 hover:text-gray-700 dark:hover:text-gray-100">
        <i class="fas fa-times text-xl"></i>
      </button>
      <h3 class="text-xl font-bold text-gray-800 dark:text-gray-100 mb-4">Register New Teacher</h3>
      <form action="{{ route('admin.teacher.create') }}" method="POST" enctype="multipart/form-data"
        class="space-y-4">
        @csrf
        <div>
          <label for="name" class="block text-sm text-gray-600 dark:text-gray-300 mb-1">Name</label>
          <input id="name" name="name" type="text" required
            class="w-full px-4 py-2 rounded-lg bg-gray-100 dark:bg-gray-600 text-gray-800 dark:text-gray-200 border border-gray-300/50 dark:border-gray-600/50 focus:ring-2 focus:ring-primary transition"
            placeholder="Enter teacher name">
        </div>
        <div>
          <label for="email" class="block text-sm text-gray-600 dark:text-gray-300 mb-1">Email</label>
          <input id="email" name="email" type="email" required
            class="w-full px-4 py-2 rounded-lg bg-gray-100 dark:bg-gray-600 text-gray-800 dark:text-gray-200 border border-gray-300/50 dark:border-gray-600/50 focus:ring-2 focus:ring-primary transition"
            placeholder="Enter teacher email">
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
          Register Teacher
        </button>
      </form>
    </div>
  </div>

  {{-- Edit Teacher Modal --}}
  <div id="edit-teacher-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
    <div class="bg-white dark:bg-gray-700 rounded-2xl p-6 w-full max-w-md backdrop-blur-lg shadow-xl relative">
      <button id="close-edit-modal"
        class="absolute top-4 right-4 text-gray-500 dark:text-gray-300 hover:text-gray-700 dark:hover:text-gray-100">
        <i class="fas fa-times text-xl"></i>
      </button>
      <h3 class="text-xl font-bold text-gray-800 dark:text-gray-100 mb-4">Edit Teacher</h3>
      <form action="#" method="POST" class="space-y-4">
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
          Update Teacher
        </button>
      </form>
    </div>
  </div>

  {{-- Delete Confirmation Modal --}}
  <div id="delete-teacher-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
    <div class="bg-white dark:bg-gray-700 rounded-2xl p-6 w-full max-w-sm backdrop-blur-lg shadow-xl">
      <h3 class="text-xl font-bold text-gray-800 dark:text-gray-100 mb-4">Confirm Delete</h3>
      <p class="text-gray-600 dark:text-gray-300 mb-6">
        Are you sure you want to delete <span id="delete-teacher-name" class="font-semibold"></span>?
      </p>
      <div class="flex justify-end space-x-4">
        <button id="cancel-delete"
          class="px-4 py-2 bg-gray-300 dark:bg-gray-600 text-gray-800 dark:text-gray-200 rounded-lg hover:bg-gray-400 dark:hover:bg-gray-500 transition">
          Cancel
        </button>
        <button id="confirm-delete"
          class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
          Delete
        </button>
      </div>
    </div>
  </div>


  {{-- Assign Subject Modal --}}
<div id="assign-subject-modal"
    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
    <div class="bg-white dark:bg-gray-700 rounded-2xl p-6 w-full max-w-md shadow-xl relative">
        <button id="close-assign-modal"
            class="absolute top-4 right-4 text-gray-500 dark:text-gray-300 hover:text-gray-700 dark:hover:text-gray-100">
            <i class="fas fa-times text-xl"></i>
        </button>

        <h3 class="text-xl font-bold text-gray-800 dark:text-gray-100 mb-4">
            Assign Subject to <span id="assign-teacher-name" class="font-semibold"></span>
        </h3>

        <div id="remove-subject-section" class="mb-4 hidden">
            <p class="mb-2 text-gray-600 dark:text-gray-300">Current Subject:
                <span id="current-subject-name" class="font-semibold"></span>
            </p>
            <button id="remove-subject-btn" data-pivot-id=""
                class="bg-red-600 text-white px-3 py-1 rounded-lg hover:bg-red-700 text-sm">
                Remove Subject
            </button>
        </div>

        <div class="max-h-80 overflow-y-auto space-y-2">
            @forelse($subjects as $subject)
                <div class="flex items-center justify-between p-3 bg-gray-100 dark:bg-gray-600 rounded-lg">
                    <span class="text-gray-800 dark:text-gray-200">{{ $subject->name }}</span>
                    <button
                        class="assign-subject-btn text-green-500 hover:text-green-700 dark:text-green-400 dark:hover:text-green-300"
                        data-subject-id="{{ $subject->id }}" data-subject-name="{{ $subject->name }}">
                        <i class="fas fa-arrow-right"></i>
                    </button>
                </div>
            @empty
                <p class="text-gray-500 dark:text-gray-400 text-center">No subjects available</p>
            @endforelse
        </div>
    </div>
</div>


  {{-- Teachers Data Table --}}
  <div class="bg-white dark:bg-gray-700 shadow rounded-lg overflow-hidden">
    <table class="min-w-full">
      <thead>
      <tr class="bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-300">
        <th class="px-4 py-3 text-left">Name</th>
        <th class="px-4 py-3 text-left">Email</th>
        <th class="px-4 py-3 text-left">Students</th>
        <th class="px-4 py-3 text-left">Registered</th>
        <th class="px-4 py-3 text-left">Actions</th>
      </tr>
      </thead>
      <tbody>
      @forelse($teachers as $teacher)
        <tr class="border-t border-gray-200 dark:border-gray-600">
        <td class="px-4 py-2">{{ $teacher->name }}</td>
        <td class="px-4 py-2">{{ $teacher->email }}</td>
        <td class="px-4 py-2">{{ $teacher->students_count }}</td>
        <td class="px-4 py-2">{{ $teacher->created_at->format('Y-m-d') }}</td>
        <td class="px-4 py-2 flex space-x-2">
          <button class="assign-subject text-green-500 hover:text-green-700"
    data-teacher-id="{{ $teacher->id }}"
    data-teacher-name="{{ $teacher->name }}"
    @if($teacher->subjectTeacher)
        data-pivot-id="{{ $teacher->subjectTeacher->id }}"
        data-subject-id="{{ $teacher->subjectTeacher->subject_id }}"
        data-subject-name="{{ $teacher->subjectTeacher->subject->name }}"
    @endif
>
    <i class="fas fa-book-open"></i>
</button>
          <button class="edit-teacher text-blue-500 hover:text-blue-700" data-id="{{ $teacher->id }}"
          data-name="{{ $teacher->name }}" data-email="{{ $teacher->email }}">
          <i class="fas fa-edit"></i>
          </button>
          <button class="delete-teacher text-red-500 hover:text-red-700" data-id="{{ $teacher->id }}"
          data-name="{{ $teacher->name }}">
          <i class="fas fa-trash"></i>
          </button>
        </td>
        </tr>
      @empty
        <tr>
        <td colspan="7" class="px-8 py-12 text-center">
          <div class="flex flex-col items-center justify-center space-y-3">
          <i class="fas fa-user-slash text-4xl text-gray-400 dark:text-gray-500"></i>
          <p class="text-gray-500 dark:text-gray-400 text-lg font-medium">No teachers found</p>
          <p class="text-gray-400 dark:text-gray-500 text-sm">Click on "New Teacher" button to add a teacher</p>
          </div>
        </td>
        </tr>
      @endforelse
      </tbody>
    </table>
    
    <div class="px-4 py-3 border-t border-gray-200 dark:border-gray-600">
      {{ $teachers->links('vendor.pagination.tailwind') }}
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', () => {
      // New Teacher Modal
      const openModalBtn = document.getElementById('open-modal');
      const closeModalBtn = document.getElementById('close-modal');
      const newTeacherModal = document.getElementById('teacher-modal');

      openModalBtn.addEventListener('click', () => {
        newTeacherModal.classList.remove('hidden');
      });

      closeModalBtn.addEventListener('click', () => {
        newTeacherModal.classList.add('hidden');
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

      // Edit Teacher Modal
      const editModal = document.getElementById('edit-teacher-modal');
      const closeEditModalBtn = document.getElementById('close-edit-modal');
      const editButtons = document.querySelectorAll('.edit-teacher');

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

      // Delete Teacher Modal
      const deleteModal = document.getElementById('delete-teacher-modal');
      const cancelDeleteBtn = document.getElementById('cancel-delete');
      const confirmDeleteBtn = document.getElementById('confirm-delete');
      const deleteButtons = document.querySelectorAll('.delete-teacher');

      deleteButtons.forEach(button => {
        button.addEventListener('click', () => {
          const id = button.dataset.id;
          const name = button.dataset.name;
          
          document.getElementById('delete-teacher-name').textContent = name;
          confirmDeleteBtn.dataset.teacherId = id;
          deleteModal.classList.remove('hidden');
        });
      });

      cancelDeleteBtn.addEventListener('click', () => {
        deleteModal.classList.add('hidden');
      });


      // Assign Subject Modal
const assignModal = document.getElementById('assign-subject-modal');
const closeAssignBtn = document.getElementById('close-assign-modal');
const assignButtons = document.querySelectorAll('.assign-subject');
const assignSubjectBtns = document.querySelectorAll('.assign-subject-btn');
const removeSection = document.getElementById('remove-subject-section');
const currentNameEl = document.getElementById('current-subject-name');
const removeBtn = document.getElementById('remove-subject-btn');
const teacherNameEl = document.getElementById('assign-teacher-name');

// Open modal, populate data
assignButtons.forEach(btn => {
    btn.addEventListener('click', () => {
        const teacherId = btn.dataset.teacherId;
        const teacherName = btn.dataset.teacherName;
        const pivotId = btn.dataset.pivotId;
        const subjectName = btn.dataset.subjectName;

        teacherNameEl.textContent = teacherName;

        // If already assigned, show remove section
        if (pivotId) {
            removeSection.classList.remove('hidden');
            currentNameEl.textContent = subjectName;
            removeBtn.dataset.pivotId = pivotId;
        } else {
            removeSection.classList.add('hidden');
        }

        // stash teacherId on each "assign-subject-btn"
        assignSubjectBtns.forEach(a => {
            a.dataset.teacherId = teacherId;
        });

        assignModal.classList.remove('hidden');
    });
});

// Close modal
closeAssignBtn.addEventListener('click', () => {
    assignModal.classList.add('hidden');
});

// Assign a new subject
assignSubjectBtns.forEach(btn => {
    btn.addEventListener('click', async () => {
        const teacherId = btn.dataset.teacherId;
        const subjectId = btn.dataset.subjectId;
        try {
            const res = await fetch('{{ route('admin.teacher.assign-subject') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    teacher_id: teacherId,
                    subject_id: subjectId
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

// Remove current subject (by pivot id)
removeBtn.addEventListener('click', async () => {
    const pivotId = removeBtn.dataset.pivotId;
    try {
        const res = await fetch('{{ route('admin.teacher.remove-subject') }}', {
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
            setTimeout(() => location.reload(), 2000);
        } else {
            showToast('error', data.message);
        }
    } catch (err) {
        showToast('error', 'Could not remove subject. Try again.');
    }
});

// Close modal on outside click
window.addEventListener('click', (e) => {
    if (e.target === assignModal) assignModal.classList.add('hidden');
});


      // Close modals when clicking outside
      window.addEventListener('click', (e) => {
        if (e.target === newTeacherModal) newTeacherModal.classList.add('hidden');
        if (e.target === editModal) editModal.classList.add('hidden');
        if (e.target === deleteModal) deleteModal.classList.add('hidden');
      });
    });
  </script>
@endsection
