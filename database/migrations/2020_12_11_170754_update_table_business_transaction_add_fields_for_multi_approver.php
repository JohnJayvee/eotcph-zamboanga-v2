<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTableBusinessTransactionAddFieldsForMultiApprover extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('business_transaction', function (Blueprint $table) {
            $table->string('department_destination')->nullable();
            $table->string('approved_department')->nullable();
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
            $table->dropColumn(['department_destination','approved_department']);
        });
    }
}
