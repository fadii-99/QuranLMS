@extends('layouts.admin')

@section('title', 'Subject List')

@section('content')
    <div class="mb-8 bg-white dark:bg-gray-700 shadow-lg rounded-xl p-4">
        <h1 class="text-3xl font-extrabold text-gray-800 dark:text-gray-100 tracking-tight">Subjects</h1>
    </div>
    <div class="flex justify-between items-center mb-6">
        <h2></h2>
        <button id="open-modal"
            class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition flex items-center">
            <i class="fas fa-plus mr-2"></i> New Subject
        </button>
    </div>

    {{-- New Subject Modal --}}
    <div id="subject-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="bg-white dark:bg-gray-700 rounded-2xl p-6 w-full max-w-md backdrop-blur-lg shadow-xl relative">
            <button id="close-modal"
                class="absolute top-4 right-4 text-gray-500 dark:text-gray-300 hover:text-gray-700 dark:hover:text-gray-100">
                <i class="fas fa-times text-xl"></i>
            </button>
            <h3 class="text-xl font-bold text-gray-800 dark:text-gray-100 mb-4">Add New Subject</h3>
            <form action="{{ route('admin.subject.create') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label for="name" class="block text-sm text-gray-600 dark:text-gray-300 mb-1">Subject Name</label>
                    <input id="name" name="name" type="text" required
                        class="w-full px-4 py-2 rounded-lg bg-gray-100 dark:bg-gray-600 text-gray-800 dark:text-gray-200 border border-gray-300/50 dark:border-gray-600/50 focus:ring-2 focus:ring-primary transition"
                        placeholder="Enter subject name">
                </div>
                <div class="flex items-center">
                    <input type="checkbox" id="is_active" name="is_active" class="mr-2" checked>
                    <label for="is_active" class="text-sm text-gray-600 dark:text-gray-300">Active</label>
                </div>
                <button type="submit"
                    class="w-full bg-primary text-white py-2 rounded-lg hover:bg-primary-dark transition">
                    Add Subject
                </button>
            </form>
        </div>
    </div>

    {{-- Edit Subject Modal --}}
    <div id="edit-subject-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="bg-white dark:bg-gray-700 rounded-2xl p-6 w-full max-w-md backdrop-blur-lg shadow-xl relative">
            <button id="close-edit-modal"
                class="absolute top-4 right-4 text-gray-500 dark:text-gray-300 hover:text-gray-700 dark:hover:text-gray-100">
                <i class="fas fa-times text-xl"></i>
            </button>
            <h3 class="text-xl font-bold text-gray-800 dark:text-gray-100 mb-4">Edit Subject</h3>
            <form id="edit-subject-form" action="{{ route('admin.subject.update') }}" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" id="edit-id" name="id">
                <div>
                    <label for="edit-name" class="block text-sm text-gray-600 dark:text-gray-300 mb-1">Subject Name</label>
                    <input id="edit-name" name="name" type="text" required
                        class="w-full px-4 py-2 rounded-lg bg-gray-100 dark:bg-gray-600 text-gray-800 dark:text-gray-200 border border-gray-300/50 dark:border-gray-600/50 focus:ring-2 focus:ring-primary transition">
                </div>
                <div class="flex items-center">
                    <input type="checkbox" id="edit-is-active" name="is_active" class="mr-2">
                    <label for="edit-is-active" class="text-sm text-gray-600 dark:text-gray-300">Active</label>
                </div>
                <button type="submit"
                    class="w-full bg-primary text-white py-2 rounded-lg hover:bg-primary-dark transition">
                    Update Subject
                </button>
            </form>
        </div>
    </div>

    {{-- Delete Confirmation Modal --}}
    <div id="delete-subject-modal"
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="bg-white dark:bg-gray-700 rounded-2xl p-6 w-full max-w-sm backdrop-blur-lg shadow-xl">
            <h3 class="text-xl font-bold text-gray-800 dark:text-gray-100 mb-4">Confirm Delete</h3>
            <p class="text-gray-600 dark:text-gray-300 mb-6">
                Are you sure you want to delete <span id="delete-subject-name" class="font-semibold"></span>?
            </p>
            <div class="flex justify-end space-x-4">
                <button id="cancel-delete"
                    class="px-4 py-2 bg-gray-300 dark:bg-gray-600 text-gray-800 dark:text-gray-200 rounded-lg hover:bg-gray-400 dark:hover:bg-gray-500 transition">
                    Cancel
                </button>
                <button id="confirm-delete" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition"
                    data-subject-id="">
                    Delete
                </button>
            </div>
        </div>
    </div>

    {{-- Subjects Data Table --}}
    <div class="bg-white dark:bg-gray-700 shadow rounded-lg overflow-hidden overflow-x-auto">
        <table class="min-w-full">
            <thead>
                <tr class="bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-300">
                    <th class="px-4 py-3 text-left">Name</th>
                    <th class="px-4 py-3 text-left">Status</th>
                    <th class="px-4 py-3 text-left">Created At</th>
                    <th class="px-4 py-3 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($subjects as $subject)
                    <tr class="border-t border-gray-200 dark:border-gray-600">
                        <td class="px-4 py-2">{{ $subject->name }}</td>
                        <td class="px-4 py-2">
                            <span
                                class="px-3 py-1 rounded-full text-sm {{ $subject->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $subject->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="px-4 py-2">{{ $subject->created_at->format('Y-m-d') }}</td>
                        <td class="px-4 py-2 flex space-x-2">
                            <button class="edit-subject text-blue-500 hover:text-blue-700" data-id="{{ $subject->id }}"
                                data-name="{{ $subject->name }}" data-active="{{ $subject->is_active }}">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="delete-subject text-red-500 hover:text-red-700" data-id="{{ $subject->id }}"
                                data-name="{{ $subject->name }}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-8 py-12 text-center">
                            <div class="flex flex-col items-center justify-center space-y-3">
                                <i class="fas fa-book text-4xl text-gray-400 dark:text-gray-500"></i>
                                <p class="text-gray-500 dark:text-gray-400 text-lg font-medium">No subjects found</p>
                                <p class="text-gray-400 dark:text-gray-500 text-sm">Click on "New Subject" button to add a
                                    subject</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="px-4 py-3 border-t border-gray-200 dark:border-gray-600">
            {{ $subjects->links() }}
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Modal logic
            const openModalBtn = document.getElementById('open-modal');
            const closeModalBtn = document.getElementById('close-modal');
            const newSubjectModal = document.getElementById('subject-modal');

            openModalBtn.addEventListener('click', () => {
                newSubjectModal.classList.remove('hidden');
            });
            closeModalBtn.addEventListener('click', () => {
                newSubjectModal.classList.add('hidden');
            });

            // Edit Subject Modal
            const editModal = document.getElementById('edit-subject-modal');
            const closeEditModalBtn = document.getElementById('close-edit-modal');
            const editButtons = document.querySelectorAll('.edit-subject');
            const editForm = document.getElementById('edit-subject-form');

            editButtons.forEach(button => {
                button.addEventListener('click', () => {
                    const id = button.dataset.id;
                    const name = button.dataset.name;
                    const isActive = button.dataset.active === "1" ? true : false;

                    document.getElementById('edit-id').value = id;
                    document.getElementById('edit-name').value = name;
                    document.getElementById('edit-is-active').checked = isActive;

                    // Set form action
                    editForm.action = "{{ route('admin.subject.update') }}";

                    editModal.classList.remove('hidden');
                });
            });

            closeEditModalBtn.addEventListener('click', () => {
                editModal.classList.add('hidden');
            });

            // Delete Subject Modal
            const deleteModal = document.getElementById('delete-subject-modal');
            const cancelDeleteBtn = document.getElementById('cancel-delete');
            const confirmDeleteBtn = document.getElementById('confirm-delete');
            const csrfToken = '{{ csrf_token() }}';

            document.querySelectorAll('.delete-subject').forEach(btn => {
                btn.addEventListener('click', () => {
                    const id = btn.dataset.id;
                    const name = btn.dataset.name;
                    document.getElementById('delete-subject-name').textContent = name;
                    confirmDeleteBtn.dataset.subjectId = id;
                    deleteModal.classList.remove('hidden');
                });
            });

            // Cancel delete
            cancelDeleteBtn.addEventListener('click', () => {
                deleteModal.classList.add('hidden');
            });

            // Confirm delete via AJAX
            confirmDeleteBtn.addEventListener('click', async () => {
                const subjectId = confirmDeleteBtn.dataset.subjectId;

                try {
                    const res = await fetch('{{ route('admin.subject.delete') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify({
                            subject_id: subjectId
                        })
                    });

                    const data = await res.json();

                    if (data.success) {
                        showToast('success', 'Subject deleted successfully');
                        deleteModal.classList.add('hidden');
                        setTimeout(() => location.reload(), 2000);
                    } else {
                        showToast('error', 'Failed to delete subject');
                    }
                } catch (err) {
                    showToast('error', 'Could not delete subject. Please try again.');
                }
            });

            // Close modals when clicking outside
            window.addEventListener('click', (e) => {
                if (e.target === newSubjectModal) newSubjectModal.classList.add('hidden');
                if (e.target === editModal) editModal.classList.add('hidden');
                if (e.target === deleteModal) deleteModal.classList.add('hidden');
            });
        });
    </script>
@endsection
