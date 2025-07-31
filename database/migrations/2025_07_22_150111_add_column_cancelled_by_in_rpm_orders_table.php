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
            $table->integer('cancelled_by')->nullable();
            $table->enum('cancelled_by_type',['p','d'])->default('p');
            $table->timestamp('cancelled_on')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        
    }
};
