<?php namespace Bt\Sales\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateSupplierStocksTable extends Migration
{
    public function up()
    {
        Schema::create('bt_sales_supplier_stocks', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('supplier_id')->unsigned()->nullable()->index();
            $table->string('name')->nullable();
            $table->decimal('price', 15, 2)->nullable();
            $table->text('note')->nullable();
            $table->integer('created_by')->unsigned()->nullable()->index();
            $table->integer('updated_by')->unsigned()->nullable()->index();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_sales_supplier_stocks');
    }
}
