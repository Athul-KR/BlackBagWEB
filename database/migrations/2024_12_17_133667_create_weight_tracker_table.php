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
        Schema::create('weight_tracker', function (Blueprint $table) {
            $table->id();
            $table->string('weight_tracker_uuid');
            $table->integer('user_id');
            $table->enum('unit',['lbs','kg'])->default('kg');
            $table->integer('weight');
            $table->integer('bmi')->nullable();
            $table->date('reportdate')->nullable();
            $table->time('reporttime')->nullable();
            $table->integer('source_type_id')->nullable();
            $table->integer('clinic_id')->nullable();
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
        Schema::dropIfExists('weight_tracker');
    }
};
