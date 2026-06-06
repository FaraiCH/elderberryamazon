<?php namespace Bt\Sales\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateQuoteitemsTable extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('bt_sales_quoteitems')) {
            Schema::create('bt_sales_quoteitems', function(Blueprint $table) {
                $table->engine = 'InnoDB';
                $table->increments('id');
                $table->integer('product_id')->nullable()->unsigned();
                $table->integer('quote_id')->nullable()->unsigned();
                $table->string('description', 500)->nullable();
                $table->decimal('price', 15, 2)->nullable();
                $table->decimal('unitprice', 15, 2)->nullable();
                $table->integer('units')->unsigned();
                $table->decimal('unitlength', 15, 2)->nullable();
                $table->decimal('weight', 15, 3)->nullable();
                $table->decimal('totalweight', 15, 3)->nullable();
                $table->integer('created_by')->unsigned()->nullable()->index();
                $table->integer('updated_by')->unsigned()->nullable()->index();
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('bt_sales_quoteitems');
    }
}
