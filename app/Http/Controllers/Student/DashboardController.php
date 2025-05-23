<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;


class DashboardController extends Controller
{
    public function index()
    {
        $student = auth()->user();
        $attendanceCount = 0;


        return view('student.dashboard', compact(
            'attendanceCount',
        ));
    }

}
