<?php namespace Bt\Inventory\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreatePrintStickerItemsTable extends Migration
{
    public function up()
    {
        Schema::create('bt_inventory_print_sticker_items', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('sticker_id')->unsigned()->nullable()->index();
            $table->integer('material_id')->unsigned()->nullable()->index();  
            $table->datetime('schedule_date')->nullable();
            $table->integer('units')->unsigned();          
            $table->string('notes')->nullable();
            $table->integer('created_by')->unsigned()->nullable()->index();
            $table->integer('updated_by')->unsigned()->nullable()->index();
            $table->timestamps();
        });
        Schema::table('bt_inventory_print_sticker_items', function(Blueprint $table) {
            $table->decimal('weight', 15, 1)->nullable()->default(0);
        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_inventory_print_sticker_items');
    }
}
