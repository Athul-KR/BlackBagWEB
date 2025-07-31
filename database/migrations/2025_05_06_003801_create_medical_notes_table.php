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
        Schema::create('medical_notes', function (Blueprint $table) {
            $table->id();
            $table->string('medical_note_uuid');
            $table->text('transcript_file_path')->nullable();
            $table->text('summary')->nullable();
            $table->text('subjective')->nullable();
            $table->text('objective')->nullable();
            $table->text('assessment')->nullable();
            $table->text('plan')->nullable();
            $table->boolean('show_to_patient')->default(false);
            $table->boolean('is_soap_note')->default(false);
            $table->boolean('video_scribe')->default(false);
            $table->integer('call_id')->nullable();
            $table->integer('appointment_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->integer('clinic_id')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('deleted_by')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medical_notes');
    }
};
