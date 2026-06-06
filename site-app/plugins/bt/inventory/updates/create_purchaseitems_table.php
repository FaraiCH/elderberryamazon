<?php namespace Bt\Inventory\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreatePurchaseitemsTable extends Migration
{
    public function up()
    {
        Schema::create('bt_inventory_purchaseitems', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('purchase_id')->nullable()->unsigned();
            $table->string('description')->nullable();
            $table->decimal('weight', 15, 1)->nullable()->default(0);
            $table->decimal('price', 15, 2)->nullable();
            $table->decimal('unitprice', 15, 2)->nullable();  
            $table->integer('units')->unsigned(); 

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_inventory_purchaseitems');
    }
}
