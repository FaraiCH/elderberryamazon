<?php namespace Bt\Inventory\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateRawMaterialReconsTable extends Migration
{
    public function up()
    {
        Schema::create('bt_inventory_raw_material_recons', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->datetime('datereceived')->nullable();
            $table->integer('part_name_id')->unsigned()->nullable()->index();
            $table->integer('bags')->default(0); 
            $table->decimal('kg', 15, 1)->nullable()->default(0);
            $table->timestamps();

        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_inventory_raw_material_recons');
    }
}
