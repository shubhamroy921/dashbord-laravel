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
            $table->decimal('amount', 15, 2); // Amount (with 2 decimal places)
            $table->string('transaction_id')->unique(); // Unique transaction ID
            $table->string('payment_status')->default('PAYMENT_PENDING'); // Status of payment
            $table->text('response_msg')->nullable(); // Response message from PhonePe (JSON string)
            $table->string('providerReferenceId')->nullable(); // Reference ID from the provider
            $table->string('merchantOrderId')->nullable(); // Merchant Order ID
            $table->string('checksum')->nullable(); // Checksum for verification
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
