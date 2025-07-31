<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('clinic_users', function (Blueprint $table) {
            $table->dropColumn('specialty');
            $table->unsignedBigInteger('specialty_id')->nullable();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('clinic_users', function (Blueprint $table) {
            // Add back the 'specialty' column (you may need to adjust the data type if needed)
            $table->string('specialty')->nullable();

            // Drop the 'specialty_id' column
            $table->dropColumn('specialty_id');
        });
    }
};
