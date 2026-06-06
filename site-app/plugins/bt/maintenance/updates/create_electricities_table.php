<?php namespace Bt\Maintenance\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

/**
 * CreateElectricitiesTable Migration
 */
class CreateElectricitiesTable extends Migration
{
    public function up()
    {
        Schema::create('bt_maintenance_electricities', function (Blueprint $table) {
            $table->increments('id');
            $table->date('rdate');
            $table->time('rtime');
            $table->decimal('kwh', 15, 2)->nullable();
            $table->decimal('kVArh', 15, 2)->nullable();
            $table->decimal('kva', 15, 2)->nullable();
            $table->decimal('pf', 15, 2)->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
            $table->integer('meter_no')->nullable()->index();

        });

        Schema::table('bt_maintenance_electricities', function (Blueprint $table){
            $table->decimal('blended_rkwh', 15, 2)->nullable();
            $table->decimal('calculated_rkwh', 15, 2)->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_maintenance_electricities');
    }
}
