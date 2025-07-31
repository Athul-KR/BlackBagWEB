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
        Schema::create('chats', function (Blueprint $table) {
            $table->id();
            $table->string('chat_uuid', 12);
            $table->integer('clinic_id')->nullable();
            $table->integer('from_user_id')->nullable();
            $table->integer('to_user_id')->nullable();
            $table->integer('from_parent_id')->nullable();
            $table->integer('to_parent_id')->nullable();
            $table->enum('from_parent_type',['c','p'])->default('c');
            $table->enum('to_parent_type',['c','p'])->default('p');
            $table->integer('chat_type_id')->nullable();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chats');
    }
};
