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
        Schema::create('video_call_participants', function (Blueprint $table) {
            $table->id();
            $table->string('vcparticipation_key', 10)->default('');
            $table->integer('call_id');
            $table->integer('participant_id');
            $table->string('participant_type', 10)->default('');
            $table->enum('is_owner', ['0', '1'])->default('0');
            $table->enum('is_completed', ['0', '1'])->default('0');
            $table->enum('is_waiting', ['0', '1'])->default('0');
            $table->enum('is_reject', ['0', '1'])->default('0');
            $table->integer('initiated')->default(NULL);
            $table->integer('completed')->default(NULL);
            $table->enum('status', ['0', '1', '2', '3', '4'])->default('1');
            $table->timestamps();
            $table->softDeletes();
        });
   
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void{
        Schema::dropIfExists('video_call_participants');
    }


};
