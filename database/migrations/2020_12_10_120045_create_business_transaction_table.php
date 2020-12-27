<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBusinessTransactionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('business_transaction', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('owners_id')->nullable();
            $table->string('business_id')->nullable();
            $table->string('business_permit_id')->nullable();
            $table->string('business_name')->nullable();
            $table->string('email')->nullable();
            $table->string('contact_number')->nullable();
            $table->string('code')->nullable();
            $table->string('document_reference_code')->nullable();
            $table->string('application_id')->nullable();
            $table->string('application_name')->nullable();
            $table->string('collection_id')->nullable();
            $table->string('total_amount')->nullable();

            $table->string('processor_user_id')->nullable();
            $table->string('status')->nullable()->default('PENDING');
            $table->timestamp('application_date')->nullable();
            $table->timestamp('modified_at')->nullable();
            $table->text('remarks')->nullable();
            $table->string('is_resent')->default(0)->nullable();
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
        Schema::dropIfExists('business_transaction');
    }
}
