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
        Schema::table('payments', function (Blueprint $table) {
            DB::statement("ALTER TABLE `payments` MODIFY `parent_type` ENUM('appointment', 'ePrescribe','subscription','deviceorder') NOT NULL DEFAULT 'appointment' ");
        }); 
        Schema::table('rpm_orders', function (Blueprint $table) {
             $table->integer('payment_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        
    }
};
