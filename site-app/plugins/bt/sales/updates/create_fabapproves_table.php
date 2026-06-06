<?php namespace Bt\Sales\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

/**
 * CreateFabapprovesTable Migration
 */
class CreateFabapprovesTable extends Migration
{
    public function up()
    {
        Schema::create('bt_sales_fabapproves', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('fabrication_id')->unsigned()->nullable()->index();
            $table->integer('status_id')->nullable()->unsigned();
            $table->integer('created_by')->unsigned()->nullable()->index();
            $table->integer('updated_by')->unsigned()->nullable()->index();
            $table->string('note')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_sales_fabapproves');
    }
}
