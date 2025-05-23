<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $teacher = auth()->user();

        $students     = User::where('role', USER::ROLE_STUDENT)->get();
        $totalClasses = 10;
        $recentClasses = User::where('id', 1)
            ->take(5)
            ->get();

        return view('teacher.dashboard', compact(
            'students',
            'totalClasses',
            'recentClasses',
        ));
    }
}
