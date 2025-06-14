@extends('layouts.admin')

@section('title', 'Payment List')

@section('content')
    <div class="mb-8 bg-white dark:bg-gray-700 shadow-lg rounded-xl p-4">
        <h1 class="text-3xl font-extrabold text-gray-800 dark:text-gray-100 tracking-tight">My Payment Records</h1>
        <p class="text-gray-600 dark:text-gray-300 mt-2">Manage your monthly subscription payments</p>
    </div>

    @if(session('success'))
        <div class="mb-6 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-4">
            <p class="text-green-800 dark:text-green-200">{{ session('success') }}</p>
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-4">
            <p class="text-red-800 dark:text-red-200">{{ session('error') }}</p>
        </div>
    @endif

    {{-- Payment Status Alert --}}
    @if($currentMonthPayment)
        {{-- Show Pay Button (when status = pending and no screenshot) --}}
        @if($showPayButton)
            <div class="mb-6 bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-yellow-800 dark:text-yellow-200">Payment Due</h3>
                        <p class="text-yellow-700 dark:text-yellow-300">Your payment for {{ $currentMonthPayment->payment_month->format('F Y') }} is due. Amount: ${{ number_format($currentMonthPayment->amount, 2) }}</p>
                    </div>
                    <button id="pay-now-btn" class="bg-yellow-600 text-white px-6 py-2 rounded-lg hover:bg-yellow-700 transition font-medium">
                        <i class="fas fa-credit-card mr-2"></i>Pay Now
                    </button>
                </div>
            </div>
        @endif

        {{-- Show Under Review (when status = pending and has screenshot) --}}
        @if($showUnderReview)
            <div class="mb-6 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-blue-800 dark:text-blue-200">Payment Under Review</h3>
                        <p class="text-blue-700 dark:text-blue-300">Your payment for {{ $currentMonthPayment->payment_month->format('F Y') }} has been submitted and is being reviewed.</p>
                        @if($currentMonthPayment->payment_date)
                            <p class="text-sm text-blue-600 dark:text-blue-400 mt-1">Submitted on: {{ $currentMonthPayment->payment_date->format('M d, Y h:i A') }}</p>
                        @endif
                    </div>
                    <span class="bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-100 px-4 py-2 rounded-full text-sm font-medium">
                        <i class="fas fa-clock mr-2"></i>Under Review
                    </span>
                </div>
            </div>
        @endif

        {{-- Show Approved (when status = approved) --}}
        {{-- @if($showApproved)
            <div class="mb-6 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-green-800 dark:text-green-200">Payment Approved</h3>
                        <p class="text-green-700 dark:text-green-300">Your payment for {{ $currentMonthPayment->payment_month->format('F Y') }} has been approved.</p>
                        @if($currentMonthPayment->payment_date)
                            <p class="text-sm text-green-600 dark:text-green-400 mt-1">Paid on: {{ $currentMonthPayment->payment_date->format('M d, Y') }}</p>
                        @endif
                    </div>
                    <span class="bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100 px-4 py-2 rounded-full text-sm font-medium">
                        <i class="fas fa-check-circle mr-2"></i>Approved
                    </span>
                </div>
            </div>
        @endif --}}
    @endif

    {{-- Payment Upload Modal --}}
    <div id="payment-upload-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="bg-white dark:bg-gray-700 rounded-2xl p-6 w-full max-w-2xl backdrop-blur-lg shadow-xl relative max-h-[90vh] overflow-y-auto">
            <button id="close-upload-modal"
                class="absolute top-4 right-4 text-gray-500 dark:text-gray-300 hover:text-gray-700 dark:hover:text-gray-100">
                <i class="fas fa-times text-xl"></i>
            </button>
            <h3 class="text-xl font-bold text-gray-800 dark:text-gray-100 mb-6">
                <i class="fas fa-credit-card mr-2"></i>Make Payment for {{ now()->format('F Y') }}
            </h3>
            
            <div class="grid md:grid-cols-2 gap-6">
                {{-- Bank Details --}}
                <div class="bg-gray-50 dark:bg-gray-600 rounded-lg p-4">
                    <h4 class="font-semibold text-gray-800 dark:text-gray-100 mb-3">
                        <i class="fas fa-university mr-2"></i>Bank Details
                    </h4>
                    <div class="space-y-3">
                        <div class="flex justify-between py-1 border-b border-gray-200 dark:border-gray-500">
                            <span class="text-gray-600 dark:text-gray-400">Bank Name:</span>
                            <span class="font-medium text-gray-800 dark:text-gray-200">ABC Bank Limited</span>
                        </div>
                        <div class="flex justify-between py-1 border-b border-gray-200 dark:border-gray-500">
                            <span class="text-gray-600 dark:text-gray-400">Account Name:</span>
                            <span class="font-medium text-gray-800 dark:text-gray-200">QuranLMS Services</span>
                        </div>
                        <div class="flex justify-between py-1 border-b border-gray-200 dark:border-gray-500">
                            <span class="text-gray-600 dark:text-gray-400">Account Number:</span>
                            <span class="font-medium text-gray-800 dark:text-gray-200">1234567890</span>
                        </div>
                        <div class="flex justify-between py-1 border-b border-gray-200 dark:border-gray-500">
                            <span class="text-gray-600 dark:text-gray-400">IBAN:</span>
                            <span class="font-medium text-gray-800 dark:text-gray-200">PK12ABCD1234567890</span>
                        </div>
                        <div class="flex justify-between py-2 pt-2 border-t-2 border-green-200 dark:border-green-600 bg-green-50 dark:bg-green-900/20 rounded-lg px-3 mt-4">
                            <span class="font-semibold text-green-700 dark:text-green-300">Amount Due:</span>
                            <span class="font-bold text-lg text-green-600 dark:text-green-400">${{ $currentMonthPayment ? number_format($currentMonthPayment->amount, 2) : '50.00' }}</span>
                        </div>
                    </div>
                </div>

                {{-- QR Code --}}
                <div class="bg-gray-50 dark:bg-gray-600 rounded-lg p-4 text-center">
                    <h4 class="font-semibold text-gray-800 dark:text-gray-100 mb-3">
                        <i class="fas fa-qrcode mr-2"></i>Scan QR Code
                    </h4>
                    <div class="bg-white p-2 rounded-lg inline-block">
                        <div class="w-48 h-48 bg-gray-200 flex items-center justify-center text-gray-500 rounded">
                            <i class="fas fa-qrcode text-6xl"></i>
                        </div>
                    </div>
                    <p class="text-xs text-gray-600 dark:text-gray-300 mt-2">Scan to pay via mobile banking</p>
                </div>
            </div>

            {{-- Upload Form --}}
            <form action="{{ route('admin.payment.upload') }}" method="POST" enctype="multipart/form-data" class="mt-6">
                @csrf
                <div class="space-y-4">
                    <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-2">
                        <p class="text-xs text-blue-800 dark:text-blue-200">
                            <i class="fas fa-info-circle mr-2"></i>
                            After making the payment, upload a clear screenshot of your payment confirmation below.
                        </p>
                    </div>

                    <div>
                        <label for="payment_screenshot" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            <i class="fas fa-camera mr-2"></i>Upload Payment Screenshot *
                        </label>
                        <input type="file" id="payment_screenshot" name="payment_screenshot" accept="image/*" required
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-600 dark:text-gray-200">
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Please upload a clear screenshot of your payment confirmation (JPG, PNG, GIF, WEBP - Max 2MB)</p>
                    </div>
                    
                    <div class="m-0">
                        <label for="payment_notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            <i class="fas fa-sticky-note mr-2"></i>Notes (Optional)
                        </label>
                        <textarea id="payment_notes" name="notes" rows="3"
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-600 dark:text-gray-200"
                            placeholder="Add any additional notes about the payment"></textarea>
                    </div>

                    <button type="submit"
                        class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition font-medium">
                        <i class="fas fa-upload mr-2"></i>Submit Payment Proof
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Payments Data Table --}}
    <div class="bg-white dark:bg-gray-700 shadow rounded-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-600">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">
                <i class="fas fa-history mr-2"></i>Payment History
            </h3>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead>
                    <tr class="bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-300">
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Payment Month</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Amount</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Payment Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-700 divide-y divide-gray-200 dark:divide-gray-600">
                    @forelse($payments as $payment)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                {{ $payment->payment_month->format('F Y') }}
                                @if($payment->is_auto_generated)
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                ${{ number_format($payment->amount, 2) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                {{ $payment->payment_date ? $payment->payment_date->format('M d, Y') : 'Not paid' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($payment->canMakePayment())
                                    <span class="px-3 py-1 inline-flex items-center text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100">
                                        <i class="fas fa-exclamation-circle mr-1"></i>Payment Due
                                    </span>
                                @elseif($payment->isUnderReview())
                                    <span class="px-3 py-1 inline-flex items-center text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-100">
                                        <i class="fas fa-clock mr-1"></i>Under Review
                                    </span>
                                @elseif($payment->isApproved())
                                    <span class="px-3 py-1 inline-flex items-center text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100">
                                        <i class="fas fa-check-circle mr-1"></i>Approved
                                    </span>
                                @elseif($payment->status === 'rejected')
                                    <span class="px-3 py-1 inline-flex items-center text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100">
                                        <i class="fas fa-times-circle mr-1"></i>Rejected
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                <button class="view-payment-details text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300" 
                                    data-payment-id="{{ $payment->id }}"
                                    data-payment-month="{{ $payment->payment_month->format('F Y') }}"
                                    data-amount="{{ number_format($payment->amount, 2) }}"
                                    data-payment-date="{{ $payment->payment_date ? $payment->payment_date->format('M d, Y h:i A') : 'Not paid' }}"
                                    data-status="{{ $payment->status }}"
                                    data-transaction-id="{{ $payment->transaction_id }}"
                                    data-notes="{{ $payment->notes ?? 'No notes' }}"
                                    data-screenshot="{{ $payment->payment_screenshot ? asset('storage/' . $payment->payment_screenshot) : '' }}"
                                    data-created="{{ $payment->created_at->format('M d, Y h:i A') }}"
                                    data-updated="{{ $payment->updated_at->format('M d, Y h:i A') }}">
                                    <i class="fas fa-eye mr-1"></i>View Details
                                </button>
                                @if($payment->canMakePayment())
                                    <button class="pay-now-btn text-yellow-600 hover:text-yellow-900">
                                        <i class="fas fa-credit-card mr-1"></i>Pay
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center space-y-3">
                                    <i class="fas fa-receipt text-4xl text-gray-400 dark:text-gray-500"></i>
                                    <p class="text-gray-500 dark:text-gray-400 text-lg font-medium">No payment records found</p>
                                    <p class="text-gray-400 dark:text-gray-500 text-sm">Your payment history will appear here</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($payments->hasPages())
            <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-600">
                {{ $payments->links() }}
            </div>
        @endif
    </div>

    {{-- Payment Details Modal --}}
    <div id="payment-details-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="bg-white dark:bg-gray-700 rounded-2xl p-6 w-full max-w-4xl backdrop-blur-lg shadow-xl relative max-h-[90vh] overflow-y-auto">
            <button id="close-details-modal" class="absolute top-4 right-4 text-gray-500 dark:text-gray-300 hover:text-gray-700 dark:hover:text-gray-100">
                <i class="fas fa-times text-xl"></i>
            </button>
            
            <div class="mb-6">
                <h3 class="text-2xl font-bold text-gray-800 dark:text-gray-100">
                    <i class="fas fa-receipt mr-2"></i>Payment Details
                </h3>
                <p class="text-gray-600 dark:text-gray-300 mt-1">Complete information about this payment</p>
            </div>

            <div class="grid md:grid-cols-2 gap-6">
                {{-- Payment Information --}}
                <div class="space-y-4">
                    <div class="bg-gray-50 dark:bg-gray-600 rounded-lg p-4">
                        <h4 class="font-semibold text-gray-800 dark:text-gray-100 mb-4">
                            <i class="fas fa-info-circle mr-2"></i>Payment Information
                        </h4>
                        <div class="space-y-3">
                            <div class="flex justify-between py-2 border-b border-gray-200 dark:border-gray-500">
                                <span class="text-gray-600 dark:text-gray-400 font-medium">Transaction ID:</span>
                                <span id="detail-transaction-id" class="text-gray-800 dark:text-gray-200 font-mono text-sm"></span>
                            </div>
                            <div class="flex justify-between py-2 border-b border-gray-200 dark:border-gray-500">
                                <span class="text-gray-600 dark:text-gray-400 font-medium">Payment Month:</span>
                                <span id="detail-payment-month" class="text-gray-800 dark:text-gray-200 font-semibold"></span>
                            </div>
                            <div class="flex justify-between py-2 border-b border-gray-200 dark:border-gray-500">
                                <span class="text-gray-600 dark:text-gray-400 font-medium">Amount:</span>
                                <span id="detail-amount" class="text-gray-800 dark:text-gray-200 font-semibold text-green-600"></span>
                            </div>
                            <div class="flex justify-between py-2 border-b border-gray-200 dark:border-gray-500">
                                <span class="text-gray-600 dark:text-gray-400 font-medium">Payment Date:</span>
                                <span id="detail-payment-date" class="text-gray-800 dark:text-gray-200"></span>
                            </div>
                            <div class="flex justify-between py-2 border-b border-gray-200 dark:border-gray-500">
                                <span class="text-gray-600 dark:text-gray-400 font-medium">Status:</span>
                                <span id="detail-status" class="px-3 py-1 rounded-full text-xs font-semibold"></span>
                            </div>
                        </div>
                    </div>


                    <div class="bg-gray-50 dark:bg-gray-600 rounded-lg p-4">
                        <h4 class="font-semibold text-gray-800 dark:text-gray-100 mb-4">
                            <i class="fas fa-clock mr-2"></i>Timestamps
                        </h4>
                        <div class="space-y-3">
                            <div class="flex justify-between py-2 border-b border-gray-200 dark:border-gray-500">
                                <span class="text-gray-600 dark:text-gray-400 font-medium">Created:</span>
                                <span id="detail-created" class="text-gray-800 dark:text-gray-200 text-sm"></span>
                            </div>
                            <div class="flex justify-between py-2">
                                <span class="text-gray-600 dark:text-gray-400 font-medium">Last Updated:</span>
                                <span id="detail-updated" class="text-gray-800 dark:text-gray-200 text-sm"></span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Screenshot and Notes --}}
                <div class="space-y-4">
                    <div class="bg-gray-50 dark:bg-gray-600 rounded-lg p-4">
                        <h4 class="font-semibold text-gray-800 dark:text-gray-100 mb-4">
                            <i class="fas fa-image mr-2"></i>Payment Screenshot
                        </h4>
                        <div id="screenshot-container" class="text-center">
                            <div id="no-screenshot" class="hidden">
                                <div class="bg-gray-200 dark:bg-gray-500 rounded-lg p-8 text-gray-500 dark:text-gray-400">
                                    <i class="fas fa-image text-4xl mb-2"></i>
                                    <p>No screenshot uploaded</p>
                                </div>
                            </div>
                            <div id="has-screenshot" class="hidden">
                                <img id="detail-screenshot" src="" alt="Payment Screenshot" 
                                    class="max-w-full h-auto rounded-lg cursor-pointer hover:opacity-90 transition"">
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 dark:bg-gray-600 rounded-lg p-4" id="notes-container">
                        <h4 class="font-semibold text-gray-800 dark:text-gray-100 mb-4">
                            <i class="fas fa-sticky-note mr-2"></i>Notes
                        </h4>
                        <div id="detail-notes" class="text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-700 rounded-lg p-3 min-h-[80px] border border-gray-200 dark:border-gray-500">
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>


    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Payment upload modal
            const payNowBtns = document.querySelectorAll('#pay-now-btn, .pay-now-btn');
            const uploadModal = document.getElementById('payment-upload-modal');
            const closeUploadModal = document.getElementById('close-upload-modal');

            payNowBtns.forEach(btn => {
                btn.addEventListener('click', () => {
                    uploadModal.classList.remove('hidden');
                });
            });

            if (closeUploadModal) {
                closeUploadModal.addEventListener('click', () => {
                    uploadModal.classList.add('hidden');
                });
            }

            // Payment details modal
            const detailsModal = document.getElementById('payment-details-modal');
            const closeDetailsModal = document.getElementById('close-details-modal');
            const closeDetailsModalBtn = document.getElementById('close-details-modal-btn');

            document.querySelectorAll('.view-payment-details').forEach(btn => {
                btn.addEventListener('click', () => {
                    // Populate modal with payment data
                    document.getElementById('detail-payment-month').textContent = btn.dataset.paymentMonth;
                    document.getElementById('detail-amount').textContent = '$' + btn.dataset.amount;
                    document.getElementById('detail-payment-date').textContent = btn.dataset.paymentDate;
                    document.getElementById('detail-transaction-id').textContent = btn.dataset.transactionId;
                    document.getElementById('detail-notes').textContent = btn.dataset.notes;
                    document.getElementById('detail-created').textContent = btn.dataset.created;
                    document.getElementById('detail-updated').textContent = btn.dataset.updated;

                    if (btn.dataset.notes === 'No notes' || btn.dataset.notes === '') {
                        document.getElementById('notes-container').style.display = 'none';
                    } else {
                        document.getElementById('notes-container').style.display = 'block';
                    }

                    // Set status with appropriate styling
                    const statusElement = document.getElementById('detail-status');
                    const status = btn.dataset.status;
                    statusElement.textContent = status.charAt(0).toUpperCase() + status.slice(1);
                    
                    // Reset classes
                    statusElement.className = 'px-3 py-1 rounded-full text-xs font-semibold';
                    
                    if (status === 'approved') {
                        statusElement.classList.add('bg-green-100', 'text-green-800', 'dark:bg-green-800', 'dark:text-green-100');
                    } else if (status === 'pending') {
                        statusElement.classList.add('bg-yellow-100', 'text-yellow-800', 'dark:bg-yellow-800', 'dark:text-yellow-100');
                    } else if (status === 'rejected') {
                        statusElement.classList.add('bg-red-100', 'text-red-800', 'dark:bg-red-800', 'dark:text-red-100');
                    }

                    // Handle screenshot
                    const screenshotUrl = btn.dataset.screenshot;
                    const noScreenshot = document.getElementById('no-screenshot');
                    const hasScreenshot = document.getElementById('has-screenshot');
                    const detailScreenshot = document.getElementById('detail-screenshot');

                    if (screenshotUrl) {
                        detailScreenshot.src = screenshotUrl;
                        noScreenshot.classList.add('hidden');
                        hasScreenshot.classList.remove('hidden');
                    } else {
                        noScreenshot.classList.remove('hidden');
                        hasScreenshot.classList.add('hidden');
                    }

                    detailsModal.classList.remove('hidden');
                });
            });

            [closeDetailsModal, closeDetailsModalBtn].forEach(btn => {
                if (btn) {
                    btn.addEventListener('click', () => {
                        detailsModal.classList.add('hidden');
                    });
                }
            });

            // Full screenshot modal

            // Close modals when clicking outside
            window.addEventListener('click', (e) => {
                if (e.target === uploadModal) uploadModal.classList.add('hidden');
                if (e.target === detailsModal) detailsModal.classList.add('hidden');
            });
        });
    </script>

    <style>
        @media print {
            body * {
                visibility: hidden;
            }
            #payment-details-modal, #payment-details-modal * {
                visibility: visible;
            }
            #payment-details-modal {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                height: 100%;
            }
        }
    </style>
@endsection