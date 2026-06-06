<?php namespace Bt\QC\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateNcrprepparesTable extends Migration
{
    public function up()
    {
        Schema::create('bt_qc_ncrpreppares', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');

            $table->integer('ncr_id')->unsigned()->nullable()->index();
            $table->integer('status_id')->nullable()->unsigned();
            $table->integer('created_by')->unsigned()->nullable()->index();
            $table->integer('updated_by')->unsigned()->nullable()->index();
            $table->string('note')->nullable();
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_qc_ncrpreppares');
    }
}
