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

        Schema::create('video_calls', function (Blueprint $table) {
            $table->id();
            $table->string('room_key', 10)->default('');
            $table->string('room_id', 10)->default('');
            $table->integer('appointment_id');
            $table->integer('created_by');
            $table->string('user_type', 10);
            $table->integer('duration');
            $table->integer('call_started')->default(NULL);
            $table->integer('call_ended')->default(NULL);
            $table->enum('status', ['0', '1'])->default('1');
            $table->timestamps();
            $table->softDeletes();
        });
    
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('video_call');
    }

};
