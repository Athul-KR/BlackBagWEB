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
        Schema::table('fc_files', function (Blueprint $table) {
            $table->enum('ai_error',['1','0'])->default('0');
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
