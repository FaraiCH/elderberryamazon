<?php namespace Bt\Inventory\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateStockOutsTable extends Migration
{
    public function up()
    {
        Schema::create('bt_inventory_stock_outs', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('user_id')->unsigned()->nullable()->index();            
            $table->string('ids')->nullable();
            $table->string('notes')->nullable();            
            $table->date('stockout_date')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_inventory_stock_outs');
    }
}
