<?php namespace Bt\Logistics\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateVehiclesTable extends Migration
{
    public function up()
    {
        Schema::create('bt_logistics_vehicles', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');

            $table->string('name')->nullable();
            $table->string('num_plate')->nullable();
            $table->integer('created_by')->unsigned()->nullable()->index();
            $table->integer('updated_by')->unsigned()->nullable()->index();
            
            $table->timestamps();
 
            $table->integer('next_service_km')->nullable();
            $table->date('next_exp_license_disc')->nullable();
            $table->date('next_service_date')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_logistics_vehicles');
    }
}
