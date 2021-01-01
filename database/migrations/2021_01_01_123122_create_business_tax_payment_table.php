<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBusinessTaxPaymentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('business_tax_payment', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('transaction_id')->nullable();
            $table->string('business_fee_id')->nullable();
            $table->string('transaction_code')->nullable();
            $table->string('quarter')->nullable();
            $table->string('fee_type')->nullable();
            $table->string('payment_reference')->nullable();
            $table->string('payment_type')->nullable();
            $table->string('payment_option')->nullable();
            $table->string('payment_method')->nullable();
            $table->string('payment_status')->default("UNPAID")->nullable();
            $table->string('transaction_status')->default("PENDING")->nullable();
            $table->date('due_date')->nullable();
            $table->date('payment_date')->nullable();
            $table->text('eor_url')->nullable();
            $table->string('amount')->nullable();
            $table->string('convenience_fee')->nullable();
            $table->string('surcharge')->nullable();
            $table->string('interest')->nullable();
            $table->string('discount')->nullable();
            $table->string('total_amount')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('business_tax_payment');
    }
}
