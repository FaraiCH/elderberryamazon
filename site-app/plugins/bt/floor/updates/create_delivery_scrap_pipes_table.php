<?php namespace Bt\Floor\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateDeliveryScrapPipesTable extends Migration
{
    public function up()
    {
        Schema::create('bt_floor_delivery_scrap_pipes', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');

            $table->date('schedule_date')->nullable();
            $table->string('company')->nullable();
            $table->string('address')->nullable();
            $table->string('truck_number_plate')->nullable();
            $table->decimal('weight_kg', 15, 1)->nullable()->default(0);
            $table->decimal('floor_kg', 15, 1)->nullable()->default(0);
            $table->string('notes')->nullable();
            $table->integer('created_by')->unsigned()->nullable()->index();
            $table->integer('updated_by')->unsigned()->nullable()->index();
            $table->timestamps();

            $table->decimal('supplier_qty', 15, 1)->nullable()->default(0);
            $table->decimal('supplier_price_kg', 15, 2)->nullable()->default(0);
            $table->decimal('supplier_total', 15, 2)->nullable()->default(0);
            $table->decimal('supplier_vat', 15, 2)->nullable()->default(0);
            $table->decimal('supplier_totalincvat', 15, 2)->nullable()->default(0);

        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_floor_delivery_scrap_pipes');
    }
}
