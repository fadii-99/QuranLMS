<?php

use App\Models\RequestComplain;
use App\Models\Payment;
use App\Models\User;

if (!function_exists('pending_request_count')) {
    function pending_request_count($adminId = null)
    {
        if (!$adminId ) {
            return RequestComplain::whereColumn('admin_id', '=', 'user_id')
                ->where('status', 'pending')
                ->count();
        }
        return RequestComplain::where('admin_id', $adminId)
            ->whereColumn('admin_id', '!=', 'user_id')
            ->where('status', 'pending')
            ->count();
    }
}
if (!function_exists('is_pending_payment')) {
    function is_pending_payment($adminId = null)
    {
        if (!$adminId && auth()->check()) {
            $adminId = auth()->id();
        }
        return User::where('is_paid', 0)
            ->exists();
    }
}




// Super Admin

if (!function_exists('under_review_payments_count')) {
    function under_review_payments_count()
    {
        
        return Payment::where('status', 'under_review')
            ->count();
    }
}
if (!function_exists('pending_payments_count')) {
    function pending_payments_count()
    {
        
        return Payment::where('status', 'under_review')
            ->count();
    }
}
