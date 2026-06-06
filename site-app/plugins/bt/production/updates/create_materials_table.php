<?php namespace Bt\Production\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateMaterialsTable extends Migration
{
    public function up()
     {
        Schema::create('bt_production_materials', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('user_id')->unsigned()->nullable()->index();
            $table->integer('pipe_id')->nullable()->unsigned();
            $table->integer('part_name_id')->unsigned()->nullable()->index();
            $table->integer('mixratio')->unsigned();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_production_materials');
    }
}
