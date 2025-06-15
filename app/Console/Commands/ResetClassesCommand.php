<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Klass;
use Carbon\Carbon;

class ResetClassesCommand extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'classes:reset-expired {--hours=24 : Hours after which to reset classes}';

    /**
     * The console command description.
     */
    protected $description = 'Reset class data (link, status) for completed, cancelled or missed classes after specified hours';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $hours = (int) $this->option('hours');
        $cutoffTime = Carbon::now()->subHours($hours);
        
        $this->info("Resetting classes older than {$hours} hours (before {$cutoffTime->format('Y-m-d H:i:s')})...");
        
        // Find classes that need to be reset
        $classesToReset = Klass::where(function($query) use ($cutoffTime) {
            $query->where('status', 'completed')
                  ->orWhere('status', 'cancelled') 
                  ->orWhere('ended', true);
        })
        ->where('updated_at', '<=', $cutoffTime)
        ->where(function($query) {
            // Only reset if they have data to reset
            $query->whereNotNull('link')
                  ->orWhere('teacherStarted', true)
                  ->orWhere('studentJoined', true)
                  ->orWhere('ended', true)
                  ->orWhere('status', '!=', 'pending');
        })
        ->get();
        
        if ($classesToReset->isEmpty()) {
            $this->info('No classes found that need to be reset.');
            return self::SUCCESS;
        }
        
        $this->info("Found {$classesToReset->count()} classes to reset...");
        $progressBar = $this->output->createProgressBar($classesToReset->count());
        $progressBar->start();
        
        $resetCount = 0;
        
        foreach ($classesToReset as $class) {
            // Reset class data to initial state
            $class->update([
                'link' => null,
                'status' => 'pending',
                'teacherStarted' => false,
                'studentJoined' => false,
                'ended' => false,
            ]);
            
            $resetCount++;
            $progressBar->advance();
        }
        
        $progressBar->finish();
        $this->newLine();
        
        $this->info("✅ Successfully reset {$resetCount} classes to initial state.");
        $this->info("📊 Classes are now ready to be scheduled again.");
        
        return self::SUCCESS;
    }
}