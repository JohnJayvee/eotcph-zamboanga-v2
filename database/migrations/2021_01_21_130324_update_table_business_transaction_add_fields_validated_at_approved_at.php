<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTableBusinessTransactionAddFieldsValidatedAtApprovedAt extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('business_transaction', function (Blueprint $table) {
            $table->string('validated_at')->nullable();
            $table->string('processed_at')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('business_transaction', function (Blueprint $table) {
            $table->dropColumn(['validated_at','processed_at']);
        });
    }
}
