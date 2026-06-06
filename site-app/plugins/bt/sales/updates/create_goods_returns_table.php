<?php namespace Bt\Sales\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

/**
 * CreateGoodsReturnsTable Migration
 */
class CreateGoodsReturnsTable extends Migration
{
    public function up()
    {
        Schema::create('bt_sales_goods_returns', function (Blueprint $table) {
            $table->increments('id');
            $table->date('date')->nullable();
            $table->string('contact')->nullable();
            $table->string('tel_no')->nullable();
            $table->text('items');
            $table->integer('created_by')->unsigned()->nullable()->index();
            $table->integer('updated_by')->unsigned()->nullable()->index();
            $table->integer('client_id')->nullable()->unsigned();
            $table->integer('reasonforreturn_id')->unsigned()->nullable()->index();
            $table->integer('quote_id')->unsigned()->nullable()->index();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_sales_goods_returns');
    }
}
