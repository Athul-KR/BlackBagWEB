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
        Schema::create('clinic_addons', function (Blueprint $table) {
            $table->id();
            $table->integer('add_on_id')->nullable();
            $table->integer('clinic_id')->nullable();
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->decimal('amount', 15, 2)->nullable();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clinic_addons');
    }
};
