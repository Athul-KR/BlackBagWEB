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
        Schema::create('ref_icd10_codes', function (Blueprint $table) {
            $table->id();
            $table->string('icdcode')->nullable();
            $table->string('title')->nullable();
            $table->enum('status',['0','1'])->default('1');
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ref_icd10_codes');
    }
};
