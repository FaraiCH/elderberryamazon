<?php namespace Bt\Inventory\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreatePointEntriesTable extends Migration
{
    public function up()
    {
        Schema::create('bt_inventory_point_entries', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('user_id')->unsigned()->nullable()->index();
            
            $table->integer('inventory_type')->unsigned()->nullable()->index();
            $table->integer('point_of_entry')->unsigned()->nullable()->index();
            
            $table->string('truck_number_plate')->nullable();
            $table->string('container_number')->nullable();
            $table->date('date_of_receipt')->nullable();
           
            $table->integer('processed')->default(0); 
            $table->string('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_inventory_point_entries');
    }
}
