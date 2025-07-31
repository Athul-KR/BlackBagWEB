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
            $table->enum('ai_generated',['0','1'])->default('0');
            $table->enum('consider_for_ai_generation',['0','1'])->default('0');
            $table->longText('summarized_data')->nullable();
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
