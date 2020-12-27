<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCollectionOfFeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('collection_of_fees', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('collection_name')->nullable();
            $table->string('permit_fee')->nullable();
            $table->string('electrical_fee')->nullable();
            $table->string('plumbing_fee')->nullable();
            $table->string('mechanical_fee')->nullable();
            $table->string('signboard_fee')->nullable();
            $table->string('zoning_fee')->nullable();
            $table->string('certification_fee_cvo')->nullable();
            $table->string('health_certificate_fee')->nullable();
            $table->string('certification_fee_tetuan')->nullable();
            $table->string('garbage_fee')->nullable();
            $table->string('inspection_fee')->nullable();
            $table->string('sanitary_inspection_fee')->nullable();
            $table->string('sticker')->nullable();
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
        Schema::dropIfExists('collection_of_fees');
    }
}
