<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateBusinessActivitiesAddAccountCodes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('business_activities', function (Blueprint $table) {
            $table->integer('account_code')->nullable()->after('no_of_unit');
            $table->integer('b_class')->nullable()->after('account_code');
            $table->integer('s_class')->nullable()->after('b_class');
            $table->integer('x_class')->nullable()->after('s_class');
            $table->string('reference_code')->nullable()->after('x_class');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('business_activities', function (Blueprint $table) {
            //
        });
    }
}
