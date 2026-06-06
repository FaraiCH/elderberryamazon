<?php namespace Bt\Maintenance\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

/**
 * CreateTarrifsTable Migration
 */
class CreateTarrifsTable extends Migration
{
    public function up()
    {

        Schema::create('bt_maintenance_tarrifs', function (Blueprint $table) {
            $table->increments('id');
            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();
            $table->decimal('meter_charge', 15, 2)->nullable();
            $table->decimal('net_access_charge', 15, 2)->nullable();
            $table->decimal('maximum_kva', 15, 2)->nullable();
            $table->decimal('peak', 15, 2)->nullable();
            $table->decimal('standard', 15, 2)->nullable();
            $table->decimal('off_peak', 15, 2)->nullable();
            $table->decimal('rand_per_kwh', 15, 2)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_maintenance_tarrifs');
    }
}
