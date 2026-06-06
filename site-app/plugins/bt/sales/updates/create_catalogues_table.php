<?php namespace Bt\Sales\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateCataloguesTable extends Migration
{
    public function up()
    {
        Schema::create('bt_sales_catalogues', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('description')->nullable();
            $table->decimal('price', 15, 2)->nullable();
            $table->integer('active')->default(1);
            $table->timestamps();
        });

         Schema::table('bt_sales_catalogues', function(Blueprint $table) {
$table->decimal('buyprice', 15, 2)->nullable();
            $table->integer('product_id')->unsigned()->nullable()->index();
$table->integer('suplier_id')->unsigned()->nullable()->index();
            $table->string('size')->nullable();
            $table->string('name', 500)->nullable()->change();
            $table->integer('qty')->default(1);
            $table->date('next_price_date')->nullable();
            $table->text('imageurl')->nullable();
            $table->integer('gp')->default(25);
            $table->integer('bt_product_id')->nullable()->unsigned();
            $table->decimal('bt_unitlength', 15, 2)->nullable();
            $table->integer('production_required')->default(0);
            $table->decimal('priceperkg', 15, 2)->nullable();
             $table->string('suffix')->nullable();
         });
    }

    public function down()
    {
        Schema::dropIfExists('bt_sales_catalogues');
    }
}
