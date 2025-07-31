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
        Schema::table('bussinesshours_times', function (Blueprint $table) {
            $table->string('slot')->nullable();
        });
        Schema::table('clinics', function (Blueprint $table) {
            $table->integer('appointment_type_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bussinesshours_times', function (Blueprint $table) {
            $table->string('slot')->nullable();
        });
    }
};
