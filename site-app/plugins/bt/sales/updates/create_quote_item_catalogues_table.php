<?php namespace Bt\Sales\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateQuoteItemCataloguesTable extends Migration
{
    public function up()
    {
        Schema::create('bt_sales_quote_item_catalogues', function(Blueprint $table) {
$table->engine = 'InnoDB';
$table->increments('id');
$table->integer('product_id')->nullable()->unsigned();
$table->integer('quote_id')->nullable()->unsigned();
$table->string('description')->nullable();
$table->decimal('price', 15, 2)->nullable();
$table->decimal('unitprice', 15, 2)->nullable();
$table->integer('units')->unsigned();

$table->timestamps();

$table->integer('btproduct_id')->nullable()->unsigned();
$table->decimal('unitlength', 15, 2)->nullable();
$table->decimal('weight', 15, 3)->nullable();
$table->decimal('totalweight', 15, 3)->nullable();


        });
        Schema::table('bt_sales_quote_item_catalogues', function(Blueprint $table){
$table->string('description', 500)->nullable()->change();
$table->decimal('priceperkg', 15, 2)->nullable();
$table->decimal('priceweightunit', 15, 2)->nullable();
$table->decimal('priceweighttotal', 15, 2)->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_sales_quote_item_catalogues');
    }
}
