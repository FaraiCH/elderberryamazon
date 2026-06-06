<?php namespace Bt\Sales\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

/**
 * CreateStockoderitemsTable Migration
 */
class CreateStockoderitemsTable extends Migration
{
    public function up()
    {
        Schema::create('bt_sales_stockoderitems', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('stock_order_id')->nullable()->unsigned();
            $table->integer('pipe_id')->unsigned()->nullable()->index();
            $table->string('description')->nullable();
            $table->integer('units')->unsigned();
            $table->string('unitdescription')->nullable();
            $table->integer('created_by')->unsigned()->nullable()->index();
            $table->integer('updated_by')->unsigned()->nullable()->index();
            $table->decimal('stockweight', 15, 2)->nullable();
            $table->decimal('stockvalue', 15, 2)->nullable();
            $table->integer('quoteitem_id')->nullable()->unsigned();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_sales_stockoderitems');
    }
}
