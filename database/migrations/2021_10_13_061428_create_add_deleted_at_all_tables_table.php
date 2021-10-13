<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddDeletedAtAllTablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('account_deposits', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('account_history', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('billers', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('bill_pay', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('cities', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('common_gateway_cards', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('countries', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('internal_transfers', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('notifications', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('payment_gateways', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('recharge_history', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('settings', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('states', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('users', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('user_details', function (Blueprint $table) {
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
        Schema::dropIfExists('add_deleted_at_all_tables');
    }
}
