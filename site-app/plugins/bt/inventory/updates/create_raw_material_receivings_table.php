<?php namespace Bt\Inventory\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateRawMaterialReceivingsTable extends Migration
{
    public function up()
    {
        Schema::create('bt_inventory_raw_material_receivings', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->date('date_of_receipt')->nullable();
            $table->string('container_number')->nullable();
            $table->string('truck_number_plate')->nullable();
            $table->string('supplier_batch')->nullable();   
            $table->integer('part_name_id')->unsigned()->nullable()->index();
            $table->integer('virgin')->default(0);
            $table->integer('regrind')->default(0);
            $table->integer('bags')->default(0);
            $table->decimal('weight', 15, 1)->nullable()->default(0);
            $table->string('notes')->nullable();
            $table->decimal('damagedbags', 15, 1)->nullable()->default(0);
            $table->decimal('mfi', 15, 2)->nullable()->default(0);
            $table->integer('pallet_number')->default(0);
            $table->integer('number_of_trucks')->default(1);
            $table->timestamps();
        });
        Schema::table('bt_inventory_raw_material_receivings', function(Blueprint $table) {
        $table->integer('purchase_id')->unsigned()->nullable()->index();
        $table->string('product_code')->nullable();
            $table->integer('created_by')->unsigned()->nullable()->index();
            $table->integer('updated_by')->unsigned()->nullable()->index();
        });
        Schema::table('bt_inventory_raw_material_receivings', function(Blueprint $table) {
            $table->integer('active')->nullable()->default(1);
            $table->decimal('pricekg', 15, 2)->nullable()->default(0);
        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_inventory_raw_material_receivings');
    }
}
