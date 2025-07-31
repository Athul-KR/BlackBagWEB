<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Schema::table('clinic_patients', function (Blueprint $table) {
        //     $table->integer('patient_id')->nullable();
        // });
        Schema::table('patients', function (Blueprint $table) {
            $table->date('dob')->nullable();
            $table->string('country_code')->nullable();
            $table->string('whatsapp_country_code')->nullable();
            $table->string('invitation_key')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('clinic_patients', function (Blueprint $table) {
            //
        });
    }
};
