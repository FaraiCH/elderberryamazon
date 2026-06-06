<?php namespace Bt\Inventory\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateRequestMaterialsTable extends Migration
{
    public function up()
    {
        Schema::create('bt_inventory_request_materials', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('raw_material_receivings_id')->unsigned()->nullable()->index();
            $table->integer('release_reason_id')->unsigned()->nullable()->index();
            $table->datetime('requesteddate')->nullable();
            $table->string('supplier_batch')->nullable();  
            $table->decimal('kg', 15, 1)->nullable()->default(0);
            $table->string('notes')->nullable();
            $table->integer('created_by')->unsigned()->nullable()->index();
            $table->integer('updated_by')->unsigned()->nullable()->index();
            $table->timestamps();
        });
        
    }

    public function down()
    {
        Schema::dropIfExists('bt_inventory_request_materials');
    }
}
