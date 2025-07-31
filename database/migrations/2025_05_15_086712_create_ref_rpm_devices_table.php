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
        Schema::create('ref_rpm_devices', function (Blueprint $table) {
            $table->id();
            $table->string('device_uuid', 12);
            $table->string('device')->nullable();
            $table->double('one_time_charge', 30, 2)->nullable();
            $table->double('per_month_amount', 30, 2)->nullable();
            $table->string('sku')->nullable();
            $table->string('sku_instock')->nullable();
            $table->string('video_link')->nullable();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ref_rpm_devices');
    }
};
