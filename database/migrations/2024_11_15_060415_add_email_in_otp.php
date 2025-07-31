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
        Schema::table('otps', function (Blueprint $table) {
            $table->integer('country_id')->nullable()->change();
            $table->string('phone_number')->nullable()->change();
            $table->string('email')->nullable();
        });
        Schema::table('users', function (Blueprint $table) {
            $table->enum('login_type',['p','e'])->default('p');
            $table->string('google_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('otp', function (Blueprint $table) {
            //
        });
    }
};
