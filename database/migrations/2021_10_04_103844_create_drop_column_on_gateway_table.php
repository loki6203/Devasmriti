<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDropColumnOnGatewayTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasTable('payment_gateways')) {
            if(Schema::hasColumn('payment_gateways', 'keys')) {
                Schema::table('payment_gateways', function (Blueprint $table) {
                    $table->dropColumn('keys');
                });
            }
            Schema::table('payment_gateways', function (Blueprint $table) {
                if(!Schema::hasColumn('payment_gateways', 'live')) {
                    $table->text('live')->nullable();
                }
                if(!Schema::hasColumn('payment_gateways', 'test')) {
                    $table->text('test')->nullable();
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
        Schema::dropIfExists('drop_column_on_gateway');
    }
}
