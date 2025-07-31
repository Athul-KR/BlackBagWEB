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
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('subscription_plan_id');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->integer('subscription_history_id');
            $table->date('renewal_date')->nullable();
            $table->integer('renewal_plan_id')->nullable();
            $table->integer('clinic_id')->nullable();
            $table->enum('trial_subscription',['0','1'])->default('0');
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
