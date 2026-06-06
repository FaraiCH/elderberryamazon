<?php namespace Bt\Inventory\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateStockRoomBlocksTable extends Migration
{
    public function up()
    {
        Schema::create('bt_inventory_stock_room_blocks', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('zone_row')->default(0); 
            $table->string('zone_column_number')->nullable(); 
            $table->integer('zone_stack_height')->default(0); 
            $table->integer('used')->default(0); 
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_inventory_stock_room_blocks');
    }
}
