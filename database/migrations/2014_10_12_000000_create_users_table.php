<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('users')){
            Schema::create('users', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('email')->unique();
                $table->string('mobile_number',15)->unique();
                $table->string('password');
                $table->string('company_name')->nullable();
                $table->enum('user_type', ['business', 'admin' ,'support' , 'user','superadmin'])->default('user');
                $table->string('referel_code')->nullable();
                $table->string('account_number')->nullable(false)->change();
                $table->string('profile_pic')->nullable();
                $table->enum('is_active', ['active', 'inactive','not_verified'])->default('not_verified');
                $table->text('about_me')->nullable();
                $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
