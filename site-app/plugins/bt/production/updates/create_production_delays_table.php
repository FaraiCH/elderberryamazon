<?php namespace Bt\Production\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;
use function GuzzleHttp\default_ca_bundle;

class CreateProductionDelaysTable extends Migration
{
    public function up()
    {
        Schema::create('bt_production_production_delays', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');

            $table->integer('push_id')->nullable()->unsigned()->index();
            $table->integer('pipe_id')->nullable()->unsigned()->index();
            $table->integer('delayreason_id')->nullable()->unsigned()->index();
            $table->integer('no_pipes')->nullable();
            $table->date('start_date_delay')->nullable();
            $table->date('expected_date_resume')->nullable();
            $table->integer('sales_notify')->nullable()->default(0);
            $table->integer('created_by')->unsigned()->nullable()->index();
            $table->integer('updated_by')->unsigned()->nullable()->index();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_production_production_delays');
    }
}
