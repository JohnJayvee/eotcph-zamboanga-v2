<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTableBusinessTransactionAddFieldDepartmentRemarks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('business_transaction', function (Blueprint $table) {
            $table->longtext('department_remarks')->nullable();
            $table->string('department_id')->nullable();
            $table->string('department_involved')->nullable();
            $table->string('is_validated')->default(0)->nullable();
            $table->string('for_bplo_approval')->default(0)->nullable();
            $table->string('payment_status')->default("UNPAID")->after('total_amount')->nullable();


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('business_transaction', function($table){
            $table->dropColumn(['department_remarks','department_id','department_involved','is_validated','for_bplo_approval','payment_status']);
        });

    }
}
