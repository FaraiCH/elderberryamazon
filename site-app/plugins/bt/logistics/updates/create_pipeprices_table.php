<?php namespace Bt\Logistics\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

/**
 * CreatePipepricesTable Migration
 */
class CreatePipepricesTable extends Migration
{
    public function up()
    {
        Schema::dropIfExists('bt_logistics_pipeprices');
        Schema::create('bt_logistics_pipeprices', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('batch_id')->nullable()->unsigned()->index();
            $table->integer('qty')->nullable();
            $table->date('date')->nullable();
            $table->timestamps();
        });
        Schema::table('bt_logistics_pipeprices', function (Blueprint $table){
            $table->integer('unitsproduce')->nullable();
            $table->integer('quote_id')->nullable()->index();
            $table->string('length')->nullable();
            $table->string('pn')->nullable();
            $table->string('product')->nullable();
            $table->string('sdr')->nullable();
            $table->decimal('unitprice', 15, 2)->nullable();
            $table->decimal('totalamount', 15, 2)->nullable();
            $table->decimal('totalproduceamount', 15, 2)->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_logistics_pipeprices');
    }
}
