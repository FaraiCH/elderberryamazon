<?php namespace Bt\Finance\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

/**
 * CreatePettyCashApprovesTable Migration
 */
class CreatePettyCashApprovesTable extends Migration
{
    public function up()
    {
        Schema::create('bt_finance_petty_cash_approves', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('pettycash_id')->unsigned()->nullable()->index();
            $table->integer('status_id')->nullable()->unsigned();
            $table->integer('created_by')->unsigned()->nullable()->index();
            $table->integer('updated_by')->unsigned()->nullable()->index();
            $table->timestamps();
        });
        

    }

    public function down()
    {
        Schema::dropIfExists('bt_finance_petty_cash_approves');
    }
}
