<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChnagesOnFamilyTypeAndSevaPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasTable('seva_prices')){
            if(!Schema::hasColumn('seva_prices','family_type')){
                Schema::table('seva_prices', function (Blueprint $table) {
                    $table->enum('family_type',['kartha','ancestors','kartha_ancestors','self',''])->nullable();
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
        Schema::dropIfExists('chnages_on_family_type_and_seva_prices');
    }
}
