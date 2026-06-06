<?php namespace Bt\Finance\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

/**
 * CreateResponsePOsTable Migration
 */
class CreateResponsePOsTable extends Migration
{
    public function up()
    {
        Schema::create('bt_finance_response_p_os', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('requestpo_id')->unsigned()->nullable()->index();
            $table->string('po_number')->nullable();
            $table->date('date_created')->nullable();
            $table->integer('created_by')->unsigned()->nullable()->index();
            $table->integer('updated_by')->unsigned()->nullable()->index();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_finance_response_p_os');
    }
}
