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
        Schema::create('patient_lab_test_items', function (Blueprint $table) {
            $table->id();
            $table->integer('patient_lt_id');
            $table->integer('lab_test_id');
            $table->integer('sub_lab_test_id')->nullable();
            $table->longtext('description')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient_lab_test_items');
    }
};
