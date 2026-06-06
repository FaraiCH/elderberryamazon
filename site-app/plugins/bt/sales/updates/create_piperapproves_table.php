<?php namespace Bt\Sales\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

/**
 * CreatePiperapprovesTable Migration
 */
class CreatePiperapprovesTable extends Migration
{
    public function up()
    {
        Schema::dropIfExists('bt_sales_piperapproves');
        Schema::create('bt_sales_piperapproves', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('created_by')->unsigned()->nullable()->index();
            $table->integer('updated_by')->unsigned()->nullable()->index();
            $table->integer('piperequest_id')->unsigned()->nullable()->index();
            $table->integer('approve')->nullable()->default(0);
            $table->string('note')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_sales_piperapproves');
    }
}
