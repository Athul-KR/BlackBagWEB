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
        Schema::table('medications', function (Blueprint $table) {
            $table->string('dosespot_prescription_id')->nullable();
            $table->longText('dosespot_medication_data')->nullable();
       });  
    
       
      
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    
      
    }
};
