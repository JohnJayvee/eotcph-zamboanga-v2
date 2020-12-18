<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateBusinessPermitApplicationNo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('application_business_permits', function (Blueprint $table) {
            $table->string('application_no')->nullable()->after('reference_code');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('application_business_permits', function (Blueprint $table) {
            $table->dropColumn(['application_no']);
        });
    }
}
