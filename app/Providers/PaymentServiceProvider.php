<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;

class PaymentServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Auto-generate payment record when admin logs in
        if (app()->runningInConsole()) {
            return;
        }

        // You can add view composers or other boot logic here
    }
}