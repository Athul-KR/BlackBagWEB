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
        Schema::table('clinic_users', function (Blueprint $table) {
            $table->string('fax')->nullable();
        });  
        Schema::table('users', function (Blueprint $table) {
            $table->string('fax')->nullable();
        });
        
        Schema::table('patient_subscriptions', function (Blueprint $table) {
            $table->enum('status',[0,1])->default('1'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    
      
    }
};
