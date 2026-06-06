<?php namespace Bt\Sales\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

/**
 * CreateLogisticsignaturesTable Migration
 */
class CreateLogisticsignaturesTable extends Migration
{
    public function up()
    {

        Schema::create('bt_sales_logisticsignatures', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('srn_id')->unsigned()->nullable()->index();
            $table->integer('status_id')->nullable()->unsigned();
            $table->string('note')->nullable();
            $table->integer('created_by')->unsigned()->nullable()->index();
            $table->integer('updated_by')->unsigned()->nullable()->index();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_sales_logisticsignatures');
    }
}
