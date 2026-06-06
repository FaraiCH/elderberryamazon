<?php namespace Bt\Sales\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

/**
 * CreateReasonForReturnsTable Migration
 */
class CreateReasonForReturnsTable extends Migration
{
    public function up()
    {
        Schema::create('bt_sales_reason_for_returns', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_sales_reason_for_returns');
    }
}
