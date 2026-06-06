<?php namespace Bt\Floor\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateDeliveryClientPipesTable extends Migration
{
    public function up()
    {
        Schema::create('bt_floor_delivery_client_pipes', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');

            $table->date('schedule_date')->nullable();
            $table->string('client')->nullable();
            $table->string('address')->nullable();
            $table->string('truck_number_plate')->nullable();
            $table->string('pipedescription')->nullable();    
            $table->decimal('weight_kg', 15, 1)->nullable()->default(0);
            $table->integer('quantity')->nullable()->default(1);
            $table->string('notes')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_floor_delivery_client_pipes');
    }
}
