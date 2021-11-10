<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddClosingBalanceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasTable('account_history')) {
            Schema::table('account_history', function (Blueprint $table) {
                if(!Schema::hasColumn('notifications', 'closing_balance')){
                    $table->decimal('closing_balance', 10, 2)->default(0);
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
        Schema::dropIfExists('add_closing_balance');
    }
}
