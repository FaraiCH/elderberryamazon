<?php namespace Bt\Floor\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateStockpipesTable extends Migration
{
    public function up()
    {
        Schema::create('bt_floor_stockpipes', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('user_id')->unsigned()->nullable()->index();
            $table->string('name')->nullable(); 
            $table->integer('product_id')->unsigned()->nullable()->index();
            $table->integer('pipe_out_id')->unsigned()->nullable()->index();
            $table->datetime('datestored')->nullable();
            $table->decimal('weight_kg', 15, 1)->nullable()->default(0);
            $table->integer('quantity')->nullable()->default(1);
            $table->string('pipediameter')->nullable(); 
            $table->string('pipelenghts')->nullable(); 
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_floor_stockpipes');
    }
}
