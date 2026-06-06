<?php namespace Bt\Inventory\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

/**
 * CreateBagBatchesTable Migration
 */
class CreateBagBatchesTable extends Migration
{
    public function up()
    {
        Schema::dropIfExists('bt_inventory_bag_batches');
        Schema::create('bt_inventory_bag_batches', function (Blueprint $table) {
             $table->increments('id');
             $table->integer('raw_material_receiving_id')->unsigned()->nullable()->index();
             $table->foreign('raw_material_receiving_id')->references('id')->on('bt_inventory_raw_material_receivings')->onDelete('cascade');
             $table->string('bags');
             $table->decimal('weight', 15, 2);
             $table->decimal('actual_weight', 15, 2);
             $table->string('batch_number');
             $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_inventory_bag_batches');
    }
}
