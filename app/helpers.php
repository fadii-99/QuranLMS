<?php

use App\Models\RequestComplain;

if (!function_exists('pending_request_count')) {
    function pending_request_count($adminId = null)
    {
        if (!$adminId && auth()->check()) {
            $adminId = auth()->id();
        }
        return RequestComplain::where('admin_id', $adminId)
            ->where('status', 'pending')
            ->count();
    }
}
