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
        Schema::create('patient_subscription_history', function (Blueprint $table) {
            $table->id();
            $table->integer('clinic_id');
            $table->integer('patient_id');
            $table->integer('clinic_subscription_id');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->decimal('amount', 15, 2)->nullable();
            $table->integer('payment_id')->nullable();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient_subscription_history');
    }
};
