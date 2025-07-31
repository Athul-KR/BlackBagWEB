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
        Schema::create('bp_tracker', function (Blueprint $table) {
            $table->id();
            $table->string('bp_tracker_uuid');
            $table->integer('user_id');
            $table->float('systolic', 10, 2)->nullable();
            $table->float('diastolic', 10, 2)->nullable();
            $table->float('pulse', 10, 2)->nullable();
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
        Schema::dropIfExists('bp_tracker');
    }
};
