<?php namespace Bt\Floor\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateStocksizesTable extends Migration
{
    public function up()
    {
        Schema::create('bt_floor_stocksizes', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_floor_stocksizes');
    }
}
