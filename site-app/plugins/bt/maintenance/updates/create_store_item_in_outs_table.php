<?php namespace Bt\Maintenance\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

/**
 * CreateStoreItemInOutsTable Migration
 */
class CreateStoreItemInOutsTable extends Migration
{
    public function up()
    {
        Schema::create('bt_maintenance_store_item_in_outs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('quantity')->nullable();
            $table->integer('in_out_status_status_id')->nullable()->default(1);
            $table->integer('storeproductitem_id')->unsigned()->nullable()->index();
            $table->integer('created_by')->unsigned()->nullable()->index();
            $table->integer('updated_by')->unsigned()->nullable()->index();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_maintenance_store_item_in_outs');
    }
}
