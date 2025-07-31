<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE height_tracker MODIFY unit ENUM('cm', 'inches', 'ft') DEFAULT 'cm'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE height_tracker MODIFY unit ENUM('cm', 'inches') DEFAULT 'cm'");
    }
};
