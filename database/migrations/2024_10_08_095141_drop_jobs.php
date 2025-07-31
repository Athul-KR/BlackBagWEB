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
         // Drop the users table
         Schema::dropIfExists('jobs');
         Schema::dropIfExists('cache');
         Schema::dropIfExists('cache_locks');
         Schema::dropIfExists('failed_jobs');
         Schema::dropIfExists('job_batches');
          
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
