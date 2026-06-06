<?php namespace Bt\Production\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateJobcardMaterialsTable extends Migration
{
    public function up()
    {
        Schema::create('bt_production_jobcard_materials', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('jobcard_id')->unsigned()->nullable()->index();
            $table->integer('raw_material_receivings_id')->unsigned()->nullable()->index();
            $table->integer('kg')->nullable();
            $table->text('note')->nullable();
            $table->integer('created_by')->unsigned()->nullable()->index();
            $table->integer('updated_by')->unsigned()->nullable()->index();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_production_jobcard_materials');
    }
}
