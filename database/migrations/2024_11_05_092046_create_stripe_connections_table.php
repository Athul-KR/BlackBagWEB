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
        Schema::create('stripe_connections', function (Blueprint $table) {
            $table->id();
            $table->string('stripe_connectionkey');
            $table->integer('user_id')->nullable();
            $table->string('stripe_user_id')->nullable();
            $table->longText('connection_response')->nullable();
            $table->longText('disconnection_response')->nullable();
            $table->enum('status',['-1','0','1'])->default('0');
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });
        Schema::table('clinics', function (Blueprint $table) {
            $table->integer('stripe_connection_id')->nullable();
        });
        Schema::table('users', function (Blueprint $table) {
            $table->integer('last_login_clinic_id')->nullable();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stripe_connections');
    }
};
