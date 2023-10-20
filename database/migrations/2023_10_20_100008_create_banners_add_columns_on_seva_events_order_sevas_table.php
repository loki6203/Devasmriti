<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBannersAddColumnsOnSevaEventsOrderSevasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('banners')){
            Schema::create('banners', function (Blueprint $table) {
                $table->id();
                $table->string('title',200)->unique();
                $table->longText('description')->nullable();
                $table->foreignId('image_id')->nullable();
                $table->foreign('image_id')->references('id')->on('images')->onDelete('cascade');
                $table->boolean('is_active')->default(1);
                $table->timestamps();
                $table->softDeletes();
            });
        }
        if (Schema::hasTable('sevas')) {
            if (!Schema::hasColumn('sevas', 'is_featured')) {
                Schema::table('sevas', function (Blueprint $table) {
                    $table->boolean('is_featured')->default(0);
                });
            }
        }
        if (Schema::hasTable('events')) {
            if (!Schema::hasColumn('events', 'is_featured')) {
                Schema::table('events', function (Blueprint $table) {
                    $table->boolean('is_featured')->default(0);
                });
            }
        }
        if (Schema::hasTable('order_sevas')) {
            if (!Schema::hasColumn('order_sevas', 'user_family_detail_id')) {
                Schema::table('order_sevas', function (Blueprint $table) {
                    $table->foreignId('user_family_detail_id');
                    $table->foreign('user_family_detail_id')->references('id')->on('user_family_details')->onDelete('cascade');
                    $table->longText('user_family_details')->nullable();
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
        Schema::dropIfExists('banners');
        if (Schema::hasTable('sevas')) {
            if (Schema::hasColumn('sevas', 'is_featured')) {
                Schema::table('sevas', function (Blueprint $table) {
                    $table->dropColumn('is_featured');
                });
            }
        }
        if (Schema::hasTable('events')) {
            if (Schema::hasColumn('events', 'is_featured')) {
                Schema::table('events', function (Blueprint $table) {
                    $table->dropColumn('is_featured');
                });
            }
        }
        if (Schema::hasTable('order_sevas')) {
            if (Schema::hasColumn('order_sevas', 'user_family_detail_id')) {
                Schema::table('order_sevas', function (Blueprint $table) {
                    $table->dropColumn('user_family_detail_id');
                });
            }
        }
    }
}
