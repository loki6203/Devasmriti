<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserRelatedTablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('countries')){
            Schema::create('countries', function (Blueprint $table) {
                $table->id();
                $table->string('name')->nullable();
                $table->enum('is_active', ['active', 'inactive'])->default('active');
                $table->timestamps();
            });
        }
        if(!Schema::hasTable('states')){
            Schema::create('states', function (Blueprint $table) {
                $table->id();
                $table->string('name')->nullable();
                $table->foreignId('country_id')->nullable(false);
                $table->foreign('country_id')->references('id')->on('countries');
                $table->enum('is_active', ['active', 'inactive'])->default('active');
                $table->timestamps();
            });
        }
        if(!Schema::hasTable('cities')){
            Schema::create('cities', function (Blueprint $table) {
                $table->id();
                $table->string('name')->nullable();
                $table->enum('is_active', ['active', 'inactive'])->default('active');
                $table->foreignId('country_id')->nullable(false);
                $table->foreign('country_id')->references('id')->on('countries');
                $table->foreignId('state_id')->nullable(false);
                $table->foreign('state_id')->references('id')->on('states');
                $table->timestamps();
            });
        }
        if(Schema::hasTable('user_details')) {
            Schema::table('user_details', function (Blueprint $table) {
                if(!Schema::hasColumn('user_details', 'address')) {
                    $table->text('address')->nullable();
                }
                if(!Schema::hasColumn('user_details', 'pincode')) {
                    $table->smallInteger ('pincode')->nullable();
                }
                if(!Schema::hasColumn('user_details', 'country_id')) {
                    $table->foreignId('country_id')->nullable(false);
                    $table->foreign('country_id')->references('id')->on('countries');
                }
                if(!Schema::hasColumn('user_details', 'state_id')) {
                    $table->foreignId('state_id')->nullable(false);
                    $table->foreign('state_id')->references('id')->on('states');
                }
                if(!Schema::hasColumn('user_details', 'city_id')) {
                    $table->foreignId('city_id')->nullable(false);
                    $table->foreign('city_id')->references('id')->on('cities');
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
        Schema::dropIfExists('user_related_tables');
    }
}
