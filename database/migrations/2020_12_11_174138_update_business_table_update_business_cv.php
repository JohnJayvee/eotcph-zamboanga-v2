<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateBusinessTableUpdateBusinessCv extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('business', function (Blueprint $table) {
            $table->string('dti_sec_cda_registration_no')->nullable();
            $table->string('dti_sec_cda_registration_date')->nullable();
            $table->string('ctc_no')->nullable();
            $table->string('ctc_date_issue')->nullable();
            $table->string('business_tin')->nullable();
            $table->string('tax_incentive')->nullable();
            $table->string('tradename')->nullable();

            $table->string('rep_lastname')->nullable();
            $table->string('rep_firstname')->nullable();
            $table->string('rep_middlename')->nullable();
            $table->string('rep_gender')->nullable();
            $table->string('rep_position')->nullable();
            $table->string('rep_tin')->nullable();

            $table->string('business_area')->nullable();

            $table->string('lessor_fullname')->nullable();
            $table->string('lessor_gender')->nullable();
            $table->string('lessor_monthly_rental')->nullable();
            $table->string('lessor_rental_date')->nullable();
            $table->string('lessor_mobile_no')->nullable();
            $table->string('lessor_tel_no')->nullable();
            $table->string('lessor_email')->nullable();
            $table->string('lessor_unit_no')->nullable();
            $table->string('lessor_street_address')->nullable();
            $table->string('lessor_brgy')->nullable();
            $table->string('lessor_brgy_name')->nullable();
            $table->string('lessor_zipcode')->nullable();
            $table->string('lessor_town')->nullable();
            $table->string('lessor_town_name')->nullable();
            $table->string('lessor_region')->nullable();
            $table->string('lessor_region_name')->nullable();
            $table->string('emergency_contact_fullname')->nullable();
            $table->string('emergency_contact_mobile_no')->nullable();
            $table->string('emergency_contact_tel_no')->nullable();
            $table->string('emergency_contact_email')->nullable();
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
            $table->dropColumn([
                'dti_sec_cda_registration_no',
                'dti_sec_cda_registration_date',
                'ctc_no',
                'ctc_date_issue',
                'business_tin',
                'tax_incentive',
                'tradename',
                'rep_lastname',
                'rep_firstname',
                'rep_middlename',
                'rep_gender',
                'rep_position',
                'rep_tin',
                'business_area',
                'lessor_fullname',
                'lessor_gender',
                'lessor_monthly_rental',
                'lessor_mobile_no',
                'lessor_tel_no',
                'lessor_email',
                'lessor_unit_no',
                'lessor_street_address',
                'lessor_brgy',
                'lessor_brgy_name',
                'lessor_zipcode',
                'lessor_town',
                'lessor_town_name',
                'lessor_region',
                'lessor_region_name',
                'emergency_contact_fullname',
                'emergency_contact_mobile_no',
                'emergency_contact_tel_no',
                'emergency_contact_email',
                ]);
        });
    }
}
