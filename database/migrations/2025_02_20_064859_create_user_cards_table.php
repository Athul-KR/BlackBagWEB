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
        Schema::create('user_cards', function (Blueprint $table) {
            $table->id();
            $table->string('user_card_uuid',10);
            $table->integer('user_id');
            $table->string('name_on_card');
            $table->string('card_number');
            $table->string('card_type');
            $table->string('exp_month');
            $table->string('exp_year');
            $table->string('stripe_card_id')->nullable();
            $table->integer('clinic_id')->nullable();
            $table->smallInteger('is_default')->default('0');
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_cards');
    }
};
