<?php namespace Bt\Finance\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

/**
 * CreatePaymentTypesTable Migration
 */
class CreatePaymentTypesTable extends Migration
{
    public function up()
    {
        Schema::create('bt_finance_payment_types', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name')->nullable();
            $table->timestamps();
        });

    }

    public function down()
    {
        Schema::dropIfExists('bt_finance_payment_types');
    }
}
