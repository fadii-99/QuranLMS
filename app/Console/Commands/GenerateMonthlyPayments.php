<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Payment;
use Carbon\Carbon;

class GenerateMonthlyPayments extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'payments:generate-monthly {--month= : Specific month to generate payments for (Y-m format)}';

    /**
     * The console command description.
     */
    protected $description = 'Generate monthly payment records for all subscribed admins';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $month = $this->option('month') 
            ? Carbon::createFromFormat('Y-m', $this->option('month'))
            : now();
        
        // Get all admin users (adjust this condition based on your user structure)
        $admins = User::where('role', 'admin')
            ->get();
        
        if ($admins->isEmpty()) {
            $this->warn('No admin users found to generate payment records for.');
            return self::FAILURE;
        }
        
        $generated = 0;
        $this->info("Generating monthly payment records for {$month->format('F Y')}...");
        
        $progressBar = $this->output->createProgressBar($admins->count());
        $progressBar->start();
        
        foreach ($admins as $admin) {
            if ($admin->is_blocked) {
                $this->warn("Skipping {$admin->name} ({$admin->email}) - blocked by super admin.");
                $progressBar->advance();
                continue;
            }
            // if ($admin->is_yearly_paid) {
            //     $this->warn("Skipping {$admin->name} ({$admin->email}) - paid yearly.");
            //     $progressBar->advance();
            //     continue;
            // }
            $payment = Payment::generateMonthlyRecord($admin->id, $month->startOfMonth());
            if ($payment->wasRecentlyCreated) {
                $generated++;
                $admin->is_paid = 0;
                $admin->save();
            }
            $progressBar->advance();
        }
        
        $progressBar->finish();
        $this->newLine();
        
        $this->info("✅ Successfully generated {$generated} new monthly payment records.");
        $this->info("📊 Total processed admins: {$admins->count()}");
        
        return self::SUCCESS;
    }
}