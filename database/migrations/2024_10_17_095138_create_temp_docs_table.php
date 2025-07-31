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
        Schema::create('temp_docs', function (Blueprint $table) {
            $table->id();
            $table->string('tempdoc_uuid');
            $table->string('temp_doc_ext');
            $table->string('original_name');
            $table->string('file_size')->nullable();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });

        Schema::table('patients', function (Blueprint $table) {
            $table->string('logo_path')->nullable();
           
        });
        Schema::table('patient_docs', function (Blueprint $table) {
            $table->string('orginal_name')->nullable();
           
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('temp_docs');
    }
};
