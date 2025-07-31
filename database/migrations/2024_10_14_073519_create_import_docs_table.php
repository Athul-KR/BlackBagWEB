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
        Schema::create('import_docs', function (Blueprint $table) {
            $table->id();
            $table->string('import_doc_uuid');
            $table->integer('parent_id')->nullable();
            $table->integer('user_id');
            $table->integer('parent_type');
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->integer('designation_id')->nullable();
            $table->string('specialty')->nullable();
            $table->string('qualification')->nullable();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('import_docs');
    }
};
