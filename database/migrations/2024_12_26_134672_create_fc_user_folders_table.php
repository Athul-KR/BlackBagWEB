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
        Schema::create('fc_user_folders', function (Blueprint $table) {
            $table->id();
            $table->string('fc_user_folder_uuid');
            $table->integer('user_id');
            $table->integer('folder_id')->nullable();
            $table->string('folder_name')->nullable();
            $table->enum('is_default',['0','1'])->default('0');
            $table->integer('user_type')->nullable();
            $table->integer('clinic_id')->nullable();
            $table->integer('created_by')->nullable();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fc_user_folders');
    }
};
