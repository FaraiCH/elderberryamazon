<?php namespace Bt\Inventory\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

/**
 * CreateBlendedPurchasesTable Migration
 */
class CreateBlendedPurchasesTable extends Migration
{
    public function up()
    {
        Schema::create('bt_inventory_blended_purchases', function (Blueprint $table) {
        $table->increments('id');
        $table->date('locked_date')->nullable();
        $table->date('end_date')->nullable();
        $table->decimal('price', 15, 2)->nullable();
        $table->boolean('is_locked')->default(false);
        $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_inventory_blended_purchases');
    }
}
