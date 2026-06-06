<?php namespace Bt\Inventory\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreatePurchasesTable extends Migration
{
    public function up()
    {
        Schema::create('bt_inventory_purchases', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->date('date_of_puchase')->nullable();
            $table->date('expected_date_of_receipt')->nullable();
            $table->string('supplier_name')->nullable();
            $table->string('supplier_batch')->nullable();
            $table->string('product_code')->nullable();
            $table->integer('part_name_id')->unsigned()->nullable()->index();
            $table->decimal('weight', 15, 1)->nullable()->default(0);
            $table->string('notes')->nullable();
            $table->decimal('mfi', 15, 2)->nullable()->default(0);
            $table->decimal('price', 15, 2)->nullable();
            $table->decimal('transportcost', 15, 2)->nullable();
            $table->timestamps();
        });
        Schema::table('bt_inventory_purchases', function(Blueprint $table) {
            $table->string('productnames')->nullable();
            $table->string('productscodes')->nullable();
        });

         Schema::table('bt_inventory_purchases', function(Blueprint $table) {
$table->decimal('vat', 15, 2)->nullable();
$table->string('po_number')->nullable();
$table->integer('is_completed')->nullable()->default(0);
             $table->decimal('pricekg', 15, 2)->nullable()->default(0);
            $table->decimal('price_excl', 15, 2)->nullable();

         });



    }

    public function down()
    {
        Schema::dropIfExists('bt_inventory_purchases');
    }
}
