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
        Schema::create('clinic_ratings', function (Blueprint $table) {
            $table->id();
            $table->string('rating_uuid',12);
            $table->integer('clinic_id');
            $table->double('rating', 30, 2)->nullable();
            $table->text('comment')->nullable();
            $table->integer('user_id');
            $table->enum('status',['-1','0','1','2'])->default('0');
            $table->integer('approved_by');
            $table->timestamp('approved_at')->nullable();
            $table->integer('rejected_by')->nullable();
            $table->timestamp('rejected_at')->nullable();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clinic_ratings');
    }
};
