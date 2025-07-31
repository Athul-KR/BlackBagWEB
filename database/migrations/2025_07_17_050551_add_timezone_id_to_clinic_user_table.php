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
        Schema::table('clinics', function (Blueprint $table) {
            $table->integer('timezone_id')->nullable();
        });
        Schema::table('bussinesshours_times', function (Blueprint $table) {
            $table->integer('timezone_id')->nullable();
            $table->time('timezone_from_utc')->nullable();
            $table->time('timezone_to_utc')->nullable();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('clinics', function (Blueprint $table) {
            //
        });
    }
};
