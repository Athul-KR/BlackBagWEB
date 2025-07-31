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
        Schema::table('patients', function (Blueprint $table) {
            // $table->string('whatsapp_country_id')->nullable()->after('country_id');
            $table->integer('created_by')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            $table->integer('created_by')->nullable()->change();
            // $table->string('whatsapp_country_id')->nullable()->after('country_id');
        });
    }
};
