<?php namespace Bt\Production\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

/**
 * CreateRunningParametersTable Migration
 */
class CreateRunningParametersTable extends Migration
{
    public function up()
    {

        Schema::create('bt_production_running_parameters', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('line_id')->nullable()->index();
            $table->integer('diameter_id')->nullable()->index();
            $table->integer('pn_rating_id')->nullable()->index();
            $table->decimal('screw_speed', 15, 1)->nullable();
            $table->decimal('haul_speed', 15, 1)->nullable();
            $table->decimal('torque', 15, 1)->nullable();
            $table->decimal('vacuum1', 15, 1)->nullable();
            $table->decimal('vacuum2', 15, 1)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_production_running_parameters');
    }
}
