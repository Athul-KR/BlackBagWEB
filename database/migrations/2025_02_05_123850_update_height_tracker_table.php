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
        Schema::table('height_tracker', function (Blueprint $table) {
            $table->float('height', 8, 2)->change();
        });
        Schema::table('weight_tracker', function (Blueprint $table) {
            $table->float('weight', 8, 2)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
       //
    }
};
