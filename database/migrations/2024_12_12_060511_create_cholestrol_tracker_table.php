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
        Schema::create('cholestrol_tracker', function (Blueprint $table) {
            $table->id();
            $table->string('cholestrol_tracker_uuid');
            $table->integer('user_id');
            $table->float('cltotal', 10, 2)->nullable();
            $table->float('LDL', 10, 2)->nullable();
            $table->float('HDL', 10, 2)->nullable();
            $table->float('triglycerides', 10, 2)->nullable();
            $table->enum('fasting',['0','1'])->default('0');
            $table->date('reportdate')->nullable();
            $table->time('reporttime')->nullable();
            $table->integer('source_type_id')->nullable();
            $table->integer('clinic_id')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cholestrol_tracker');
    }
};
