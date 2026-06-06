<?php namespace Bt\Production\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

/**
 * CreateRawProductionPlanItemsTable Migration
 */
class CreateRawProductionPlanItemsTable extends Migration
{
    public function up()
    {
        Schema::create('bt_production_raw_production_plan_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('receiving_id')->index();
            $table->integer('raw_production_id')->index();
            $table->decimal('weight_kg');
            $table->timestamps();
        });

        Schema::table('bt_production_pushes', function(Blueprint $table) {
            
        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_production_raw_production_plan_items');
    }
}
