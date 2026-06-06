<?php namespace Bt\QC\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreatePackToIndicesTable extends Migration
{
    public function up()
    {
        Schema::create('bt_qc_pack_to_indices', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('data_id')->unsigned()->nullable()->index();
            $table->integer('index_id')->unsigned()->nullable()->index();
            $table->integer('created_by')->unsigned()->nullable()->index();
            $table->integer('updated_by')->unsigned()->nullable()->index();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_qc_pack_to_indices');
    }
}
