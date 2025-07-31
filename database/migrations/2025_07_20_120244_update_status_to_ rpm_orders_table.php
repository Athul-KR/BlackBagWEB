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
        Schema::table('rpm_orders', function (Blueprint $table) {
              DB::statement("ALTER TABLE `rpm_orders` MODIFY `status` ENUM('-1', '1', '0', '2','3','4','5') NOT NULL DEFAULT '-1' ");
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
