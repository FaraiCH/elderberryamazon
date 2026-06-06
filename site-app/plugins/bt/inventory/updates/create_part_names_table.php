<?php namespace Bt\Inventory\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreatePartNamesTable extends Migration
{
    public function up()
    {
        Schema::create('bt_inventory_part_names', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name')->nullable();
            $table->timestamps();
        });
        Schema::table('bt_inventory_part_names', function(Blueprint $table) {
            $table->integer('supplier_id')->unsigned()->nullable()->index();
            $table->integer('created_by')->unsigned()->nullable()->index();
            $table->integer('updated_by')->unsigned()->nullable()->index();
        });

        Schema::table('bt_inventory_part_names', function(Blueprint $table) {
            $table->integer('cat_id')->unsigned()->nullable()->index();
           
        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_inventory_part_names');
    }
}
