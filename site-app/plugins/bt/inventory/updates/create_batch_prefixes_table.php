<?php namespace Bt\Inventory\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

/**
 * CreateBatchPrefixesTable Migration
 */
class CreateBatchPrefixesTable extends Migration
{
    public function up()
    {
        Schema::dropIfExists('bt_inventory_batch_prefixes');
        Schema::create('bt_inventory_batch_prefixes', function (Blueprint $table) {
             $table->increments('id');
             $table->string('prefix')->unique();
             $table->string('description')->nullable();
             $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_inventory_batch_prefixes');
    }
}
