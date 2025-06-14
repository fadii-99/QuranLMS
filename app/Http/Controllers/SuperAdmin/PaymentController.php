<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Models\User;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function index(): View
    {
        $payments = Payment::with('admin')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Get statistics
        $stats = [
            'pending' => Payment::where('status', 'pending')->whereNotNull('payment_screenshot')->count(),
            'approved' => Payment::where('status', 'approved')->count(),
            'total_amount' => Payment::where('status', 'approved')->sum('amount'),
            'this_month_approved' => Payment::where('status', 'approved')
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count()
        ];

        return view('superadmin.payments', compact('payments', 'stats'));
    }

    public function approve(Request $request, $id)
    {
        $payment = Payment::findOrFail($id);


        
        if ($payment->status !== 'under_review') {
            return response()->json([
                'success' => false,
                'message' => 'Payment cannot be approved.'
            ]);
        }

        $admin = User::findOrFail($payment->admin_id);
        
        $payment->update([
            'status' => 'approved',
        ]);

        $admin->is_paid = 1;
        $admin->save();

        return response()->json([
            'success' => true,
            'message' => 'Payment approved successfully!'
        ]);
    }

    public function reject(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:500'
        ]);

        $payment = Payment::findOrFail($id);

        if ($payment->status !== 'pending') {
            return back()->with('error', 'Payment cannot be rejected.');
        }

        $payment->update([
            'status' => 'rejected',
            'rejection_reason' => $request->rejection_reason,
            'rejected_at' => now(),
            'rejected_by' => auth()->id()
        ]);

        return back()->with('success', 'Payment rejected successfully!');
    }



    public function filter(Request $request): View
    {
        $query = $this->buildFilterQuery($request);
        $payments = $query->orderBy('created_at', 'desc')->paginate(10);

        // Get statistics from the filtered query
        $baseQuery = $this->buildFilterQuery($request);

        $stats = [
            'pending' => (clone $baseQuery)->where('status', 'pending')->whereNotNull('payment_screenshot')->count(),
            'approved' => (clone $baseQuery)->where('status', 'approved')->count(),
            'total_amount' => (clone $baseQuery)->where('status', 'approved')->sum('amount'),
            'this_month_approved' => (clone $baseQuery)->where('status', 'approved')
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count()
        ];

        return view('superadmin.payments', compact('payments', 'stats'));
    }

    private function buildFilterQuery(Request $request)
    {
        $query = Payment::with('admin');

        if ($request->status && $request->status !== 'all') {
            // if ($request->status === 'under_review') {
            //     $query->where('status', 'pending')->whereNotNull('payment_screenshot');
            // } else {
            $query->where('status', $request->status);
            // }
        }

        if ($request->month) {
            $query->whereMonth('payment_month', $request->month);
        }

        if ($request->year) {
            $query->whereYear('payment_month', $request->year);
        }

        return $query;
    }
}
