<?php namespace Bt\Maintenance\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateElecMeterReadingsTable extends Migration
{
    public function up()
    {
        Schema::create('bt_maintenance_elec_meter_readings', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('meter_id')->nullable()->default(0);
            $table->decimal('pfl1', 15, 2)->nullable();
            $table->decimal('pfl2', 15, 2)->nullable();
            $table->decimal('pfl3', 15, 2)->nullable();
            $table->datetime('readingdate')->nullable();
            $table->text('notes')->nullable();
            $table->integer('created_by')->unsigned()->nullable()->index();
            $table->integer('updated_by')->unsigned()->nullable()->index();

            $table->timestamps();
        });

        Schema::table('bt_maintenance_elec_meter_readings', function (Blueprint $table){
            $table->decimal('meltblown', 15, 2)->nullable()->default(0);
        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_maintenance_elec_meter_readings');
    }
}
