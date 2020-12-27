<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBusinessActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('business_activities', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('application_business_permit_id')->nullable();

            $table->string('line_of_business')->nullable();
            $table->string('no_of_unit')->nullable();
            $table->string('capitalization')->nullable();
            $table->string('gross_sales')->nullable();

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
        Schema::dropIfExists('business_activities');
    }
}
