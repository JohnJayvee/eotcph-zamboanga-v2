<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateBusinessAddOwnerDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('business', function (Blueprint $table) {
            $table->string('owner_fname')->nullable();
            $table->string('owner_mname')->nullable();
            $table->string('owner_lname')->nullable();
            $table->string('owner_email')->nullable();
            $table->string('owner_mobile_no')->nullable();
            $table->string('owner_brgy')->nullable();
            $table->string('owner_brgy_name')->nullable();
            $table->string('owner_tin')->nullable();
            $table->string('owner_street')->nullable();
            $table->string('owner_unit_no')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('business', function (Blueprint $table) {
            $table->dropColumn(['owner_fname', 'owner_mname', 'owner_lname', 'owner_email', 'owner_mobile_no', 'owner_brgy', 'owner_brgy_name', 'owner_tin', 'owner_street', 'owner_unit_no']);
        });
    }
}
