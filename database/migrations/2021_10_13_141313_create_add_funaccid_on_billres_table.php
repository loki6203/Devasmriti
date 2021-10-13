<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddFunaccidOnBillresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasTable('billers')) {
            Schema::table('billers', function (Blueprint $table) {
                if(!Schema::hasColumn('billers', 'fund_account_id')){
                    $table->char('fund_account_id',50)->nullable();
                }
                if(!Schema::hasColumn('billers', 'cont_id')){
                    $table->char('cont_id',50)->nullable();
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
        Schema::dropIfExists('add_funaccid_on_billres');
    }
}
