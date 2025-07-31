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
            $table->string('dosepot_id')->nullable();
            $table->string('dosepot_key')->nullable();
       });  
    
       
      
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    
      
    }
};
