<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserCardDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       
        if(!Schema::hasTable('user_card_details')){
            Schema::create('user_card_details', function (Blueprint $table){
                $table->id();
                $table->foreignId('user_id')->nullable(false);
                $table->foreign('user_id')->references('id')->on('users');
                $table->string('card',25)->nullable();
                $table->timestamps();
            });
        }
        if(Schema::hasTable('notifications')) {
            Schema::table('notifications', function (Blueprint $table) {
                if(!Schema::hasColumn('notifications', 'action_type')){
                    $table->enum('action_type', ['referel', 'internal_transfer','deposit','prepaid_recharge','postpaid_recharge','dth_recharge','bbps','bill_pay','rent_pay'])->nullable();
                }
                if(!Schema::hasColumn('notifications', 'is_read')){
                    $table->boolean('is_read');
                }
                if(!Schema::hasColumn('notifications', 'message')){
                    $table->text('message');
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
        Schema::dropIfExists('user_card__details');
    }
}
