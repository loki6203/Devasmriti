<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddAmountColumnOnAccountDepositsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasTable('account_deposits')) {
            if(!Schema::hasColumn('account_deposits', 'amount')) {
                Schema::table('account_deposits', function (Blueprint $table) {
                    $table->decimal('amount', 10, 2)->default(0);
                });
            }
        }
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('add_amount_column_on_account_deposits');
    }
}
