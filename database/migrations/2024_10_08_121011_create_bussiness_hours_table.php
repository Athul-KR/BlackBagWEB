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
        Schema::create('bussiness_hours', function (Blueprint $table) {
            $table->id();
            $table->string('bussinesshour_uuid',12);
            $table->enum('isopen',['0','1'])->default('0');
            $table->string('day')->nullable();
            $table->integer('clinic_id')->nullable();
            $table->enum('status',['0','1'])->default('0');
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bussiness_hours');
    }
};
