<?php namespace Bt\Inventory\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateCageMaterialsTable extends Migration
{
    public function up()
    {
        Schema::create('bt_inventory_cage_materials', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->datetime('datecaptured')->nullable();
            $table->integer('part_name_id')->unsigned()->nullable()->index();
            $table->decimal('kg', 15, 1)->nullable()->default(0);

            $table->timestamps();
        });
        Schema::table('bt_inventory_cage_materials', function(Blueprint $table) {
            $table->integer('created_by')->unsigned()->nullable()->index();
            $table->integer('updated_by')->unsigned()->nullable()->index();
        });

        Schema::table('bt_inventory_cage_materials', function(Blueprint $table) {
            $table->integer('raw_material_receivings_id')->unsigned()->nullable()->index();
           $table->integer('dailmaterial_id')->unsigned()->nullable()->index();
            $table->text('comments');
        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_inventory_cage_materials');
    }
}
