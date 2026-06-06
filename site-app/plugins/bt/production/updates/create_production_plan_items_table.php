<?php namespace Bt\Production\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateProductionPlanItemsTable extends Migration
{
    public function up()
    {
        Schema::create('bt_production_production_plan_items', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('plan_id')->unsigned()->nullable()->index();
            $table->integer('quote_id')->unsigned()->nullable()->index();
            $table->integer('item_id')->unsigned()->nullable()->index();
            $table->integer('length')->nullable()->default(0);
            $table->integer('qty')->nullable()->default(0);
            $table->decimal('weight_pm', 15, 2)->nullable()->default(3);
            $table->integer('prodorder')->nullable()->default(0);
            

            $table->integer('created_by')->unsigned()->nullable()->index();
            $table->integer('updated_by')->unsigned()->nullable()->index();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_production_production_plan_items');
    }
}
