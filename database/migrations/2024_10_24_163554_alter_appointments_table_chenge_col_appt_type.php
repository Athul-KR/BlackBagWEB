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
        Schema::table('appointments', function (Blueprint $table) {
            // Drop the old appointment_type column
            $table->dropColumn('appointment_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {


            // Re-add the old appointment_type column
            $table->enum('appointment_type', ['online', 'offline'])->nullable(); // Add nullable() if needed
        });
    }
};
