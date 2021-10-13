<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddTxnIdTable extends Migration
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
                if(!Schema::hasColumn('account_history', 'txn_id')){
                    $table->char('txn_id',100)->nullable();
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
        Schema::dropIfExists('add_txn_id');
    }
}
