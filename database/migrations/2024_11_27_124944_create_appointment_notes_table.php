
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
        Schema::create('appointment_notes', function (Blueprint $table) {
            $table->id();
            $table->string('appointment_note_key', 10)->default('');
            $table->integer('appointment_id');
            $table->text('notes');
            $table->timestamps();
            $table->softDeletes();
        });
   
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void{
        Schema::dropIfExists('appointment_notes');
    }


};
