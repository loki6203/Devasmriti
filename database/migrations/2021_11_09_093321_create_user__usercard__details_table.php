<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserUsercardDetailsTable extends Migration
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
                if(Schema::hasColumn('notifications', 'gateway_charge')){
                    $table->dropColumn('gateway_charge');
                }
            });
        };
        if(Schema::hasTable('user_card_details')) {
            Schema::table('user_card_details', function (Blueprint $table) {
                if(!Schema::hasColumn('user_card_details', 'gateway_charge')){
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
        Schema::dropIfExists('user__usercard__details');
    }
}
