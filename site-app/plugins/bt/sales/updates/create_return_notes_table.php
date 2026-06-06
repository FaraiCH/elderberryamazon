<?php namespace Bt\Sales\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateReturnNotesTable extends Migration
{
    public function up()
    {
        Schema::create('bt_sales_return_notes', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');

            $table->integer('srn_id')->nullable()->unsigned();
            $table->integer('item_id')->unsigned()->nullable()->index();
            $table->integer('cat_id')->unsigned()->nullable()->index();
            $table->string('note')->nullable();
            $table->integer('units')->unsigned();
        $table->string('unitdescription')->nullable();
            $table->date('return_date')->nullable();
            $table->integer('created_by')->unsigned()->nullable()->index();
            $table->integer('updated_by')->unsigned()->nullable()->index();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_sales_return_notes');
    }
}
