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
        Schema::table('glucose_tracker', function (Blueprint $table) {
             $table->integer('rpm_deviceid')->nullable();
        });  
        Schema::table('bp_tracker', function (Blueprint $table) {
             $table->integer('rpm_deviceid')->nullable();
        }); 
        Schema::table('weight_tracker', function (Blueprint $table) {
             $table->integer('rpm_deviceid')->nullable();
        });
        Schema::table('oxygen_saturations', function (Blueprint $table) {
             $table->integer('rpm_deviceid')->nullable();
        });  
      
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
      //  Schema::table('addons', function (Blueprint $table) {
            //
      
    }
};
