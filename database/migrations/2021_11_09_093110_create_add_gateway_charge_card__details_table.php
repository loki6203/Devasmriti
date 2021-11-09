<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddGatewayChargeCardDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasTable('notifications')) {
            Schema::table('notifications', function (Blueprint $table) {
                if(!Schema::hasColumn('notifications', 'gateway_charge')){
                    $table->decimal('gateway_charge', 10, 2)->nullable();
                }
            });
        };
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('add_gateway_charge_card__details');
    }
}
