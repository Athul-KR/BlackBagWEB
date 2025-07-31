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
        Schema::create('clinic_users', function (Blueprint $table) {
            $table->id();
            $table->string('clinic_user_uuid',12);
            $table->integer('clinic_id');
            $table->integer('user_id');
            $table->integer('user_type_id');
            $table->enum('status',['0','1','-1'])->default('0');
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clinic_users');
    }
};
