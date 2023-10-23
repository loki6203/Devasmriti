<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddSevaTypeFamilyDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        if(!Schema::hasTable('seva_price_family_details')){
            Schema::create('seva_price_family_details', function (Blueprint $table){
                $table->id();
                $table->enum('family_type',['kartha','ancestors','kartha_ancestors',''])->nullable();
                $table->foreignId('seva_price_id');
                $table->foreign('seva_price_id')->references('id')->on('seva_prices')->onDelete('cascade');
                $table->timestamps();  
                $table->softDeletes();    
            });
        }
        if (Schema::hasTable('order_sevas')) {
            if (Schema::hasColumn('order_sevas', 'user_family_detail_id')) {
                Schema::table('order_sevas', function (Blueprint $table) {
                    $table->dropForeign(['user_family_detail_id']);
                    $table->dropColumn('user_family_detail_id');
                });
            }
            if (Schema::hasColumn('order_sevas', 'user_family_details')) {
                Schema::table('order_sevas', function (Blueprint $table) {
                    $table->dropColumn('user_family_details');
                });
            }
        }
        if(!Schema::hasTable('order_seva_family_details')){
            Schema::create('order_seva_family_details', function (Blueprint $table){
                $table->id();
                $table->foreignId('order_seva_id');
                $table->foreign('order_seva_id')->references('id')->on('order_sevas')->onDelete('cascade');
                $table->foreignId('user_family_detail_id');
                $table->foreign('user_family_detail_id')->references('id')->on('user_family_details')->onDelete('cascade');
                $table->longText('family_details')->nullable();
                $table->timestamps();
                $table->softDeletes();             
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
        Schema::dropIfExists('add_seva_type_family_details');
    }
}
