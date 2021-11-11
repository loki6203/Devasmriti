<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddUserHistoryTablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('loginhistory')){
            Schema::create('loginhistory', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->nullable(false);
                $table->foreign('user_id')->references('id')->on('users');
                $table->text('address')->nullable();
                $table->string('ipaddress');
                $table->timestamps();
            });
        }
        if(!Schema::hasTable('news')){
            Schema::create('news', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->nullable(false);
                $table->foreign('user_id')->references('id')->on('users');
                $table->enum('action_type', ['referel', 'internal_transfer','deposit','prepaid_recharge','postpaid_recharge','dth_recharge','bbps','bill_pay','rent_pay'])->nullable();
                $table->integer('action_type_id');
                $table->text('message');
                $table->text('documents')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('add_user_history_tables');
    }
}
