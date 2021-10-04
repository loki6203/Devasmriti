<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddAmountColumnOnIntTransfTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasTable('internal_transfers')) {
            if(!Schema::hasColumn('internal_transfers', 'amount')) {
                Schema::table('internal_transfers', function (Blueprint $table) {
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
        Schema::dropIfExists('add_amount_column_on_int_transf');
    }
}
