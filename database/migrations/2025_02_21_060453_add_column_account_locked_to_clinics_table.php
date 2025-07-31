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
            $table->enum('account_locked',['0','1'])->default('0');
            $table->string('stripe_customer_id')->nullable();
            $table->decimal('account_balance', 30, 2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('clinics', function (Blueprint $table) {
            //
        });
    }
};
