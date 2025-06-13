@extends('layouts.admin')

@section('title', 'Payments')

@section('content')
    <div class="flex items-center justify-between mb-8 bg-white dark:bg-gray-700 shadow-lg rounded-xl p-4"
        data-aos="fade-down">
        <h1 class="text-3xl font-extrabold text-gray-800 dark:text-gray-100 tracking-tight">Payment Management</h1>
    </div>

    @if (session('success'))
        <div class="mb-6 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-4">
            <p class="text-green-800 dark:text-green-200">{{ session('success') }}</p>
        </div>
    @endif

    @if (session('error'))
        <div class="mb-6 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-4">
            <p class="text-red-800 dark:text-red-200">{{ session('error') }}</p>
        </div>
    @endif

    {{-- Summary Cards --}}
    {{-- <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
        <div class="bg-white dark:bg-gray-700 shadow-md rounded-xl p-6 hover:shadow-xl transition-transform duration-300"
            data-aos="fade-up" data-aos-delay="100">
            <div class="flex items-center">
                <i class="fas fa-clock text-4xl text-yellow-500 mr-4"></i>
                <div>
                    <p class="text-xs uppercase text-gray-500 dark:text-gray-400 font-semibold tracking-wide">Under Review
                    </p>
                    <p class="text-3xl font-bold text-gray-800 dark:text-gray-100 mt-1">{{ $stats['pending'] }}</p>
                    <p class="text-xs text-gray-400 dark:text-gray-300 mt-1">Awaiting approval</p>
                </div>
            </div>
        </div>
        <div class="bg-white dark:bg-gray-700 shadow-md rounded-xl p-6 hover:shadow-xl transition-transform duration-300"
            data-aos="fade-up" data-aos-delay="200">
            <div class="flex items-center">
                <i class="fas fa-check-circle text-4xl text-green-500 mr-4"></i>
                <div>
                    <p class="text-xs uppercase text-gray-500 dark:text-gray-400 font-semibold tracking-wide">Approved</p>
                    <p class="text-3xl font-bold text-gray-800 dark:text-gray-100 mt-1">{{ $stats['approved'] }}</p>
                    <p class="text-xs text-gray-400 dark:text-gray-300 mt-1">Total approved</p>
                </div>
            </div>
        </div>
        <div class="bg-white dark:bg-gray-700 shadow-md rounded-xl p-6 hover:shadow-xl transition-transform duration-300"
            data-aos="fade-up" data-aos-delay="300">
            <div class="flex items-center">
                <i class="fas fa-wallet text-4xl text-blue-500 mr-4"></i>
                <div>
                    <p class="text-xs uppercase text-gray-500 dark:text-gray-400 font-semibold tracking-wide">Total Amount
                    </p>
                    <p class="text-3xl font-bold text-gray-800 dark:text-gray-100 mt-1">
                        ${{ number_format($stats['total_amount'], 2) }}</p>
                    <p class="text-xs text-gray-400 dark:text-gray-300 mt-1">Approved payments</p>
                </div>
            </div>
        </div>
        <div class="bg-white dark:bg-gray-700 shadow-md rounded-xl p-6 hover:shadow-xl transition-transform duration-300"
            data-aos="fade-up" data-aos-delay="400">
            <div class="flex items-center">
                <i class="fas fa-calendar-check text-4xl text-purple-500 mr-4"></i>
                <div>
                    <p class="text-xs uppercase text-gray-500 dark:text-gray-400 font-semibold tracking-wide">Pending</p>
                    <p class="text-3xl font-bold text-gray-800 dark:text-gray-100 mt-1">{{ $stats['pending'] }}
                    </p>
                    <p class="text-xs text-gray-400 dark:text-gray-300 mt-1">Waiting for payment</p>
                </div>
            </div>
        </div>
    </div> --}}

    {{-- Payment Filters --}}
    <div class="bg-white dark:bg-gray-700 shadow-md rounded-xl p-4 mb-6" data-aos="fade-up">
        <form action="{{ route('superadmin.payment.filter') }}" method="POST" class="space-y-4">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status</label>
                    <select name="status"
                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-600 dark:text-gray-200">
                        <option value="all">All Payments</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Payment Due</option>
                        <option value="under_review" {{ request('status') === 'under_review' ? 'selected' : '' }}>Under
                            Review</option>
                        <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved</option>
                        <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Month</label>
                    <select name="month"
                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-600 dark:text-gray-200">
                        <option value="">All Months</option>
                        @for ($i = 1; $i <= 12; $i++)
                            <option value="{{ $i }}" {{ request('month') == $i ? 'selected' : '' }}>
                                {{ \Carbon\Carbon::create()->month($i)->format('F') }}
                            </option>
                        @endfor
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Year</label>
                    <select name="year"
                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-600 dark:text-gray-200">
                        <option value="">All Years</option>
                        @for ($year = now()->year; $year >= 2024; $year--)
                            <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>
                                {{ $year }}</option>
                        @endfor
                    </select>
                </div>
            </div>
            <div class="flex flex-col sm:flex-row gap-2 sm:gap-4">
                <button type="submit"
                    class="w-full sm:w-auto bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                    <i class="fas fa-filter mr-2"></i>Filter
                </button>
                <a href="{{ route('superadmin.payment.index') }}"
                    class="w-full sm:w-auto text-center bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition">
                    <i class="fas fa-times mr-2"></i>Clear
                </a>
            </div>
        </form>
    </div>

    {{-- Payments Table --}}
    <div class="bg-white dark:bg-gray-700 shadow-md rounded-xl overflow-hidden" data-aos="fade-up">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-600 dark:text-gray-300">
                <thead class="text-xs uppercase bg-gray-100 dark:bg-gray-800 font-bold text-gray-700 dark:text-gray-200">
                    <tr>
                        <th class="px-6 py-3">Admin Name</th>
                        <th class="px-6 py-3">Payment Month</th>
                        <th class="px-6 py-3">Amount</th>
                        <th class="px-6 py-3">Payment Date</th>
                        <th class="px-6 py-3">Status</th>
                        <th class="px-6 py-3">Screenshot</th>
                        <th class="px-6 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($payments as $index => $payment)
                        <tr
                            class="{{ $index % 2 === 0 ? 'bg-gray-50 dark:bg-gray-600/50' : 'bg-white dark:bg-gray-700' }} border-b dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors">
                            <td class="px-6 py-4 font-medium">
                                {{ $payment->admin->name ?? 'N/A' }}
                                <br>
                                <span class="text-xs text-gray-300">{{ $payment->admin->email ?? '' }}</span>
                            </td>
                            <td class="px-6 py-4">{{ $payment->payment_month->format('F Y') }}</td>
                            <td class="px-6 py-4 font-semibold">${{ number_format($payment->amount, 2) }}</td>
                            <td class="px-6 py-4">
                                {{ $payment->payment_date ? $payment->payment_date->format('M d, Y') : 'Not paid' }}
                                @if ($payment->payment_date)
                                    <br><span
                                        class="text-xs text-gray-300">{{ $payment->payment_date->format('h:i A') }}</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 ">
                                <div class="flex flex-col gap-1">
                                    @if ($payment->canMakePayment())
                                        <span
                                            class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-600 dark:text-yellow-100 max-w-fit">
                                            <i class="fas fa-exclamation-circle mr-1 text-xs"></i>
                                            <span class="truncate">Payment Due</span>
                                        </span>
                                    @elseif($payment->isUnderReview())
                                        <span
                                            class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-600 dark:text-blue-100 max-w-fit">
                                            <i class="fas fa-clock mr-1 text-xs"></i>
                                            <span class="truncate">Under Review</span>
                                        </span>
                                    @elseif($payment->isApproved())
                                        <span
                                            class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-600 dark:text-green-100 max-w-fit">
                                            <i class="fas fa-check-circle mr-1 text-xs"></i>
                                            <span class="truncate">Approved</span>
                                        </span>
                                        @if ($payment->approved_at)
                                            <span
                                                class="text-xs text-gray-500 mt-1">{{ $payment->approved_at->format('M d, Y') }}</span>
                                        @endif
                                    @elseif($payment->isRejected())
                                        <span
                                            class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-600 dark:text-red-100 max-w-fit">
                                            <i class="fas fa-times-circle mr-1 text-xs"></i>
                                            <span class="truncate">Rejected</span>
                                        </span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @if ($payment->payment_screenshot)
                                    <button type="button"
                                        class="view-screenshot text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300"
                                        data-screenshot="{{ asset('storage/' . $payment->payment_screenshot) }}">
                                        <i class="fas fa-image mr-1"></i>View
                                    </button>
                                @else
                                    <span class="text-gray-400">No screenshot</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-col sm:flex-row gap-1 sm:gap-2">
                                    @if ($payment->isUnderReview())
                                        <button
                                          class="approve-payment bg-green-600 text-white px-2 py-1 sm:px-3 sm:py-1 rounded-full hover:bg-green-700 transition text-xs whitespace-nowrap"
                                          data-id="{{ $payment->id }}"
                                          data-amount="{{ $payment->amount }}">
                                          <i class="fas fa-check mr-1"></i>Approve
                                        </button>

                                        <button type="button"
                                          class="reject-btn bg-red-600 text-white px-2 py-1 sm:px-3 sm:py-1 rounded-full hover:bg-red-700 transition text-xs whitespace-nowrap"
                                          data-payment-id="{{ $payment->id }}">
                                          <i class="fas fa-times mr-1"></i>Reject
                                        </button>
                                    @endif
                                    @if($payment->isApproved())
                                        <span
                                            class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-600 dark:text-green-100 max-w-fit">
                                            <i class="fas fa-check-circle mr-1 text-xs"></i>
                                            <span class="truncate">Approved</span>
                                        </span>
                                      @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <i class="fas fa-receipt text-4xl text-gray-300 dark:text-gray-600 mb-3"></i>
                                    <p class="text-gray-500 dark:text-gray-400 text-lg font-medium">No payments found
                                    </p>
                                    <p class="text-gray-400 dark:text-gray-500 text-sm mt-1">There are no payment
                                        records to display</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($payments->hasPages())
            <div class="px-4 py-3 border-t border-gray-200 dark:border-gray-600">
                {{ $payments->links() }}
            </div>
        @endif
    </div>

    {{-- Screenshot Modal --}}
    <div id="screenshot-modal" class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center hidden z-50">
        <div class="relative bg-white dark:bg-gray-800 rounded-2xl p-6 max-w-4xl max-h-[90vh] w-full mx-4">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xl font-bold text-gray-800 dark:text-gray-100">Payment Screenshot</h3>
                <button id="close-screenshot-modal"
                    class="bg-gray-600 hover:bg-gray-700 text-white rounded-full w-8 h-8 flex items-center justify-center transition">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="overflow-hidden rounded-lg">
                <img id="screenshot-image" src="" alt="Payment Screenshot"
                    class="w-full h-auto max-h-[70vh] object-contain">
            </div>
        </div>
    </div>

    {{-- Rejection Modal --}}
    <div id="rejection-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="bg-white dark:bg-gray-700 rounded-2xl p-6 w-full max-w-md">
            <h3 class="text-xl font-bold text-gray-800 dark:text-gray-100 mb-4">Reject Payment</h3>
            <form id="rejection-form" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="rejection_reason" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Reason for rejection *
                    </label>
                    <textarea id="rejection_reason" name="rejection_reason" rows="4" required
                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-red-500 dark:bg-gray-600 dark:text-gray-200"
                        placeholder="Please provide a reason for rejecting this payment..."></textarea>
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="button" id="cancel-rejection"
                        class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition">
                        Cancel
                    </button>
                    <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition">
                        Reject Payment
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Approval Confirmation Modal -->
    <div id="approve-payment-modal"
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="bg-white dark:bg-gray-700 rounded-2xl p-6 w-full max-w-sm backdrop-blur-lg shadow-xl">
            <h3 class="text-xl font-bold text-gray-800 dark:text-gray-100 mb-4">Confirm Payment Approval</h3>
            <p class="text-gray-600 dark:text-gray-300 mb-6">
                Are you sure you want to approve this payment of
                <span id="approve-payment-amount" class="font-semibold"></span>?
            </p>
            <div class="flex justify-end space-x-4">
                <button id="cancel-approve"
                    class="px-4 py-2 bg-gray-300 dark:bg-gray-600 text-gray-800 dark:text-gray-200 rounded-lg hover:bg-gray-400 dark:hover:bg-gray-500 transition">
                    Cancel
                </button>
                <button id="confirm-approve"
                    class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                    Confirm Approval
                </button>
            </div>
        </div>
    </div>



    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Screenshot modal
            const screenshotModal = document.getElementById('screenshot-modal');
            const screenshotImage = document.getElementById('screenshot-image');
            const closeScreenshotModal = document.getElementById('close-screenshot-modal');
            
            // Add the missing rejectionModal variable
            const rejectionModal = document.getElementById('rejection-modal');

            document.querySelectorAll('.view-screenshot').forEach(btn => {
                btn.addEventListener('click', () => {
                    screenshotImage.src = btn.dataset.screenshot;
                    screenshotModal.classList.remove('hidden');
                });
            });

            closeScreenshotModal.addEventListener('click', () => {
                screenshotModal.classList.add('hidden');
            });

            // Approval Confirmation Modal
            const approveModal = document.getElementById('approve-payment-modal');
            const approveButtons = document.querySelectorAll('.approve-payment');
            const confirmApproveBtn = document.getElementById('confirm-approve');
            const cancelApproveBtn = document.getElementById('cancel-approve');

            // DEBUG: Show how many approve buttons are present
            console.log('approveButtons:', approveButtons.length);

            approveButtons.forEach(button => {
                button.addEventListener('click', () => {
                    const amount = button.dataset.amount;
                    const id = button.dataset.id;
                    console.log('Approve button clicked: id=', id, ' amount=', amount);

                    document.getElementById('approve-payment-amount').textContent = `$${amount}`;
                    confirmApproveBtn.dataset.id = id;

                    approveModal.classList.remove('hidden');
                    console.log('Modal opened');
                });
            });

            cancelApproveBtn?.addEventListener('click', () => {
                approveModal.classList.add('hidden');
                console.log('Modal closed (cancel)');
            });

            approveModal?.addEventListener('click', (e) => {
                if (e.target === approveModal) {
                    approveModal.classList.add('hidden');
                    console.log('Modal closed (outside)');
                }
            });

            confirmApproveBtn?.addEventListener('click', async () => {
                const paymentId = confirmApproveBtn.dataset.id;
                const csrfToken = '{{ csrf_token() }}';

                console.log('Approve confirmed for ID:', paymentId);

                try {
                    const res = await fetch(`/superadmin/payments/${paymentId}/approve`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({ _method: 'PATCH' })
                    });

                    // Check if the HTTP response was successful
                    if (!res.ok) {
                        throw new Error(`HTTP error! status: ${res.status}`);
                    }

                    const data = await res.json();
                    console.log('API response:', data);

                    if (data.success) {
                        showToast('success', data.message);
                        approveModal.classList.add('hidden');
                        setTimeout(() => location.reload(), 2000);
                    } else {
                        showToast('error', data.message || 'Could not approve payment.');
                    }
                } catch (err) {
                    console.error('Error approving payment:', err);
                    showToast('error', 'Server error. Please try again.');
                }
            });
            
            // Close modals when clicking outside
            window.addEventListener('click', (e) => {
                if (e.target === screenshotModal) screenshotModal.classList.add('hidden');
                if (e.target === rejectionModal) rejectionModal.classList.add('hidden');
            });
        });
    </script>
@endsection
