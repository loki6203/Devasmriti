<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSmallIntToBigIntTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasTable('user_details')) {
            Schema::table('user_details', function (Blueprint $table) {
                if(Schema::hasColumn('user_details', 'mobile_otp')){
                    $table->integer('mobile_otp')->change();
                }
                if(Schema::hasColumn('user_details', 'pan_attempts')){
                    $table->integer('pan_attempts')->change();
                }
                if(Schema::hasColumn('user_details', 'adhar_otp')){
                    $table->integer('adhar_otp')->change();
                }
                if(Schema::hasColumn('user_details', 'email_otp')){
                    $table->integer('email_otp')->change();
                }
                if(Schema::hasColumn('user_details', 'pincode')){
                    $table->integer('pincode')->change();
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
        Schema::dropIfExists('small_int_to_big_int');
    }
}
