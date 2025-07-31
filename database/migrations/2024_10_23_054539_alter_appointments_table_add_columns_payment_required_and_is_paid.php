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
        Schema::table('appointments', function (Blueprint $table) {
            $table->enum('payment_required', ['1', '0'])->default('1')->nullable();
            $table->enum('is_paid', ['0', '1'])->default('0')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->enum('payment_required', ['1', '0'])->default('1')->nullable();
            $table->enum('is_paid', ['0', '1'])->default('0')->nullable();
        });
    }
};
