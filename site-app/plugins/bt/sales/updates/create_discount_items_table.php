<?php namespace Bt\Sales\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

/**
 * CreateDiscountItemsTable Migration
 */
class CreateDiscountItemsTable extends Migration
{
    public function up()
    {
        Schema::create('bt_sales_discount_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order')->default(1);
            $table->string('name')->nullable();
            $table->decimal('discount', 15, 2)->nullable();
            $table->boolean('active')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_sales_discount_items');
    }
}
