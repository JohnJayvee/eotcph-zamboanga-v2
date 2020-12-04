<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicationBusinessPermitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('application_business_permits', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('reference_code')->nullable();
            $table->bigInteger('customer_id')->nullable();
            $table->bigInteger('business_id')->nullable();
            $table->string('status')->nullable();
            $table->string('type')->nullable();
            $table->string('frequency_of_payment')->nullable();
            $table->string('amendments')->nullable();
            $table->datetime('application_date')->nullable();
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
            $table->string('website_url')->nullable();

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
            $table->string('lessor_emergency_contact_fullname')->nullable();
            $table->string('lessor_emergency_contact_mobile_no')->nullable();
            $table->string('lessor_emergency_contact_tel_no')->nullable();
            $table->string('lessor_emergency_contact_email')->nullable();

            $table->string('payment_method')->nullable();
            $table->decimal('application_fee', 25, 2)->nullable();
            $table->decimal('service_fee', 25, 2)->nullable();
            $table->decimal('total', 25, 2)->nullable();
            $table->decimal('certification_fee', 25, 2)->nullable();
            $table->decimal('docstamp_fee', 25, 2)->nullable();

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
        Schema::dropIfExists('application_business_permits');
    }
}
