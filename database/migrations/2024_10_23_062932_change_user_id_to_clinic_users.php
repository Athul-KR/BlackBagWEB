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
            $table->integer('user_id')->nullable()->change();
        });

        Schema::table('ref_user_types', function (Blueprint $table) {
            $table->string('icon')->nullable()->change();
            $table->string('description')->nullable()->change();
        });
        
      
        // Schema::dropIfExists('clinic_nurses');
        // Schema::dropIfExists('clinic_consultants');

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('clinic_users', function (Blueprint $table) {
            //
        });
    }
};
