<?php namespace Bt\Sales\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

/**
 * CreateTransportRatesDestinationsTable Migration
 */
class CreateTransportRatesDestinationsTable extends Migration
{
    public function up()
    {
        Schema::create('bt_sales_transport_rates_destinations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->integer('kilometers')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_sales_transport_rates_destinations');
    }
}
