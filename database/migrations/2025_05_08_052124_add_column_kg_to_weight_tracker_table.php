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
        Schema::table('weight_tracker', function (Blueprint $table) {
            $table->float('kg', 8, 2)->nullable();
            $table->float('lbs', 8, 2)->nullable();
        });
        Schema::table('height_tracker', function (Blueprint $table) {
            $table->float('cm', 8, 2)->nullable();
            $table->float('inches', 8, 2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('weight_tracker', function (Blueprint $table) {
            //
        });
    }
};
