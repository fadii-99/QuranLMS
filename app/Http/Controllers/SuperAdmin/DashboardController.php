<?php

// app/Http/Controllers/SuperAdmin/DashboardController.php
namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\RequestComplain;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // Example data loading from database
        $totalUsers = User::count();
        $totalAdmins = User::where('role', 'admin')->count();
        $totalStudents = User::where('role', 'student')->count();
        $totalTeachers = User::where('role', 'teacher')->count();

        // also load pending payments 
        $pendingPayments = User::where('is_paid', false)->count();
        $pendingPaymentsList = User::where('is_paid', false)->get();

        $recentActivity = [];
        $requests = RequestComplain::whereColumn('admin_id', '=', 'user_id')->paginate(10);
        return view('superadmin.dashboard', compact('totalAdmins', 'totalUsers', 'totalStudents', 'totalTeachers', 'pendingPayments', 'pendingPaymentsList', 'recentActivity', 'requests'));
    }
    public function ReqComp(Request $request)
    {
        $user = Auth::user();
        $data = RequestComplain::whereColumn('admin_id', '=', 'user_id')->paginate(10);

        $viewId = $request->query('view_id');
        return view('superadmin.request-complains', compact('data', 'viewId'));
    }
    public function completeRequest($id)
    {
        $item = RequestComplain::findOrFail($id);
        $item->status = 'completed';
        $item->save();
        return redirect()->route('superadmin.request-complains')
            ->with('success', 'Request marked as completed successfully.');
        // return response()->json(['success' => true, 'message' => 'Request marked as completed.']);
    }

    public function cancelRequest(Request $request, $id)
    {
        $item = RequestComplain::findOrFail($id);
        $item->status = 'canceled';
        $item->save();
        return response()->json(['success' => true, 'message' => 'Request canceled.']);
    }

    public function viewRequest($id)
    {
        $item = RequestComplain::with('user')->findOrFail($id);
        return response()->json(['success' => true, 'data' => $item]);
    }
}
