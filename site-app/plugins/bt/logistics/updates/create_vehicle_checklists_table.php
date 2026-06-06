<?php namespace Bt\Logistics\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

/**
 * CreateVehicleChecklistsTable Migration
 */
class CreateVehicleChecklistsTable extends Migration
{
    public function up()
    {
        Schema::create('bt_logistics_vehicle_checklists', function (Blueprint $table) {
            $table->increments('id');
            $table->date('date')->nullable();
            $table->integer('is_brakes_ok')->nullable()->default(0);
            $table->integer('is_engine_ok')->nullable()->default(0);
            $table->integer('is_hazards_ok')->nullable()->default(0);
            $table->integer('is_doors_ok')->nullable()->default(0);
            $table->integer('is_mirrors_ok')->nullable()->default(0);
            $table->integer('is_tires_ok')->nullable()->default(0);
            $table->integer('is_fuel_ok')->nullable()->default(0);
            $table->integer('is_oil_ok')->nullable()->default(0);
            $table->integer('is_belt_ok')->nullable()->default(0);
            $table->integer('is_horn_ok')->nullable()->default(0);
            $table->integer('is_wipers_ok')->nullable()->default(0);
            $table->integer('is_battery_ok')->nullable()->default(0);
            $table->integer('is_lights_ok')->nullable()->default(0);
            $table->integer('is_vehicle_ok')->nullable()->default(0);
            $table->integer('vehicle_id')->unsigned()->nullable()->index();
            $table->integer('current_mileage')->unsigned()->nullable();
            

            $table->string('brakes_comments')->nullable();
            $table->string('engine_comments')->nullable();
            $table->string('lights_comments')->nullable();
            $table->string('hazards_comments')->nullable();
            $table->string('doors_comments')->nullable();
            $table->string('mirrors_comments')->nullable();
            $table->string('tires_comments')->nullable();
            $table->string('fuel_comments')->nullable();
            $table->string('oil_comments')->nullable();
            $table->string('battery_comments')->nullable();
            $table->string('vehiclecon_comments')->nullable();
            $table->string('belt_comments')->nullable();
            $table->string('horn_comments')->nullable();
            $table->string('wipers_comments')->nullable();
            $table->timestamps();


        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_logistics_vehicle_checklists');
    }
}
