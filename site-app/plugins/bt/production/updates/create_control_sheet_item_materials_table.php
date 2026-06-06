<?php namespace Bt\Production\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

/**
 * CreateControlSheetItemMaterialsTable Migration
 */
class CreateControlSheetItemMaterialsTable extends Migration
{
    public function up()
    {
         Schema::create('bt_cs_item_materials', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('control_sheet_item_id')->unsigned()->nullable()->index();
            $table->integer('control_sheet_qc_item_id')->unsigned()->nullable()->index();
            $table->integer('material_id')->unsigned()->nullable()->index();
            $table->integer('kg_unit')->nullable();
            $table->decimal('kg_value', 15, 2)->nullable()->default(0);
            $table->integer('created_by')->unsigned()->nullable()->index();
            $table->integer('updated_by')->unsigned()->nullable()->index();

            $table->timestamps();
         });
    }

    public function down()
    {
        Schema::dropIfExists('bt_cs_item_materials');
    }
}
