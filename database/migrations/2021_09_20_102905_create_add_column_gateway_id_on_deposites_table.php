<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddColumnGatewayIdOnDepositesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasTable('account_deposits')) {
            Schema::table('account_deposits', function (Blueprint $table) {
                if(!Schema::hasColumn('account_deposits', 'gate_way_id')) {
                    $table->foreignId('gate_way_id')->nullable(false);
                    $table->foreign('gate_way_id')->references('id')->on('payment_gateways');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('add_column_gateway_id_on_deposites');
    }
}
