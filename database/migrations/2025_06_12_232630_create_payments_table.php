<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('admin_id')->constrained('users')->onDelete('cascade');
            $table->decimal('amount', 8, 2);
            $table->date('payment_date')->nullable();
            $table->date('payment_month'); // New field for tracking payment month
            $table->string('payment_method')->nullable(); 
            $table->string('transaction_id')->unique();
            $table->text('notes')->nullable();
            $table->string('receipt')->nullable(); 
            $table->string('payment_screenshot')->nullable(); // Add this field
            $table->string('transaction_reference')->nullable(); // Add this field
            $table->enum('status', ['pending', 'under_review', 'approved', 'rejected'])->default('pending');
            $table->boolean('is_auto_generated')->default(false); // New field
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
