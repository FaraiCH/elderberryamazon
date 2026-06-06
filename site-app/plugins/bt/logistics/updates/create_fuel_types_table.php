<?php namespace Bt\Logistics\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

/**
 * CreateFuelTypesTable Migration
 */
class CreateFuelTypesTable extends Migration
{
    public function up()
    {
        Schema::create('bt_logistics_fuel_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_logistics_fuel_types');
    }
}
