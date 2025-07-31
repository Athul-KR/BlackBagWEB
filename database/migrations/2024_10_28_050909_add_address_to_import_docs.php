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
        Schema::table('import_docs', function (Blueprint $table) {
            
            $table->string('gender')->nullable();
            $table->string('whatsapp_number')->nullable();
            $table->text('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->date('dob')->nullable();
            $table->text('notes')->nullable();
            $table->integer('zip')->nullable();
            $table->integer('clinic_id')->nullable();
            $table->string('country_code')->nullable();
            $table->string('whatsapp_country_code')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('import_docs', function (Blueprint $table) {
            //
        });
    }
};
