<?php

// app/Http/Controllers/SuperAdmin/DashboardController.php
namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;


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
        
        return view('superadmin.dashboard', compact('totalAdmins', 'totalUsers', 'totalStudents', 'totalTeachers', 'pendingPayments', 'pendingPaymentsList', 'recentActivity'));
    }
}
