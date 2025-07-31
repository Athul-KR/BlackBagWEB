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
        Schema::create('patient_imaging_tests', function (Blueprint $table) {
            $table->id();
            $table->string('imaging_test_uuid');
           
            $table->integer('patient_id');
            $table->integer('clinic_id');
            $table->date('test_date');
            // $table->integer('imaging_test_id');
            // $table->integer('option_id');
            // $table->longtext('description');
            $table->integer('created_by');
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });


        Schema::create('patient_imaging_test_items', function (Blueprint $table) {
            $table->id();
            $table->string('imaging_items_uuid');
            $table->integer('patient_imaging_id');
            $table->integer('lab_test_id');
            $table->integer('sub_lab_test_id')->nullable();
            // $table->integer('imaging_test_id');
            $table->string('option_id')->nullable();
            $table->longtext('description')->nullable();
           
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });



    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient_imaging_tests');
    }
};
