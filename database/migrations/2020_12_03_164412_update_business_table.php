<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateBusinessTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('business', function (Blueprint $table) {
            $table->string('business_id_no')->nullable()->after('bn_number');
            $table->string('no_of_male_employee')->nullable()->after('no_of_employee');
            $table->string('no_of_female_employee')->nullable()->after('no_of_male_employee');
            $table->string('male_residing_in_city')->nullable()->after('no_of_female_employee');
            $table->string('female_residing_in_city')->nullable()->after('male_residing_in_city');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('business', function($table){
            $table->dropColumn(['business_id_no','no_of_male_employee','no_of_female_employee','male_residing_in_city','female_residing_in_city']);
        });
    }
}
