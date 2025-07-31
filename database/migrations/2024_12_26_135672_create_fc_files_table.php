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
        Schema::create('fc_files', function (Blueprint $table) {
            $table->id();
            $table->string('fc_file_uuid');
            $table->integer('user_id');
            $table->integer('folder_id')->nullable();
            $table->string('file_key');
            $table->string('file_name');
            $table->string('orginal_name');
            $table->string('file_ext');
            $table->string('file_path')->nullable();
            $table->integer('user_type')->nullable();
            $table->integer('clinic_id')->nullable();
            $table->enum('status',['0','1'])->default('1');
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
        Schema::dropIfExists('fc_files');
    }
};
