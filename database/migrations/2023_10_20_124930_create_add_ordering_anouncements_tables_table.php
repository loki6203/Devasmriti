<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddOrderingAnouncementsTablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasTable('anouncements')){
            if (!Schema::hasColumn('anouncements', 'ordering_number')) {
                Schema::table('anouncements', function (Blueprint $table) {
                    $table->bigInteger('ordering_number')->default(0);
                });
            }
        }
        if(Schema::hasTable('banners')){
            if (!Schema::hasColumn('banners', 'ordering_number')) {
                Schema::table('banners', function (Blueprint $table) {
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
        Schema::dropIfExists('add_ordering_anouncements_tables');
    }
}
