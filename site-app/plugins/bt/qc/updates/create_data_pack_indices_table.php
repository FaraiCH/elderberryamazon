<?php namespace Bt\QC\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateDataPackIndicesTable extends Migration
{
    public function up()
    {
        Schema::create('bt_qc_data_pack_indices', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name')->nullable();
            $table->integer('orderno')->unsigned()->nullable();
            $table->integer('subcatof')->unsigned()->nullable();
            $table->string('description')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_qc_data_pack_indices');
    }
}
