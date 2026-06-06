<?php namespace Bt\Sales\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

/**
 * CreateDeliveryItemsTable Migration
 */
class CreateDeliveryItemsTable extends Migration
{
    public function up()
    {
        Schema::create('bt_sales_delivery_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('plan_id')->nullable()->unsigned();
            $table->integer('quoteitem_id')->unsigned()->nullable()->index();
            $table->string('notes')->nullable();
            $table->integer('units')->unsigned();

            $table->integer('created_by')->unsigned()->nullable()->index();
            $table->integer('updated_by')->unsigned()->nullable()->index();
            $table->timestamps();
        });

    }

    public function down()
    {
        Schema::dropIfExists('bt_sales_delivery_items');
    }
}
