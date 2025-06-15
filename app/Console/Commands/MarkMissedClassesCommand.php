<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Klass;
use Carbon\Carbon;

class MarkMissedClassesCommand extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'classes:mark-missed';

    /**
     * The console command description.
     */
    protected $description = 'Mark classes as missed if teacher did not start or student did not join within their scheduled time';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $today = Carbon::now()->format('Y-m-d');
        $currentTime = Carbon::now();
        
        // Find classes that should have been started but weren't
        $pendingClasses = Klass::where('status', 'pending')
            ->whereDate('created_at', '<=', $today)
            ->get()
            ->filter(function ($class) use ($currentTime) {
                // Parse the class time to check if it has passed
                if (str_contains($class->time, '-')) {
                    [$startTime, $endTime] = explode('-', $class->time);
                    $classStart = Carbon::createFromFormat('H:i', trim($startTime));
                    $classEnd = Carbon::createFromFormat('H:i', trim($endTime));
                    
                    // Check if current time is past the class end time
                    return $currentTime->format('H:i') > $classEnd->format('H:i');
                }
                return false;
            });
        
        if ($pendingClasses->isEmpty()) {
            $this->info('No missed classes found.');
            return self::SUCCESS;
        }
        
        $this->info("Found {$pendingClasses->count()} classes to process...");
        $progressBar = $this->output->createProgressBar($pendingClasses->count());
        $progressBar->start();
        
        $teacherNotStarted = 0;
        $studentNotJoined = 0;
        
        foreach ($pendingClasses as $class) {
            if (!$class->teacherStarted) {
                $class->update(['status' => 'teacher_not_started']);
                $teacherNotStarted++;
            } elseif (!$class->studentJoined) {
                $class->update(['status' => 'student_not_joined']);
                $studentNotJoined++;
            }
            $progressBar->advance();
        }
        
        $progressBar->finish();
        $this->newLine();
        
        if ($teacherNotStarted > 0) {
            $this->info("✅ Marked {$teacherNotStarted} classes as 'teacher_not_started'.");
        }
        
        if ($studentNotJoined > 0) {
            $this->info("✅ Marked {$studentNotJoined} classes as 'student_not_joined'.");
        }
        
        return self::SUCCESS;
    }
}