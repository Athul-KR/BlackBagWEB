<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('payment_uuid',10);  
            $table->string('receipt_num')->nullable(); 
            $table->string('billing_first_name')->nullable();
            $table->string('billing_last_name')->nullable();
            $table->string('billing_email')->nullable();
            $table->string('billing_phone')->nullable();
            $table->string('billing_city')->nullable();
            $table->string('billing_address')->nullable();
            $table->string('billing_zip')->nullable();
            $table->string('billing_state')->nullable();
            $table->integer('billing_country_id')->nullable();
            $table->string('exp_month')->nullable();
            $table->string('exp_year')->nullable();
            $table->string('name_on_card')->nullable(); 
            $table->string('card_num')->nullable();
            $table->string('card_type')->nullable();
            $table->integer('transaction_id')->nullable();  
            $table->integer('parent_id')->nullable();        
            $table->string('stripe_customer_id')->nullable();
            $table->string('stripe_payment_id')->nullable();
            $table->integer('user_card_id')->nullable();  
            $table->string('user_id')->nullable();
            $table->smallInteger('status')->default('0'); 
            $table->decimal('amount',10,2)->nullable();
            $table->integer('created_by')->nullable();           
            $table->integer('updated_by')->nullable(); 
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
};
