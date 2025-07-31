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
        Schema::create('patient_docs', function (Blueprint $table) {
            $table->id();
            $table->string('patient_doc_uuid',12);
            $table->integer('patient_id');
            $table->string('doc_path')->nullable();
            $table->string('doc_ext')->nullable();
            $table->integer('uploaded_by');
            $table->enum('status',['0','1'])->default('0');
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient_docs');
    }
};
