<?php namespace Bt\Maintenance\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

/**
 * CreateVehiclesTable Migration
 */
class CreateVehiclesTable extends Migration
{
    public function up()
    {
        Schema::create('bt_maintenance_vehicles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_maintenance_vehicles');
    }
}
