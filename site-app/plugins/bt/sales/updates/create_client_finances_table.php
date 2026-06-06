<?php namespace Bt\Sales\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

/**
 * CreateClientFinancesTable Migration
 */
class CreateClientFinancesTable extends Migration
{
    public function up()
    {
        Schema::create('bt_sales_client_finances', function (Blueprint $table) {
            $table->increments('id');
            $table->string('note');
            $table->integer('client_id')->unsigned()->nullable()->index();
            $table->integer('created_by')->unsigned()->nullable()->index();
            $table->integer('updated_by')->unsigned()->nullable()->index();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_sales_client_finances');
    }
}
