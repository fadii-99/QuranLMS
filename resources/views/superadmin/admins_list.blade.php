{{-- resources/views/superadmin/admins_list.blade.php --}}
@extends('layouts.superadmin')

@section('title', 'Admins List')

@section('content')
    <div class="flex items-center justify-between mb-8 bg-white dark:bg-gray-700 shadow-lg rounded-xl p-4"
        data-aos="fade-down">
        <h1 class="text-3xl font-extrabold text-gray-800 dark:text-gray-100 tracking-tight">Admins</h1>
    </div>
    <div class="flex justify-between items-center mb-6">
        <h2></h2>
        <button id="open-modal"
            class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition flex items-center">
            <i class="fas fa-user-plus mr-2"></i> New Admin
        </button>
    </div>

    {{-- New Admin Modal --}}
    <div id="admin-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="bg-white dark:bg-gray-700 rounded-2xl p-6 w-full max-w-md backdrop-blur-lg shadow-xl relative">
            <button id="close-modal"
                class="absolute top-4 right-4 text-gray-500 dark:text-gray-300 hover:text-gray-700 dark:hover:text-gray-100">
                <i class="fas fa-times text-xl"></i>
            </button>
            <h3 class="text-xl font-bold text-gray-800 dark:text-gray-100 mb-4">Register New Admin</h3>
            <form action="{{ route('superadmin.admin.create') }}" method="POST" enctype="multipart/form-data"
                class="space-y-4">
                @csrf
                <div>
                    <label for="name" class="block text-sm text-gray-600 dark:text-gray-300 mb-1">Name</label>
                    <input id="name" name="name" type="text" required
                        class="w-full px-4 py-2 rounded-lg bg-gray-100 dark:bg-gray-600 text-gray-800 dark:text-gray-200 border border-gray-300/50 dark:border-gray-600/50 focus:ring-2 focus:ring-primary transition"
                        placeholder="Enter admin name">
                </div>
                <div>
                    <label for="email" class="block text-sm text-gray-600 dark:text-gray-300 mb-1">Email</label>
                    <input id="email" name="email" type="email" required
                        class="w-full px-4 py-2 rounded-lg bg-gray-100 dark:bg-gray-600 text-gray-800 dark:text-gray-200 border border-gray-300/50 dark:border-gray-600/50 focus:ring-2 focus:ring-primary transition"
                        placeholder="Enter admin email">
                </div>
                <div class="relative">
                    <label for="password" class="block text-sm text-gray-600 dark:text-gray-300 mb-1">
                        Password
                    </label>
                    <input id="password" name="password" type="password" required
                        class="w-full pr-10 px-4 py-2 rounded-lg bg-gray-100 dark:bg-gray-600 text-gray-800 dark:text-gray-200 border border-gray-300/50 dark:border-gray-600/50 focus:ring-2 focus:ring-primary transition"
                        placeholder="Create a password" />
                    <button type="button" id="togglePassword"
                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500 dark:text-gray-400"
                        aria-label="Show or hide password">
                        <i class="fas fa-eye absolute right-4 top-2/3 -translate-y-1/2" id="eyeIcon"></i>
                    </button>
                </div>
                <script>
                    document.addEventListener('DOMContentLoaded', () => {
                        const pwdInput = document.getElementById('password');
                        const toggleBtn = document.getElementById('togglePassword');
                        const eyeIcon = document.getElementById('eyeIcon');

                        toggleBtn.addEventListener('click', () => {
                            const isHidden = pwdInput.getAttribute('type') === 'password';
                            pwdInput.setAttribute('type', isHidden ? 'text' : 'password');
                            eyeIcon.classList.toggle('fa-eye', !isHidden);
                            eyeIcon.classList.toggle('fa-eye-slash', isHidden);
                        });
                    });
                </script>


                <div>
                    <label for="academy_name" class="block text-sm text-gray-600 dark:text-gray-300 mb-1">Academy
                        Name</label>
                    <input id="academy_name" name="academy_name" type="text" required
                        class="w-full px-4 py-2 rounded-lg bg-gray-100 dark:bg-gray-600 text-gray-800 dark:text-gray-200 border border-gray-300/50 dark:border-gray-600/50 focus:ring-2 focus:ring-primary transition"
                        placeholder="Enter academy name">
                </div>
                <button type="submit"
                    class="w-full bg-primary text-white py-2 rounded-lg hover:bg-primary-dark transition">
                    Register Admin
                </button>
            </form>
        </div>
    </div>

    {{-- Edit Admin Modal --}}
    <div id="edit-admin-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="bg-white dark:bg-gray-700 rounded-2xl p-6 w-full max-w-md backdrop-blur-lg shadow-xl relative">
            <button id="close-edit-modal"
                class="absolute top-4 right-4 text-gray-500 dark:text-gray-300 hover:text-gray-700 dark:hover:text-gray-100">
                <i class="fas fa-times text-xl"></i>
            </button>
            <h3 class="text-xl font-bold text-gray-800 dark:text-gray-100 mb-4">Edit Admin</h3>
            <form action="#" method="POST" class="space-y-4">
                @csrf
                @method('PUT')
                <input type="hidden" id="edit-id" name="id">
                <div>
                    <label for="edit-name" class="block text-sm text-gray-600 dark:text-gray-300 mb-1">Name</label>
                    <input id="edit-name" name="name" type="text" required
                        class="w-full px-4 py-2 rounded-lg bg-gray-100 dark:bg-gray-600 text-gray-800 dark:text-gray-200 border border-gray-300/50 dark:border-gray-600/50 focus:ring-2 focus:ring-primary transition"
                        placeholder="Enter admin name">
                </div>
                <div>
                    <label for="edit-email" class="block text-sm text-gray-600 dark:text-gray-300 mb-1">Email</label>
                    <input id="edit-email" name="email" type="email" required
                        class="w-full px-4 py-2 rounded-lg bg-gray-100 dark:bg-gray-600 text-gray-800 dark:text-gray-200 border border-gray-300/50 dark:border-gray-600/50 focus:ring-2 focus:ring-primary transition"
                        placeholder="Enter admin email">
                </div>
                <div>
                    <label for="edit-academy_name" class="block text-sm text-gray-600 dark:text-gray-300 mb-1">Academy
                        Name</label>
                    <input id="edit-academy_name" name="academy_name" type="text" required
                        class="w-full px-4 py-2 rounded-lg bg-gray-100 dark:bg-gray-600 text-gray-800 dark:text-gray-200 border border-gray-300/50 dark:border-gray-600/50 focus:ring-2 focus:ring-primary transition"
                        placeholder="Enter academy name">
                </div>
                <div class="grid grid-cols-2 gap-4 p-3 bg-gray-50 dark:bg-gray-600 rounded-lg">
                  <div class="flex items-center space-x-3">
                    <input type="checkbox" id="edit-is_paid" name="is_paid"
                      class="w-4 h-4 rounded text-primary focus:ring-primary focus:ring-offset-2 transition-all duration-200">
                    <label for="edit-is_paid" class="text-sm font-medium text-gray-700 dark:text-gray-200">
                      <i class="fas fa-money-bill-wave mr-1"></i> Paid Status
                    </label>
                  </div>
                  <div class="flex items-center space-x-3">
                    <input type="checkbox" id="edit-is_blocked" name="is_blocked"
                      class="w-4 h-4 rounded text-primary focus:ring-primary focus:ring-offset-2 transition-all duration-200">
                    <label for="edit-is_blocked" class="text-sm font-medium text-gray-700 dark:text-gray-200">
                      <i class="fas fa-ban mr-1"></i> Blocked Status
                    </label>
                  </div>
                </div>
                <button type="submit"
                    class="w-full bg-primary text-white py-2 rounded-lg hover:bg-primary-dark transition">
                    Update Admin
                </button>
            </form>
        </div>
    </div>


    {{-- Delete Confirmation Modal --}}
    <div id="delete-admin-modal"
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="bg-white dark:bg-gray-700 rounded-2xl p-6 w-full max-w-sm backdrop-blur-lg shadow-xl">
            <h3 class="text-xl font-bold text-gray-800 dark:text-gray-100 mb-4">Confirm Delete</h3>
            <p class="text-gray-600 dark:text-gray-300 mb-6">
                Are you sure you want to delete <span id="delete-admin-name" class="font-semibold"></span>?
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


    {{-- Admins Data Table --}}
    <div class="bg-white dark:bg-gray-700 shadow rounded-lg overflow-hidden">
        <table class="min-w-full">
            <thead>
                <tr class="bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-300">
                    <th class="px-4 py-3 text-left">Name</th>
                    <th class="px-4 py-3 text-left">Email</th>
                    <th class="px-4 py-3 text-left">Academy</th>
                    <th class="px-4 py-3 text-left">Teachers</th>
                    <th class="px-4 py-3 text-left">Students</th>
                    <th class="px-4 py-3 text-left">Registered</th>
                    <th class="px-4 py-3 text-left">Status</th>
                    <th class="px-4 py-3 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($admins as $admin)
                    <tr class="border-t border-gray-200 dark:border-gray-600">
                        <td class="px-4 py-2">{{ $admin->name }}</td>
                        <td class="px-4 py-2">{{ $admin->email }}</td>
                        <td class="px-4 py-2">{{ $admin->academy_name ?? '—' }}</td>
                        <td class="px-4 py-2">{{ $admin->teachers_count }}</td>
                        <td class="px-4 py-2">{{ $admin->students_count }}</td>
                        <td class="px-4 py-2">
                            {{ $admin->created_at->format('Y-m-d') }}
                        </td>
                        <td class="px-4 py-2">
                            <button
                                class="toggle-status text-sm px-3 py-1 rounded-full {{ $admin->is_paid == true ? 'bg-green-500 text-white' : 'bg-red-500 text-white' }}"
                                data-id="{{ $admin->id }}" data-status="{{ $admin->status }}">
                                {{ $admin->is_paid == true ? 'Paid' : 'Not Paid' }}
                            </button>
                        </td>
                        <td class="px-4 py-2 flex space-x-2">
                            <button class="edit-admin text-blue-500 hover:text-blue-700" data-id="{{ $admin->id }}"
                                data-name="{{ $admin->name }}" data-email="{{ $admin->email }}"
                                data-academy="{{ $admin->academy_name }}" data-paid="{{ $admin->is_paid ? '1' : '0' }}"
                                data-blocked="{{ $admin->is_blocked ? '1' : '0' }}">
                                <i class="fas fa-edit"></i>
                            </button>

                            <button class="delete-admin text-red-500 hover:text-red-700" data-id="{{ $admin->id }}"
                                data-name="{{ $admin->name }}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-4 py-4 text-center text-gray-500 dark:text-gray-400">
                            No admins found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // New Admin Modal
            const openModalBtn = document.getElementById('open-modal');
            const closeModalBtn = document.getElementById('close-modal');
            const newAdminModal = document.getElementById('admin-modal');

            openModalBtn.addEventListener('click', () => {
                newAdminModal.classList.remove('hidden');
            });

            closeModalBtn.addEventListener('click', () => {
                newAdminModal.classList.add('hidden');
            });

            newAdminModal.addEventListener('click', (e) => {
                if (e.target === newAdminModal) {
                    newAdminModal.classList.add('hidden');
                }
            });

            // Edit Admin Modal
            const editModal = document.getElementById('edit-admin-modal');
            const closeEditModalBtn = document.getElementById('close-edit-modal');
            const editButtons = document.querySelectorAll('.edit-admin');

            // Inside your DOMContentLoaded handler, in the editButtons.forEach(...)
            editButtons.forEach(button => {
                button.addEventListener('click', () => {
                    const id = button.dataset.id;
                    const name = button.dataset.name;
                    const email = button.dataset.email;
                    const academy = button.dataset.academy;
                    const isPaid = button.dataset.paid === '1';
                    const isBlocked = button.dataset.blocked === '1';

                    document.getElementById('edit-id').value = id;
                    document.getElementById('edit-name').value = name;
                    document.getElementById('edit-email').value = email;
                    document.getElementById('edit-academy_name').value = academy;

                    // PRE-CHECK THE BOXES:
                    document.getElementById('edit-is_paid').checked = isPaid;
                    document.getElementById('edit-is_blocked').checked = isBlocked;

                    editModal.classList.remove('hidden');
                });
            });


            closeEditModalBtn.addEventListener('click', () => {
                editModal.classList.add('hidden');
            });

            editModal.addEventListener('click', (e) => {
                if (e.target === editModal) {
                    editModal.classList.add('hidden');
                }
            });

            // Delete Confirmation Modal
            const deleteModal = document.getElementById('delete-admin-modal');
            const cancelDeleteBtn = document.getElementById('cancel-delete');
            const confirmDeleteBtn = document.getElementById('confirm-delete');
            const deleteButtons = document.querySelectorAll('.delete-admin');

            deleteButtons.forEach(button => {
                button.addEventListener('click', () => {
                    const id = button.dataset.id;
                    const name = button.dataset.name;

                    document.getElementById('delete-admin-name').textContent = name;
                    confirmDeleteBtn.dataset.id = id;

                    deleteModal.classList.remove('hidden');
                });
            });

            cancelDeleteBtn.addEventListener('click', () => {
                deleteModal.classList.add('hidden');
            });

            confirmDeleteBtn.addEventListener('click', () => {
                const id = confirmDeleteBtn.dataset.id;
                console.log(`Deleted admin with ID: ${id}`);
                deleteModal.classList.add('hidden');
            });

            deleteModal.addEventListener('click', (e) => {
                if (e.target === deleteModal) {
                    deleteModal.classList.add('hidden');
                }
            });

            // Status Toggle
            // document.querySelectorAll('.toggle-status').forEach(button => {
            //   button.addEventListener('click', () => {
            //     const id = button.dataset.id;
            //     const currentStatus = button.dataset.status;
            //     const newStatus = currentStatus === 'Active' ? 'Deactive' : 'Active';

            //     button.dataset.status = newStatus;
            //     button.textContent = newStatus;
            //     button.classList.toggle('bg-green-500', newStatus === 'Active');
            //     button.classList.toggle('bg-red-500', newStatus === 'Deactive');

            //     console.log(`Toggled admin ${id} to ${newStatus}`);
            //   });
            // });
        });
    </script>
@endsection
