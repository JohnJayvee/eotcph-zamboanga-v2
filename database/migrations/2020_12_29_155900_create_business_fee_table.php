<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBusinessFeeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('business_fee', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('transaction_id')->nullable();
            $table->string('business_id')->nullable();
            $table->string('office_code')->nullable();
            $table->longText('collection_of_fees')->nullable();
            $table->string('amount')->nullable();
            $table->string('status')->nullable();
            $table->string('fee_type')->nullable();
            $table->string('payment_status')->default("PENDING")->nullable();
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
        Schema::dropIfExists('business_fee');
    }
}
