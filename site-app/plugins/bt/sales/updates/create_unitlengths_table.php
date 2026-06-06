<?php namespace Bt\Sales\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateUnitlengthsTable extends Migration
{
    public function up()
    {
        Schema::create('bt_sales_unitlengths', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('value')->unsigned(); 
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_sales_unitlengths');
    }
}
