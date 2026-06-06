<?php namespace Bt\JSEData\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreatePropertiesTable extends Migration
{
    public function up()
    {
        Schema::create('bt_jsedata_properties', function (Blueprint $table) {
        $table->engine = 'InnoDB';
        $table->increments('id');
        $table->string('name')->nullable();
            $table->string('altnamea')->nullable();
            $table->string('altnameb')->nullable();
            $table->string('altnamec')->nullable();
        $table->integer('parent_id')->nullable();
        $table->integer('sort_order')->default(0);
        $table->integer('created_by')->unsigned()->nullable()->index();
        $table->integer('updated_by')->unsigned()->nullable()->index();
        $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_jsedata_properties');
    }
}
