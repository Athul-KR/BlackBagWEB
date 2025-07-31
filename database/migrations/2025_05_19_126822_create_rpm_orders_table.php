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
        Schema::create('rpm_orders', function (Blueprint $table) {
            $table->id();
            $table->string('rpm_order_uuid', 12);
            $table->string('order_code')->nullable();
            $table->integer('user_id')->nullable();
            $table->integer('patient_id')->nullable();
            $table->integer('clinic_id')->nullable();
            $table->longText('api_response')->nullable();
            $table->string('shipping_country_id')->nullable();
            $table->string('shipping_country_code')->nullable();
            $table->string('shipping_user_phone')->nullable();
            $table->string('shipping_address')->nullable();
            $table->string('shipping_city')->nullable();
            $table->string('shipping_state_id')->nullable();
            $table->string('shipping_zip')->nullable();
            $table->enum('status', ['-1', '1','0','2'])->default('-1');
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rpm_orders');
    }
};
