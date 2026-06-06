<?php namespace Bt\Production\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateLinesTable extends Migration
{
    public function up()
    {
        Schema::create('bt_production_lines', function(Blueprint $table) {

            $table->integer('max_weight')->nullable()->default(0);
            $table->integer('min_weight')->nullable()->default(0);
       $table->integer('online')->nullable()->default(1);
            $table->text('pipes')->nullable();
       $table->integer('capacity')->nullable()->default(0);
       $table->integer('created_by')->unsigned()->nullable()->index();
       $table->integer('updated_by')->unsigned()->nullable()->index();

        });
        Schema::table('bt_production_lines', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name')->nullable();
            $table->timestamps();

            $table->integer('bt_meter_id')->unsigned()->nullable();
            $table->integer('sort_order')->unsigned()->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_production_lines');
    }
}
