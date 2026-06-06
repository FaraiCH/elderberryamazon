<?php namespace Bt\Logistics\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateLogisticapprovesTable extends Migration
{
    public function up()
    {
        Schema::create('bt_logistics_logisticapproves', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('schedule_id')->unsigned()->nullable()->index();
            $table->integer('status_approve')->unsigned()->nullable();
            $table->integer('created_by')->unsigned()->nullable()->index();
            $table->integer('updated_by')->unsigned()->nullable()->index();
            $table->timestamps();
        });

    }
    public function down()
    {
        Schema::dropIfExists('bt_logistics_logisticapproves');
    }
}