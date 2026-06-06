<?php namespace Bt\Factory\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateAssettypesTable extends Migration
{
    public function up()
    {
        Schema::create('bt_factory_assettypes', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('assettype')->nullable();
            $table->string('brand')->nullable();
            $table->string('specification')->nullable();
            $table->integer('quantity')->nullable();
            $table->integer('haswarranty')->nullable();
            $table->string('description')->nullable();
            $table->integer('created_by')->unsigned()->nullable()->index();
            $table->integer('updated_by')->unsigned()->nullable()->index();
            $table->timestamps();
        });
    }

    public function down()
    {
         Schema::dropIfExists('bt_factory_assettypes');
    }
}
