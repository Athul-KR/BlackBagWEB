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
        Schema::create('chat_docs', function (Blueprint $table) {
            $table->id();
            $table->string('chat_doc_uuid', 12);
            $table->integer('chat_id')->nullable();
            $table->integer('chat_message_id')->nullable();
            $table->integer('chat_participant_id')->nullable();
            $table->string('doc_path')->nullable();
            $table->string('doc_ext')->nullable();
            $table->string('original_name')->nullable();
            $table->string('file_size')->nullable();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chat_docs');
    }
};
