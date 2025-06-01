@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
    <div class="flex items-center justify-between mb-8">
        <h1 class="text-3xl font-extrabold text-gray-900 dark:text-gray-100">
            {{ $user->academy_name }} Dashboard
        </h1>
        <span class="text-sm text-gray-500 dark:text-gray-400">
            Welcome back, {{ auth()->user()->name }}
        </span>
    </div>

    {{-- Overview Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
        @php
            $cards = [
                [
                    'label' => 'Teachers',
                    'count' => $teachers,
                    'icon' => 'fas fa-chalkboard-teacher',
                    'bg' => 'from-green-500 to-green-600',
                ],
                [
                    'label' => 'Students',
                    'count' => $students,
                    'icon' => 'fas fa-user-graduate',
                    'bg' => 'from-yellow-500 to-yellow-600',
                ],
                [
                    'label' => 'Requests',
                    'count' => $requests->count(),
                    'icon' => 'fas fa-question-circle',
                    'bg' => 'from-red-500 to-red-600',
                ],
            ];
        @endphp

        @foreach ($cards as $c)
            <div class="group block rounded-2xl overflow-hidden shadow-lg transform hover:-translate-y-1 transition shrink-0">
                <div class="h-2 bg-gradient-to-r {{ $c['bg'] }} shrink-0"></div>
                <div class="bg-white dark:bg-gray-800 p-6 flex items-center space-x-4 shrink-0">
                    <div class="p-3 rounded-full bg-gradient-to-br {{ $c['bg'] }} text-white shrink-0">
                        <i class="{{ $c['icon'] }} text-xl shrink-0"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase">{{ $c['label'] }}</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $c['count'] }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- Pending Requests Table --}}
    <div class="bg-white dark:bg-gray-800 shadow rounded-xl overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-600">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100">
                Pending Teacher Requests
            </h2>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-4 py-3 text-left">Sender</th>
                        <th class="px-4 py-3 text-left">Subject</th>
                        <th class="px-4 py-3 text-left">Message</th>
                        <th class="px-4 py-3 text-left">Status</th>
                        <th class="px-6 py-3 text-left">Action</th>
                    </tr>
                </thead>
                <tbody>

                    @forelse($requests as $item)
                        <tr class="border-t border-gray-200 dark:border-gray-600">
                            <td class="px-4 py-2 whitespace-nowrap w-1/6">{{ $item->user->name }} <span
                                    class="text-sm">({{ $item->user->role }})</span></td>
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
                                <a href="{{ route('admin.request.index', ['view_id' => $item->id]) }}"
                                    class="inline-flex items-center px-3 py-1.5 bg-blue-600 text-white text-xs font-semibold rounded hover:bg-blue-700 transition">
                                    Go to Message
                                    <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                    </svg>
                                </a>

                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center">
                                <div class="flex flex-col items-center justify-center space-y-2">
                                    <svg class="w-10 h-10 text-gray-300 dark:text-gray-600 mb-2" fill="none"
                                        stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M12 8v4m0 4h.01M21 12c0 4.97-4.03 9-9 9s-9-4.03-9-9 4.03-9 9-9 9 4.03 9 9z" />
                                    </svg>
                                    <span class="text-gray-500 dark:text-gray-400 text-lg font-medium">No pending
                                        requests.</span>
                                    <span class="text-gray-400 dark:text-gray-500 text-sm">All teacher requests have been
                                        reviewed.</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
