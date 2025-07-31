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
        Schema::create('eprescribers', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->integer('clinic_id')->nullable();
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('eprescribers');
    }
};
