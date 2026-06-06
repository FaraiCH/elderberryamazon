<?php namespace Bt\Floor\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateScrappipesTable extends Migration
{
    public function up()
    {
        Schema::create('bt_floor_scrappipes', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('user_id')->unsigned()->nullable()->index();
            $table->integer('quote_id')->unsigned()->nullable()->index();
            $table->integer('shedule_id')->unsigned()->nullable()->index();
            $table->integer('line_id')->unsigned()->nullable()->index();
            $table->integer('scrap_out_id')->unsigned()->nullable()->index();
            $table->datetime('datestored')->nullable();
            $table->decimal('weight_kg', 15, 1)->nullable()->default(0);
            $table->string('pipediameter')->nullable(); 
            $table->string('pipelenghts')->nullable(); 
            $table->string('code')->nullable(); 
            $table->string('notes')->nullable(); 
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_floor_scrappipes');
    }
}
