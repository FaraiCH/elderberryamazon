<?php namespace Bt\Sales\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateCatalogeToSupplierTable extends Migration
{
    public function up()
    {
        Schema::create('bt_sales_catalougue_to_stock', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->integer('catalogue_id')->unsigned();
            $table->integer('supplierstock_id')->unsigned();
            $table->primary(['catalogue_id','supplierstock_id']);
            
        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_sales_catalougue_to_stock');
    }
}
