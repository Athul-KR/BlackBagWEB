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
        Schema::table('video_call_participants', function (Blueprint $table) {
            $table->integer('completed')->nullable()->change();
        });  
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    
      
    }
};
