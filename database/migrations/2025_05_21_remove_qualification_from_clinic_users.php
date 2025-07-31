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
            $table->dropColumn('qualification');
            // $table->dropColumn('name');
        });
        Schema::table('clinics', function (Blueprint $table) {
            $table->dropColumn('consultation_time_id');
            $table->dropColumn('consultation_time');
           
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('clinic_users', function (Blueprint $table) {
            $table->string('qualification')->nullable();
            $table->string('name')->nullable();
        });
    }
}; 