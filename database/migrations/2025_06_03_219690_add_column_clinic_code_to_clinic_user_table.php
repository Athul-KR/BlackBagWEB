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
           
            $table->string('clinic_code')->nullable();
        });

        Schema::table('user_billing', function (Blueprint $table) {
            $table->enum('parent_type',['c','p'])->nullable();
        });
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
