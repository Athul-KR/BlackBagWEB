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
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->string('appointment_uuid',12);
            $table->integer('patient_id');
            $table->integer('clinic_id');
            $table->integer('consultant_id');
            $table->integer('nurse_id');
            $table->date('appointment_date');
            $table->time('appointment_time');
            $table->enum('appointment_type',['online','offline'])->default('online');
            $table->text('notes')->nullable();
            $table->enum('status',['0','1'])->default('0');
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
        Schema::dropIfExists('appointments');
    }
};
