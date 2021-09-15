<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMessageOnUserDetails extends Migration
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
                if(!Schema::hasColumn('user_details', 'message')) {
                    $table->text('message')->nullable();
                }
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
        if(Schema::hasTable('user_details')) {
            Schema::table('user_details', function (Blueprint $table) {
                if(Schema::hasColumn('user_details', 'message')) {
                    $table->dropColumn('message');
                }
            });
        }
    }
}
