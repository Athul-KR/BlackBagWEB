<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('patient_note_histories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('patient_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->integer('clinic_id')->nullable();
            $table->integer('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('patient_note_histories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('patient_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->integer('clinic_id')->nullable();
            $table->integer('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

        });
    }
};
