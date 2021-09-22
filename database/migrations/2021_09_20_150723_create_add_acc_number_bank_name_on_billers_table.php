<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddAccNumberBankNameOnBillersTable extends Migration
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
                if(!Schema::hasColumn('billers', 'acc_number')) {
                    $table->char('acc_number',15)->nullable();
                }
                if(!Schema::hasColumn('billers', 'bank_name')) {
                    $table->char('bank_name',15)->nullable();
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
        Schema::dropIfExists('add_acc_number_bank_name_on_billers');
    }
}
