<?php namespace Bt\Production\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreatePipesTable extends Migration
{
    public function up()
    {
        Schema::create('bt_production_pipes', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('quoteitem_id')->nullable()->unsigned();
            $table->integer('push_id')->nullable()->unsigned();

            $table->integer('pipe_target_weight')->unsigned();
            $table->integer('line_id')->unsigned();

            $table->integer('production_rate')->unsigned();
            $table->integer('target_scrap_rate')->unsigned();
            $table->integer('target_availability')->unsigned();
            $table->integer('changeover_days')->unsigned();
            $table->date('start_date')->nullable();
            $table->date('due_date')->nullable();

            $table->timestamps();
        });

        Schema::table('bt_production_pipes', function(Blueprint $table) {
            $table->integer('created_by')->unsigned()->nullable()->index();
            $table->integer('updated_by')->unsigned()->nullable()->index();
        });

         Schema::table('bt_production_pipes', function(Blueprint $table) {
            $table->integer('original_items_count')->nullable()->default(0);
            $table->integer('hide_expected_scrap')->nullable()->default(0);
         });


    }

    public function down()
    {
        Schema::dropIfExists('bt_production_pipes');
    }
}
