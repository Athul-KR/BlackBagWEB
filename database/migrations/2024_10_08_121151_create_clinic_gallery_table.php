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
        Schema::create('clinic_gallery', function (Blueprint $table) {
            $table->id();
            $table->string('gallery_uuid',12);
            $table->string('orginal_name');
            $table->string('image_path');
            $table->text('resized_images')->nullable();
            $table->integer('clinic_id')->nullable();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clinic_gallery');
    }
};
