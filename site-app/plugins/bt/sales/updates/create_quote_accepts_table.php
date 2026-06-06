<?php namespace Bt\Sales\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

/**
 * CreateQuoteAcceptsTable Migration
 */
class CreateQuoteAcceptsTable extends Migration
{
    public function up()
    {
        Schema::create('bt_sales_quote_accepts', function (Blueprint $table) {
            $table->increments('id');
            $table->dateTime('accept');
            $table->integer('quote_id')->unsigned()->index();
            $table->string('ip_address');
            $table->string('location');
            $table->string('first_name');
            $table->string('last_name');
            $table->timestamps();
        });

    }
    public function down()
    {
        Schema::dropIfExists('bt_sales_quote_accepts');

    }
}
