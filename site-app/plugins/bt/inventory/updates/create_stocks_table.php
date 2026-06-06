<?php namespace Bt\Inventory\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateStocksTable extends Migration
{
    public function up()
    {
        Schema::create('bt_inventory_stocks', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('user_id')->unsigned()->nullable()->index();
           
            $table->string('truck_number_plate')->nullable();
            $table->string('container_number')->nullable();
            $table->date('date_of_receipt')->nullable();
            $table->integer('part_name_id')->unsigned()->nullable()->index();
            $table->integer('received_in')->unsigned()->nullable()->index();
            $table->integer('bagsother')->unsigned()->nullable()->index();
            $table->string('supplier_batch')->nullable();            
            $table->integer('instock')->default(1);
            $table->integer('weight_pallets')->default(0);
            $table->string('notes')->nullable();  

            $table->integer('stock_out_id')->unsigned()->nullable()->index();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_inventory_stocks');
    }
}
