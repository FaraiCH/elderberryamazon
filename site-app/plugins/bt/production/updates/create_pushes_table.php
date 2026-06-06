<?php namespace Bt\Production\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreatePushesTable extends Migration
{
    public function up()
    {
        Schema::create('bt_production_pushes', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('user_id')->unsigned()->nullable()->index();
            $table->integer('quote_id')->nullable()->unsigned();
            $table->integer('status_id')->unsigned();
            $table->date('date_of_accepted')->nullable();
            $table->date('date_of_completed')->nullable();
            $table->timestamps();
        });
        Schema::table('bt_production_pushes', function(Blueprint $table) {
$table->integer('created_by')->unsigned()->nullable()->index();
$table->integer('updated_by')->unsigned()->nullable()->index();
            $table->integer('blendedprice_id')->unsigned()->nullable()->index();
          
        });

    }

    public function down()
    {
        Schema::dropIfExists('bt_production_pushes');
    }
}
