<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddDetailsOnAccountHistoryTable extends Migration
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
                if(!Schema::hasColumn('account_history', 'payment_details')) {
                    $table->longtext('payment_details')->nullable();
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
        Schema::dropIfExists('add_details_on_account_history');
    }
}
