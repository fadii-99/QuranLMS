<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'admin_id',
        'amount',
        'payment_date',
        'payment_method',
        'transaction_id',
        'notes',
        'receipt',
        'payment_screenshot',
        'transaction_reference',
        'status',
        'payment_month',
        'is_auto_generated'
    ];

    protected $casts = [
        'payment_date' => 'date',
        'payment_month' => 'date',
        'is_auto_generated' => 'boolean'
    ];

    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    /**
     * Generate monthly payment record for admin
     */
    public static function generateMonthlyRecord(int $adminId, ?Carbon $month = null): self
    {
        $month = $month ?? now()->startOfMonth();
        
        // Check if record already exists for this month
        $existingRecord = self::where('admin_id', $adminId)
            ->whereYear('payment_month', $month->year)
            ->whereMonth('payment_month', $month->month)
            ->first();

        if (!$existingRecord) {
            return self::create([
                'admin_id' => $adminId,
                'amount' => 50.00, // Default subscription amount
                'payment_date' => null,
                'payment_month' => $month,
                'transaction_id' => 'PENDING_' . $adminId . '_' . $month->format('Y_m'),
                'status' => 'pending', // This will show "Pay Now" button
                'is_auto_generated' => true,
                'notes' => 'Auto-generated monthly subscription record for ' . $month->format('F Y')
            ]);
        }

        return $existingRecord;
    }

    /**
     * Check if payment can be made (shows Pay button)
     */
    public function canMakePayment(): bool
    {
        return $this->status === 'pending' && !$this->payment_screenshot;
    }

    /**
     * Check if payment is under review
     */
    public function isUnderReview(): bool
    {
        return $this->status === 'under_review' && $this->payment_screenshot;
    }

    /**
     * Check if payment is approved
     */
    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }
}