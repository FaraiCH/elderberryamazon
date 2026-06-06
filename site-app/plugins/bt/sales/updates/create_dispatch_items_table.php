<?php namespace Bt\Sales\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

/**
 * CreateDispatchItemsTable Migration
 */
class CreateDispatchItemsTable extends Migration
{
    public function up()
    {
        Schema::create('bt_sales_dispatch_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('quote_id')->nullable()->index();
            $table->integer('destination_id')->nullable()->index();
            $table->integer('vehicle_id')->nullable()->index();
            $table->integer('qty')->nullable();
            $table->decimal('unit_price', 15, 2)->nullable();
            $table->decimal('total', 15, 2)->nullable();
            $table->timestamps();
        });

        Schema::table('bt_sales_dispatch_items', function (Blueprint $table){
            $table->decimal('vihicle_load_weight', 15, 2)->nullable();
            $table->decimal('vehicle_load_min_lenth', 15, 2)->nullable();
            $table->decimal('vehicle_load_max_length', 15, 2)->nullable();
$table->integer('danages_required')->nullable()->default(0);
            $table->string('vehicle_type')->nullable();
            $table->decimal('rate_per_transport')->nullable()->default(0.00);
            $table->integer('hide')->nullable()->default(0);
            $table->decimal('discount')->nullable()->default(0.00);
            $table->text('comment')->nullable();
            $table->integer('created_by')->unsigned()->nullable()->index();
            $table->integer('updated_by')->unsigned()->nullable()->index();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_sales_dispatch_items');
    }
}
