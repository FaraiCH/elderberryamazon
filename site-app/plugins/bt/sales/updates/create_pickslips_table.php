<?php namespace Bt\Sales\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

/**
 * CreatePickslipsTable Migration
 */
class CreatePickslipsTable extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('bt_qc_pickslips')) {
            Schema::create('bt_qc_pickslips', function (Blueprint $table) {
                $table->engine = 'InnoDB';
                $table->increments('id');
                $table->integer('quote_id')->nullable();
                $table->integer('items')->nullable();
                $table->integer('pipe_id')->unsigned()->nullable()->index();
                $table->integer('quotecat_id')->nullable()->unsigned();
                $table->string('logistics_company')->nullable();
                $table->string('plate_number')->nullable();
                $table->dateTime('vehicle_arrival')->nullable();
                $table->time('vehicle_load_start')->nullable();
                $table->time('vehicle_load_end')->nullable();
                $table->integer('vehicle_id')->nullable()->index();
                $table->decimal('weight_bridge_before')->nullable();
                $table->time('vehicle_departure')->nullable();
                $table->integer('linkschedule_id')->nullable()->index();
                $table->integer('type_id')->nullable()->index();
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('bt_qc_pickslips');
    }
}
