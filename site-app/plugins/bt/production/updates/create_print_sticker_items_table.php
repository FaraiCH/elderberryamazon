<?php namespace Bt\Production\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreatePrintStickerItemsTable extends Migration
{
    public function up()
    {
        Schema::create('bt_production_print_sticker_items', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('sticker_id')->unsigned()->nullable()->index();
            $table->integer('pipe_id')->unsigned()->nullable()->index();  
            $table->datetime('schedule_date')->nullable();
            $table->integer('units')->unsigned();          
            $table->string('notes')->nullable();
            $table->integer('created_by')->unsigned()->nullable()->index();
            $table->integer('updated_by')->unsigned()->nullable()->index();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_production_print_sticker_items');
    }
}
