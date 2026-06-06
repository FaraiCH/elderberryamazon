<?php namespace Bt\Production\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreatePrintStickersTable extends Migration
{
    public function up()
    {
        Schema::dropIfExists('bt_production_print_stickers');

        Schema::create('bt_production_print_stickers', function(Blueprint $table) {

            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('stickercount')->nullable()->default(0);
            $table->integer('created_by')->unsigned()->nullable()->index();
            $table->integer('updated_by')->unsigned()->nullable()->index();
            $table->timestamps();


        });
       
    }

    public function down()
    {
        Schema::dropIfExists('bt_production_print_stickers');
    }
}
