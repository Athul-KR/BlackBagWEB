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
        Schema::create('clinic_subscriptions', function (Blueprint $table) {
            $table->id();
            $table->integer('clinic_id');
            $table->string('clinic_subscription_uuid');
            $table->string('plan_name');
            $table->text('description')->nullable();
            $table->decimal('monthly_amount', 15, 2)->nullable();
            $table->decimal('annual_amount', 15, 2)->nullable();
            $table->boolean('has_per_appointment_fee')->default(false);
            $table->decimal('inperson_fee', 15, 2)->nullable();
            $table->decimal('virtual_fee', 15, 2)->nullable();
            $table->integer('created_by')->nullable();
            $table->enum('is_generic',['0','1'])->default('0');
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clinic_subscriptions');
    }
};
