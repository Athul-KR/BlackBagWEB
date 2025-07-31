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
        Schema::table('appointments', function (Blueprint $table) {
            $table->string('appointment_uuid', 12)->nullable()->change();
            $table->integer('patient_id')->nullable()->change();
            $table->integer('nurse_id')->nullable()->change();
            $table->integer('consultant_id')->nullable()->change();
            $table->decimal('appointment_fee', 15, 2)->nullable()->after('appointment_type');
            $table->integer('appointment_type_id')->nullable()->after('appointment_fee');
            $table->date('appointment_date')->nullable()->change();
            $table->time('appointment_time')->nullable()->change();
            $table->longText('notes')->nullable()->change();
            $table->enum('status', ['0', '1'])->default('0')->nullable()->change();
            $table->integer('created_by')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->string('appointment_uuid', 12)->nullable()->change();
            $table->integer('patient_id')->nullable()->change();
            $table->integer('nurse_id')->nullable()->change();
            $table->integer('doctor_id')->nullable()->change();
            $table->renameColumn('consultant_id', 'doctor_id');
            $table->decimal('appointment_fee', 15, 2)->nullable();
            $table->integer('appointment_type_id')->nullable()->change();
            $table->renameColumn('appointment_type', 'appointment_type_id');
            $table->date('appointment_date')->nullable()->change();
            $table->time('appointment_time')->nullable()->change();
            $table->longText('notes')->nullable()->change();
            $table->enum('status', ['0', '1'])->default('0')->nullable()->change();
            $table->integer('created_by')->nullable()->change();
        });
    }
};
