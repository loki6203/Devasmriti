<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserDetailsXtraFieldsTable extends Migration
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
                if(!Schema::hasColumn('user_details', 'adhar_file')) {
                    $table->text('adhar_file')->nullable();
                }
                if(!Schema::hasColumn('user_details', 'pan_file')) {
                    $table->text('pan_file')->nullable();
                }
                if(!Schema::hasColumn('user_details', 'dob')) {
                    $table->date ('dob')->nullable();
                }
                if(!Schema::hasColumn('user_details', 'verified_by')) {
                    $table->foreignId('verified_by')->nullable();
                    $table->foreign('verified_by')->references('id')->on('users');
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
        Schema::dropIfExists('user_details_xtra_fields');
    }
}
