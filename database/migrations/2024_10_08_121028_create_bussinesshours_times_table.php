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
        Schema::create('bussinesshours_times', function (Blueprint $table) {
            $table->id();
            $table->string('bussinesshour_time_uuid',12);
            $table->integer('bussiness_hour_id');
            $table->time('from_time')->nullable();
            $table->time('to_time')->nullable();
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
        Schema::dropIfExists('bussinesshours_times');
    }
};
