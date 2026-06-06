<?php namespace Bt\Inventory\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreatePointEntryItemsTable extends Migration
{
    public function up()
    {
        Schema::create('bt_inventory_point_entry_items', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('user_id')->unsigned()->nullable()->index();
            $table->integer('point_entry_id')->unsigned()->nullable()->index();
            $table->integer('received_in')->unsigned()->nullable()->index();
            $table->integer('part_name_id')->unsigned()->nullable()->index();
            $table->string('supplier_batch')->nullable();
            $table->integer('stock_room_blocks_id')->unsigned()->nullable()->index();
            $table->integer('flooruse')->default(0); 
            $table->integer('bagsother')->default(0); 
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_inventory_point_entry_items');
    }
}
