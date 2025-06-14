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

    {{-- Payment Status Alert --}}
    @if (!auth()->user()->is_paid)
        <div class="mb-6 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl p-6">
            <div class="flex items-start space-x-4">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-triangle text-red-500 text-2xl"></i>
                </div>
                <div class="flex-1">
                    <h3 class="text-lg font-semibold text-red-800 dark:text-red-200">Payment Required</h3>
                    <p class="text-red-700 dark:text-red-300 mt-1">
                        Your account payment is pending. Please complete your payment to continue using all features.
                    </p>
                    @php
                        $pendingPayment = App\Models\Payment::where('admin_id', auth()->id())
                            ->where('status', 'pending')
                            ->latest()
                            ->first();
                    @endphp
                    @if ($pendingPayment)
                        <div class="mt-4 p-4 bg-white dark:bg-gray-800 rounded-lg border">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                                <div>
                                    <span class="font-medium text-gray-600 dark:text-gray-400">Amount:</span>
                                    <span
                                        class="text-gray-900 dark:text-gray-100">${{ number_format($pendingPayment->amount, 2) }}</span>
                                </div>
                                <div>
                                    <span class="font-medium text-gray-600 dark:text-gray-400">For Month:</span>
                                    <span
                                        class="text-gray-900 dark:text-gray-100">{{ $pendingPayment->payment_month->format('F Y') }}</span>
                                </div>
                                <div>
                                    <span class="font-medium text-gray-600 dark:text-gray-400">Status:</span>
                                    <span
                                        class="px-2 py-1 text-xs font-medium rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                                        {{ ucfirst($pendingPayment->status) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('admin.payments.index') }}"
                                class="inline-flex items-center px-4 py-2 bg-red-600 text-white text-sm font-semibold rounded-lg hover:bg-red-700 transition">
                                <i class="fas fa-credit-card mr-2"></i>
                                Make Payment Now
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endif

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
                [
                    'label' => 'Payment Status',
                    'count' => auth()->user()->is_paid ? 'Paid' : 'Pending',
                    'icon' => auth()->user()->is_paid ? 'fas fa-check-circle' : 'fas fa-credit-card',
                    'bg' => auth()->user()->is_paid ? 'from-green-500 to-green-600' : 'from-red-500 to-red-600',
                ],
            ];
        @endphp

        @foreach ($cards as $c)
            <div
                class="group block rounded-2xl overflow-hidden shadow-lg transform hover:-translate-y-1 transition shrink-0">
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

    {{-- Payment Reminder for Last Week of Month --}}
    @php
        $now = now();
        $endOfMonth = $now->copy()->endOfMonth();
        $isLastWeek = $now->diffInDays($endOfMonth) <= 7;
        $nextMonth = $now->copy()->addMonth();
    @endphp

    @if ($isLastWeek && auth()->user()->is_paid)
    <div
        class="mb-6 bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 border border-blue-200 dark:border-blue-800 rounded-xl p-6">
        <div class="flex items-start space-x-4">
            <div class="flex-shrink-0">
                <div class="p-3 bg-blue-100 dark:bg-blue-800 rounded-full">
                    <i class="fas fa-calendar-check text-blue-600 dark:text-blue-400 text-xl"></i>
                </div>
            </div>
            <div class="flex-1">
                <h3 class="text-lg font-semibold text-blue-900 dark:text-blue-200">Monthly Payment Reminder</h3>
                <p class="text-blue-800 dark:text-blue-300 mt-1">
                    Your payment for <strong>{{ $nextMonth->format('F Y') }}</strong> will be due soon.
                    Ensure uninterrupted service by making your payment before the month ends.
                </p>
                <div class="mt-4 flex items-center space-x-4">
                    <div class="text-sm text-blue-700 dark:text-blue-300">
                        <i class="fas fa-clock mr-1"></i>
                        Due Date: {{ $endOfMonth->format('M d, Y') }}
                    </div>
                    <div class="text-sm text-blue-700 dark:text-blue-300">
                        <i class="fas fa-dollar-sign mr-1"></i>
                        Amount: ${{ number_format(auth()->user()->monthly_fee ?? 50, 2) }}
                    </div>
                </div>
                @php
                    $now = now();
                    $endOfMonth = $now->copy()->endOfMonth();
                    $startOfNextMonth = $now->copy()->addMonth()->startOfMonth();
                    $seventhDayNextMonth = $startOfNextMonth->copy()->addDays(6);
                    $thirtiethOfCurrentMonth = $now->copy()->day(30);
                    
                    $isPaymentPeriod = 
                        ($now->gte($thirtiethOfCurrentMonth) && $now->lte($endOfMonth)) ||
                        ($now->gte($startOfNextMonth) && $now->lte($seventhDayNextMonth));
                @endphp

                @if ($isPaymentPeriod)
                    <div class="mt-4 p-4 bg-white dark:bg-gray-800 rounded-lg border border-blue-200 dark:border-blue-700">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="p-2 bg-amber-100 dark:bg-amber-900/30 rounded-full">
                                    <i class="fas fa-exclamation-triangle text-amber-600 dark:text-amber-400"></i>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-900 dark:text-gray-100">Payment Due Soon!</p>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">
                                        @if($now->diffInDays($endOfMonth) <= 7 && $now->lte($endOfMonth))
                                            Only {{ $now->diffInDays($endOfMonth) + 1 }} days remaining this month
                                        @else
                                            Payment period has started for next month
                                        @endif
                                    </p>
                                </div>
                            </div>
                            <a href=""
                                class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded-lg hover:bg-blue-700 transition shadow-md">
                                <i class="fas fa-credit-card mr-2"></i>
                                Make Payment
                            </a>
                        </div>
                    </div>
                @else
                    <div class="mt-4">
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-check-circle text-green-500"></i>
                            <span class="text-sm text-gray-600 dark:text-gray-400">
                                Payment not due yet. Next payment window opens {{ $endOfMonth->subDays(6)->format('M d, Y') }}
                            </span>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
    @endif

    {{-- Pending Requests Table --}}
    <div class="bg-white dark:bg-gray-800 shadow rounded-xl overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-600">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100">
                latest Pending Requests
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
