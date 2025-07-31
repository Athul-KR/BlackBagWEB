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
        Schema::create('patient_conditions', function (Blueprint $table) {
            $table->id();
            $table->string('patient_condition_uuid');
            $table->integer('user_id');
            $table->integer('relation_id')->nullable();
            $table->integer('condition_id')->nullable();
            $table->integer('source_type_id')->nullable();
            $table->integer('clinic_id')->nullable();
            $table->date('reportdate')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient_conditions');
    }
};
