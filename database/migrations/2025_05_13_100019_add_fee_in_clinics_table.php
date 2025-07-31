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
        Schema::table('clinics', function (Blueprint $table) {
            $table->decimal('inperson_fee', 15, 2)->nullable();
            $table->decimal('virtual_fee', 15, 2)->nullable();
            $table->integer('last_onboarding_step')->nullable();
            $table->integer('consultation_time_id')->nullable();
            $table->string('consultation_time')->nullable();
            $table->boolean('onboarding_complete')->default(false);
            $table->string('email')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('clinics', function (Blueprint $table) {
            //
        });
    }
};
