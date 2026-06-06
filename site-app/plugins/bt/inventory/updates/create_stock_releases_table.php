<?php namespace Bt\Inventory\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateStockReleasesTable extends Migration
{
    public function up()
    {
        Schema::create('bt_inventory_stock_releases', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->datetime('datecaptured')->nullable();
            $table->integer('part_name_id')->unsigned()->nullable()->index();
            $table->string('supplier_batch')->nullable();  
            $table->decimal('kg', 15, 1)->nullable()->default(0);
            $table->string('notes')->nullable();
            $table->timestamps();
        });

        Schema::table('bt_inventory_stock_releases', function(Blueprint $table) {
        $table->integer('raw_material_receivings_id')->unsigned()->nullable()->index();
            $table->integer('created_by')->unsigned()->nullable()->index();
            $table->integer('updated_by')->unsigned()->nullable()->index();
        });
        Schema::table('bt_inventory_stock_releases', function(Blueprint $table) {
            $table->integer('release_reason_id')->unsigned()->nullable()->index();
      
        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_inventory_stock_releases');
    }
}
