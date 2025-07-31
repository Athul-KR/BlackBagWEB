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
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('department')->nullable();
            $table->integer('designation_id')->nullable();
            $table->string('specialty')->nullable();
            $table->string('qualification')->nullable();
            $table->string('phone_number')->nullable();
            $table->enum('login_status', ['0', '1'])->default('0');
            $table->string('invitation_key')->nullable();
            $table->string('country_code')->nullable();
            $table->string('logo_path')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();

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
