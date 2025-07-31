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
        Schema::table('clinics', function (Blueprint $table) {
            $table->decimal('in_person_mark_as_no_show_fee', 15, 2)->nullable();
            $table->decimal('in_person_cancellation_fee', 15, 2)->nullable();
            $table->decimal('virtual_mark_as_no_show_fee', 15, 2)->nullable();
            $table->decimal('virtual_cancellation_fee', 15, 2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('clinics', function (Blueprint $table) {
            //
        });
    }
};
