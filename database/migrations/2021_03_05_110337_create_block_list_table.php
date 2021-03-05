<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlockListTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('block_list', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('business_id')->nullable();
            $table->date('blocked_at')->nullable();
            $table->string('blocked_by')->nullable();
            $table->string('unblock')->default(0)->nullable();
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
        Schema::dropIfExists('block_list');
    }
}
