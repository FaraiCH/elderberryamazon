<?php namespace Bt\Finance\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

/**
 * CreateRequestPOsTable Migration
 */
class CreateRequestPOsTable extends Migration
{
    public function up()
    {
        Schema::create('bt_finance_request_p_os', function (Blueprint $table) {
            $table->increments('id');
            $table->string('suppliername')->nullable();
            $table->date('exp_date')->nullable();
            $table->decimal('total_amount_incvat', 15, 2)->nullable();
            $table->integer('supplier_id')->unsigned()->nullable()->index();
            $table->integer('created_by')->unsigned()->nullable()->index();
            $table->integer('updated_by')->unsigned()->nullable()->index();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_finance_request_p_os');
    }
}
