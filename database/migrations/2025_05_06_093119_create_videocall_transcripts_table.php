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
        Schema::create('video_call_transcript_files', function (Blueprint $table) {
            $table->id();
            $table->string('video_call_file_uuid');
            $table->text('transcript_file_path')->nullable();
            $table->longtext('transcript_data')->nullable();
            $table->integer('call_id')->nullable();
            $table->integer('appointment_id')->nullable();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('video_call_transcript_files');
    }
};
