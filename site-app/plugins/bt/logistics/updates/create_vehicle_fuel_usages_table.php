<?php namespace Bt\Logistics\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

/**
 * CreateVehicleFuelUsagesTable Migration
 */
class CreateVehicleFuelUsagesTable extends Migration
{
    public function up()
    {
        Schema::create('bt_logistics_vehicle_fuel_usages', function (Blueprint $table) {
            $table->increments('id');
            $table->date('date');
            $table->integer('vehicle_id')->unsigned()->nullable()->index();
            $table->decimal('price_per_litre', 15, 2)->nullable();
            $table->integer('fueltype_id')->unsigned()->nullable()->index();
            $table->decimal('fuel_intake',15, 2)->unsigned()->nullable()->change();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_logistics_vehicle_fuel_usages');
    }
}
