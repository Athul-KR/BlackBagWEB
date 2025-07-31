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
        Schema::create('clinic_onboarding_history', function (Blueprint $table) {
            $table->id();
            $table->string('onboarding_history_uuid');
            $table->integer('clinic_id')->nullable();
            $table->integer('step_id')->nullable();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });

       
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clinic_onboarding_history');
    }
};
