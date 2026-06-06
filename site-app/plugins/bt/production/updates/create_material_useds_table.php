<?php namespace Bt\Production\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateMaterialUsedsTable extends Migration
{
    public function up()
    {
        Schema::create('bt_production_material_useds', function(Blueprint $table) {
        $table->engine = 'InnoDB';
        $table->increments('id');
        $table->integer('raw_material_receivings_id')->unsigned()->nullable()->index();
        $table->integer('raw_material_release_id')->unsigned()->nullable()->index();
        $table->integer('schedule_id')->unsigned()->nullable()->index();
            $table->decimal('kg', 15, 2)->nullable()->default(0)->change();
        $table->string('note')->nullable();
        $table->integer('created_by')->unsigned()->nullable()->index();
        $table->integer('updated_by')->unsigned()->nullable()->index();
        $table->timestamps();
        $table->integer('backetsorbags')->nullable()->default(0);
        $table->integer('number_backetsorbags')->nullable()->default(0);
        $table->integer('size_backetsorbags')->nullable()->default(0);
        });


    }

    public function down()
    {
        Schema::dropIfExists('bt_production_material_useds');
    }
}
