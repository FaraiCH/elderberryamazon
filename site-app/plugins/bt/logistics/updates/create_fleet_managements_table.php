<?php namespace Bt\Logistics\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

/**
 * CreateFleetManagementsTable Migration
 */
class CreateFleetManagementsTable extends Migration
{
    public function up()
    {
        Schema::create('bt_logistics_fleet_managements', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_logistics_fleet_managements');
    }
}
