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
        Schema::create('chat_participants', function (Blueprint $table) {
            $table->id();
            $table->string('chat_participant_uuid', 12);
            $table->integer('chat_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->integer('participant_id')->nullable();
            $table->integer('participant_type_id')->nullable();
            $table->timestamp('last_read_time')->nullable();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chat_participants');
    }
};
