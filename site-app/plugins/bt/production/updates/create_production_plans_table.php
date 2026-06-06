<?php namespace Bt\Production\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateProductionPlansTable extends Migration
{
    public function up()
    {
        Schema::create('bt_production_production_plans', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('line_id')->unsigned()->nullable()->index();
            $table->integer('size')->nullable()->default(0);
            $table->datetime('startdate')->nullable();
            $table->datetime('enddate')->nullable();
            $table->string('comments')->nullable();
            $table->decimal('changeover_hours', 15, 2)->nullable()->default(3);
            $table->integer('created_by')->unsigned()->nullable()->index();
            $table->integer('updated_by')->unsigned()->nullable()->index();
            $table->integer('status_id')->nullable()->default(1);
            $table->timestamps();
        });

        Schema::table('bt_production_production_plans', function (Blueprint $table){
            $table->integer('type')->nullable()->default(0);
        });


    }

    public function down()
    {
        Schema::dropIfExists('bt_production_production_plans');
    }
}
