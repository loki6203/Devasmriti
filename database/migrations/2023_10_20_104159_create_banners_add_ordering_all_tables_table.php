<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBannersAddOrderingAllTablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('banners')){
            if (!Schema::hasColumn('banners', 'ordering_number')) {
                Schema::table('banners', function (Blueprint $table) {
                    $table->bigInteger('ordering_number')->default(0);
                });
            }
        }
        if (Schema::hasTable('sevas')) {
            if (!Schema::hasColumn('sevas', 'ordering_number')) {
                Schema::table('sevas', function (Blueprint $table) {
                    $table->bigInteger('ordering_number')->default(0);
                });
            }
        }
        if (Schema::hasTable('events')) {
            if (!Schema::hasColumn('events', 'ordering_number')) {
                Schema::table('events', function (Blueprint $table) {
                    $table->bigInteger('ordering_number')->default(0);
                });
            }
        }
        if (Schema::hasTable('temples')) {
            if (!Schema::hasColumn('temples', 'ordering_number')) {
                Schema::table('temples', function (Blueprint $table) {
                    $table->bigInteger('ordering_number')->default(0);
                });
            }
        }
        if (Schema::hasTable('seva_types')) {
            if (!Schema::hasColumn('seva_types', 'ordering_number')) {
                Schema::table('seva_types', function (Blueprint $table) {
                    $table->bigInteger('ordering_number')->default(0);
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
        Schema::dropIfExists('banners_add_ordering_all_tables');
    }
}
