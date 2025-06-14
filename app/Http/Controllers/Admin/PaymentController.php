<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Models\Payment;
use Illuminate\Support\Facades\Storage;

class PaymentController extends Controller
{
    public function index(): View
    {
        // Generate current month record if not exists
        Payment::generateMonthlyRecord(auth()->id());

        $payments = Payment::where('admin_id', auth()->id())
            ->orderBy('payment_month', 'desc')
            ->paginate(10);

        $currentMonthPayment = Payment::where('admin_id', auth()->id())
            ->whereYear('payment_month', now()->year)
            ->whereMonth('payment_month', now()->month)
            ->first();

        // Determine what to show based on payment status
        $showPayButton = $currentMonthPayment && $currentMonthPayment->canMakePayment();
        $showUnderReview = $currentMonthPayment && $currentMonthPayment->isUnderReview();
        $showApproved = $currentMonthPayment && $currentMonthPayment->isApproved();

        return view('admin.payment_list', compact(
            'payments',
            'showPayButton',
            'showUnderReview',
            'showApproved',
            'currentMonthPayment'
        ));
    }

    public function upload(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'payment_screenshot' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'notes' => 'nullable|string|max:1000',
        ]);


        $currentMonthPayment = Payment::where('admin_id', auth()->id())
            ->whereYear('payment_month', now()->year)
            ->whereMonth('payment_month', now()->month)
            ->first();

        if (!$currentMonthPayment) {
            return back()->with('error', 'No payment record found for current month.');
        }

        if (!$currentMonthPayment->canMakePayment()) {
            return back()->with('error', 'Payment has already been submitted or approved.');
        }

        // Handle file upload using Laravel 10 storage
        $screenshotPath = $request->file('payment_screenshot')->store('payment_screenshots', 'public');

        $currentMonthPayment->update([
            'payment_screenshot' => $screenshotPath,
            'notes' => $validated['notes'],
            'payment_date' => now(),
            'transaction_id' => 'TXN_' . ((auth()->id() + auth()->id()) * auth()->id()). '_' . now()->format('Y_m_d_His'),
            'status' => 'under_review',
        ]);

        return back()->with('success', 'Payment proof uploaded successfully! Your payment is now under review.');
    }

    public function create(): View
    {
        return view('admin.payments.create');
    }

    public function store(Request $request): RedirectResponse
    {
        return back();
    }

    public function edit($id): View
    {
        return view('admin.payments.edit', compact('id'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        return back();
    }

    public function destroy($id): RedirectResponse
    {
        return back();
    }
}
