<?php namespace Bt\Sales\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

/**
 * CreateStockoderitemcataloguesTable Migration
 */
class CreateStockoderitemcataloguesTable extends Migration
{
    public function up()
    {
        Schema::create('bt_sales_stockoderitemcatalogues', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('stock_order_id')->nullable()->unsigned();
            $table->integer('quotecat_id')->nullable()->unsigned();
            $table->integer('units')->unsigned();
            $table->integer('created_by')->unsigned()->nullable()->index();
            $table->integer('updated_by')->unsigned()->nullable()->index();
            $table->decimal('stockvalue', 15, 2)->nullable();
            $table->decimal('stockweight', 15, 2)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_sales_stockoderitemcatalogues');
    }
}
