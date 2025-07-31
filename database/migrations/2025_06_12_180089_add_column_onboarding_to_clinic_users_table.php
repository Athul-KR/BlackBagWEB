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
        Schema::table('clinic_users', function (Blueprint $table) {
           
            $table->integer('onboarding_complete')->default('0');
            $table->integer('last_onboarding_step')->nullable();
        });

        Schema::table('clinic_onboarding_history', function (Blueprint $table) {
           
            $table->integer('parent_id')->nullable();
        });
        Schema::table('ref_onboarding_steps', function (Blueprint $table) {
           
            $table->enum('parent_type',['a','c'])->default('a');
        });

      
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('clinic_users', function (Blueprint $table) {
            //
        });
    }
};
