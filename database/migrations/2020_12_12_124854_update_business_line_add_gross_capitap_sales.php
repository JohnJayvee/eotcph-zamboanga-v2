<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateBusinessLineAddGrossCapitapSales extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('business_line', function (Blueprint $table) {
            $table->string('gross_sales')->nullable()->after('name');
            $table->string('capital')->nullable()->after('gross_sales');
            $table->string('no_of_units')->nullable()->after('capital');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('business_line', function($table){
            $table->dropColumn(['gross_sales', 'capital', 'no_of_units']);
        });
    }
}
