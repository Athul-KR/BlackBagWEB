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
            $table->string('import_key')->nullable();
            $table->text('error')->nullable();
            $table->enum('status',['-1','0','1'])->default('0');
            $table->enum('is_exists',['0','1'])->default('0');
          
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
