<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = User::where('role', User::ROLE_ADMIN)->get();
        return view('superadmin.payments', compact('payments'));
    }
}
