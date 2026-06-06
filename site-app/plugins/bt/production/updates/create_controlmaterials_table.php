<?php namespace Bt\Production\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

/**
 * CreateControlmaterialsTable Migration
 */
class CreateControlmaterialsTable extends Migration
{
    public function up()
    {
        Schema::dropIfExists('bt_production_controlmaterials');
        Schema::create('bt_production_controlmaterials', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('control_sheet_id')->unsigned()->nullable()->index();
            $table->integer('material_id')->unsigned()->nullable()->index();
            $table->integer('measurement')->nullable();
            $table->decimal('kg_per_measurement', 15, 2)->nullable()->default(0);
            $table->integer('created_by')->unsigned()->nullable()->index();
            $table->integer('updated_by')->unsigned()->nullable()->index();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_production_controlmaterials');
    }
}
