{{-- resources/views/admin/students_list.blade.php --}}
@extends('layouts.admin')

@section('title', 'Request Complains')

@section('content')
    <div class="mb-8 bg-white dark:bg-gray-700 shadow-lg rounded-xl p-4">
        <h1 class="text-3xl font-bold text-gray-800 text-white">Messages</h1>
    </div>


    <!-- Cancel Confirmation Modal -->
    <!-- Cancel Modal -->
    <div id="cancel-modal" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50 hidden">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg w-full max-w-md p-6 relative">
            <button id="cancel-modal-close" class="absolute top-2 right-4 text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 text-lg">&times;</button>
            <h2 class="text-xl font-bold mb-2 text-gray-800 dark:text-white">Cancel Request</h2>
            <p class="mb-4 text-gray-600 dark:text-gray-300">Are you sure you want to cancel this request?</p>
            <div class="flex justify-end space-x-4">
                <button id="cancel-modal-confirm" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition duration-200">Yes, Cancel</button>
                <button id="cancel-modal-cancel" class="px-4 py-2 bg-gray-200 dark:bg-gray-600 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-500 transition duration-200">No</button>
            </div>
        </div>
    </div>

    <!-- View Modal -->
    <div id="view-modal" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50 hidden">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg w-full max-w-md p-6 relative">
            <button id="view-modal-close" class="absolute top-2 right-4 text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 text-lg">&times;</button>
            <h2 class="text-xl font-bold mb-3 text-gray-800 dark:text-white">Request Details</h2>
            <div id="view-modal-content" class="text-gray-600 dark:text-gray-300">
                <!-- Will be filled by JS -->
            </div>
        </div>
    </div>



    <div class="bg-white dark:bg-gray-700 shadow rounded-lg overflow-hidden overflow-x-auto">
        <table class="min-w-full">
            <thead>
                <tr class="bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-300">
                    <th class="px-4 py-3 text-left">Sender</th>
                    <th class="px-4 py-3 text-left">Subject</th>
                    <th class="px-4 py-3 text-left">Message</th>
                    <th class="px-4 py-3 text-left">Status</th>
                    <th class="px-6 py-3 text-left">Action</th>

                </tr>
            </thead>
            <tbody>
                @forelse($data as $item)
                    <tr class="border-t border-gray-200 dark:border-gray-600">
                        <td class="px-4 py-2 whitespace-nowrap w-1/6">{{ $item->user->name }} <span class="text-sm">({{ $item->user->role }})</span></td>
                        <td class="px-4 py-2 whitespace-nowrap w-1/6">{{ $item->subject }}</td>
                        <td class="px-4 py-2 w-2/6">
                            <div class="truncate max-w-md">{{ $item->message }}</div>
                        </td>
                        <td class="px-4 py-2 whitespace-nowrap w-1/6">
                            <span
                                class="px-2 py-1 rounded-full text-xs font-medium
                                {{ $item->status == 'pending' ? 'bg-yellow-200 text-yellow-800' : '' }}
                                {{ $item->status == 'completed' ? 'bg-green-200 text-green-800' : '' }}
                                {{ $item->status == 'canceled' ? 'bg-red-200 text-red-800' : '' }}
                                ">
                                {{ ucfirst($item->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 space-x-2 whitespace-nowrap w-1/6">
                            @if ($item->status == 'pending')
                                <button onclick="completeRequest({{ $item->id }})"
                                    class="inline-flex items-center px-3 py-1 bg-green-600 rounded-md text-xs text-white hover:bg-green-700">
                                    <i class="fas fa-check mr-2"></i>
                                    Complete
                                </button>
                                <button onclick="showCancelModal({{ $item->id }})"
                                    class="inline-flex items-center px-3 py-1 bg-red-600 rounded-md text-xs text-white hover:bg-red-700">
                                    <i class="fas fa-times mr-2"></i>
                                    Cancel
                                </button>
                            @endif
                            <button onclick="viewRequest({{ $item->id }})"
                                class="inline-flex items-center px-3 py-1 bg-blue-600 rounded-md text-xs text-white hover:bg-blue-700">
                                <i class="fas fa-eye mr-2"></i>
                                View
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-8 py-12 text-center">
                            <div class="flex flex-col items-center justify-center space-y-3">
                                <i class="fas fa-warning text-4xl text-gray-400 dark:text-gray-500"></i>
                                <p class="text-gray-500 dark:text-gray-400 text-lg font-medium">No Messages found</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="px-4 py-3 border-t border-gray-200 dark:border-gray-600">
            {{ $data->links() }}
        </div>
    </div>

    <script>
    // ---- Complete Request ----
    function completeRequest(id) {
        fetch('{{ url("admin/request") }}/' + id + '/complete', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
            }
        })
        .then(res => res.json())
        .then(data => {
            if(data.success){ location.reload(); }
            else { alert(data.message); }
        });
    }

    // ---- Cancel Request ----
    let cancelId = null;
    function showCancelModal(id){
        cancelId = id;
        document.getElementById('cancel-modal').classList.remove('hidden');
    }
    document.getElementById('cancel-modal-close').onclick = 
    document.getElementById('cancel-modal-cancel').onclick = function(){
        document.getElementById('cancel-modal').classList.add('hidden');
        cancelId = null;
    }
    document.getElementById('cancel-modal-confirm').onclick = function(){
        fetch('{{ url("admin/request") }}/' + cancelId + '/cancel', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
            }
        })
        .then(res => res.json())
        .then(data => {
            document.getElementById('cancel-modal').classList.add('hidden');
            cancelId = null;
            if(data.success){ location.reload(); }
            else { alert(data.message); }
        });
    };

    // ---- View Request ----
    function viewRequest(id){
        fetch('{{ url("admin/request") }}/' + id + '/view', {
            method: 'GET',
            headers: { 'Accept': 'application/json' }
        })
        .then(res => res.json())
        .then(data => {
            if(data.success){
                let item = data.data;
                let html = `
                    <div class="space-y-6 p-6 bg-gray-50 dark:bg-gray-700 rounded-lg max-h-[70vh] overflow-y-auto">
                        <div class="flex flex-col md:flex-row md:items-center gap-4">
                            <span class="text-gray-600 dark:text-gray-300 font-semibold min-w-[120px]">Sender:</span>
                            <span class="text-gray-800 dark:text-gray-100 flex items-center flex-wrap gap-2">
                                ${item.user.name} 
                                <span class="px-3 py-1 text-sm bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 rounded-full">${item.user.role}</span>
                            </span>
                        </div>
                        <div class="flex flex-col md:flex-row md:items-center gap-4">
                            <span class="text-gray-600 dark:text-gray-300 font-semibold min-w-[120px]">Subject:</span>
                            <span class="text-gray-800 dark:text-gray-100">${item.subject}</span>
                        </div>
                        <div class="flex flex-col md:flex-row gap-4">
                            <span class="text-gray-600 dark:text-gray-300 font-semibold min-w-[120px]">Message:</span>
                            <p class="text-gray-800 dark:text-gray-100 flex-1 whitespace-pre-wrap">${item.message}</p>
                        </div>
                        <div class="flex flex-col md:flex-row md:items-center gap-4">
                            <span class="text-gray-600 dark:text-gray-300 font-semibold min-w-[120px]">Status:</span>
                            <span class="px-4 py-2 rounded-full inline-block text-sm ${
                                item.status === 'pending' ? 'bg-yellow-100 text-yellow-800' :
                                item.status === 'completed' ? 'bg-green-100 text-green-800' :
                                'bg-red-100 text-red-800'
                            }">${item.status.charAt(0).toUpperCase() + item.status.slice(1)}</span>
                        </div>
                        <div class="flex flex-col md:flex-row md:items-center gap-4">
                            <span class="text-gray-600 dark:text-gray-300 font-semibold min-w-[120px]">Created:</span>
                            <span class="text-gray-800 dark:text-gray-100">${new Date(item.created_at).toLocaleDateString('en-US', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit' })}</span>
                        </div>
                    </div>
                `;
                document.getElementById('view-modal-content').innerHTML = html;
                document.getElementById('view-modal').classList.remove('hidden');
            } else {
                alert('Not found');
            }
        });
    }
    document.getElementById('view-modal-close').onclick = function(){
        document.getElementById('view-modal').classList.add('hidden');
    }

    // Close modal when clicking outside
    document.getElementById('view-modal').onclick = function(e){
        if (e.target === this) {
            document.getElementById('view-modal').classList.add('hidden');
        }
    }
</script>
@if($viewId)
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Wait for DOM, then call your viewRequest JS function
        viewRequest({{ $viewId }});
    });
</script>
@endif

@endsection
