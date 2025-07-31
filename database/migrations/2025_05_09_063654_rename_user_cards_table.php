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
        Schema::rename('user_cards', 'clinic_cards');
        Schema::table('clinic_cards', function (Blueprint $table) {
            $table->renameColumn('user_id', 'added_by');
            $table->renameColumn('user_card_uuid', 'clinic_card_uuid');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::rename('clinic_cards', 'user_cards');
        Schema::table('clinic_cards', function (Blueprint $table) {
            $table->renameColumn('added_by', 'user_id');
            $table->renameColumn('clinic_card_uuid', 'user_card_uuid');
        });
    }
};
