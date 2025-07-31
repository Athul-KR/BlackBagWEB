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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_uuid',10);
            $table->string('invoice_number')->nullable();
            $table->string('receipt_number')->nullable();
            $table->integer('clinic_id');
            $table->double('grandtotal', 30, 2);
            $table->integer('payment_id')->nullable();
            $table->date('autochargedate')->nullable();
            $table->integer('no_of_users')->default('0');
            $table->string('billing_first_name')->nullable();
            $table->string('billing_last_name')->nullable();
            $table->string('billing_email')->nullable();
            $table->string('billing_phone_number')->nullable();
            $table->text('billing_address')->nullable();
            $table->string('billing_city')->nullable();
            $table->string('billing_state')->nullable();
            $table->string('billing_zip')->nullable();
            $table->string('billing_country_id')->nullable();
            $table->longtext('invoice_notes')->nullable();
            $table->enum('status',['1','2'])->default('1');
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
