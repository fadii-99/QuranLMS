<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // Run on the 1st day of every month at 00:01
        $schedule->command('payments:generate-monthly')
                 ->monthlyOn(1, '00:01')
                 ->withoutOverlapping()
                 ->runInBackground();
        
        // Reset expired classes every hour
        $schedule->command('classes:reset-expired')
                 ->hourly()
                 ->withoutOverlapping()
                 ->runInBackground();
        
        // Mark missed classes every hour
        $schedule->command('classes:mark-missed')
             ->everyThirtyMinutes()
             ->withoutOverlapping()
             ->runInBackground();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
