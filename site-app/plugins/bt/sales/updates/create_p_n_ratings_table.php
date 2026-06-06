<?php namespace Bt\Sales\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreatePNRatingsTable extends Migration
{
    public function up()
    {
        Schema::create('bt_sales_p_n_ratings', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name')->nullable(); 
            $table->string('sdr')->nullable(); 
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_sales_p_n_ratings');
    }
}
