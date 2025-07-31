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
        Schema::create('patient_lab_tests', function (Blueprint $table) {
            $table->id();
            $table->string('lab_test_uuid');
            $table->integer('patient_id');
            $table->integer('clinic_id');
            $table->date('test_date');
            $table->integer('created_by');
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient_lab_tests');
    }
};
