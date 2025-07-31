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
        Schema::create('rpm_order_devices', function (Blueprint $table) {
            $table->id();
            $table->integer('rpm_order_id')->nullable();
            $table->string('rpm_order_device_uuid')->nullable();
            $table->integer('rpm_device_id')->nullable();
            $table->text('tracking_details')->nullable();
            $table->string('tracking_number')->nullable();
            $table->string('device_macid')->nullable();
            $table->enum('status', ['-1', '1','2','3'])->default('-1');
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rpm_order_devices');
    }
};
