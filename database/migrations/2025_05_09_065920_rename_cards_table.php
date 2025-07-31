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
        Schema::rename('cards', 'patient_cards');
        Schema::table('patient_cards', function (Blueprint $table) {
            $table->renameColumn('crad_uuid', 'patient_card_uuid');
            $table->dropColumn('clinic_id');
            $table->smallInteger('is_default')->default('0');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::rename('patient_cards', 'cards');
        Schema::table('patient_cards', function (Blueprint $table) {
            $table->renameColumn('patient_card_uuid', 'crad_uuid');
        });
    }
};
