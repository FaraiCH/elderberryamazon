<?php namespace Bt\Production\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreatePurchaseitemsTable extends Migration
{
    public function up()
    {
        Schema::create('bt_production_purchaseitems', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('item_id')->nullable()->index();
            $table->integer('purchase_id')->nullable()->index();
            $table->string('description')->nullable()->index();
            $table->integer('units')->nullable()->index();
            $table->decimal('sell_price', 15, 2 )->nullable()->index();
            $table->decimal('buy_price', 15, 2)->nullable()->index();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_production_purchaseitems');
    }
}
