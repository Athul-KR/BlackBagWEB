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
        Schema::create('subscriptions_history', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('subscription_plan_id');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->decimal('amount',$precision = 30, $scale = 2)->nullable();
            $table->integer('tenure_type_id')->nullable();
            $table->string('tenure_period')->nullable();
            $table->integer('payment_id')->nullable();
            $table->integer('renewal_plan_id')->nullable();
            $table->integer('clinic_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscriptions_history');
    }
};
