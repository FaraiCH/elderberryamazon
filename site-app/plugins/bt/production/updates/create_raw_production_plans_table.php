<?php namespace Bt\Production\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

/**
 * CreateRawProductionPlansTable Migration
 */
class CreateRawProductionPlansTable extends Migration
{
    public function up()
    {
        Schema::create('bt_production_raw_production_plans', function (Blueprint $table) {
$table->increments('id');
$table->date('date');
$table->integer('line_id')->index();
$table->decimal('weight_kg');
$table->timestamps();
        });
        Schema::table('bt_production_raw_production_plans', function (Blueprint $table){
            $table->decimal('raw_material_cost', 15, 2)->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_production_raw_production_plans');
    }
}
