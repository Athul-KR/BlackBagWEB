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
        Schema::create('user_billing', function (Blueprint $table) {
            $table->id();
            $table->string('user_billing_uuid',10);
            $table->integer('user_id');
            $table->string('billing_company_name')->nullable();
            $table->string('billing_email')->nullable();
            $table->string('billing_phone')->nullable();
            $table->text('billing_address')->nullable();
            $table->string('billing_city')->nullable();
            $table->string('billing_state')->nullable();
            $table->integer('billing_state_id')->nullable();
            $table->string('billing_zip')->nullable();
            $table->string('billing_country_id')->nullable();
            $table->integer('clinic_id')->nullable();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_billing');
    }
};
