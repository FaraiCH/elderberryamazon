<?php namespace Bt\Sales\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

/**
 * CreateStockOrdersTable Migration
 */
class CreateStockOrdersTable extends Migration
{
    public function up()
    {
        Schema::create('bt_sales_stock_orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('quote_id')->unsigned()->nullable()->index();
            $table->integer('created_by')->unsigned()->nullable()->index();
            $table->integer('updated_by')->unsigned()->nullable()->index();
            $table->dateTime('deadline_date');
            $table->timestamps();
        });

        Schema::table('bt_sales_stock_orders', function (Blueprint $table){
            $table->dateTime('deadline_date')->change();
            $table->integer('transport_type_id')->unsigned()->nullable()->index();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_sales_stock_orders');
    }
}
