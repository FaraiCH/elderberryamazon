<?php namespace Bt\Finance\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

/**
 * CreatePettyLineApprovesTable Migration
 */
class CreatePettyLineApprovesTable extends Migration
{
    public function up()
    {
        Schema::create('bt_finance_petty_line_approves', function (Blueprint $table) {
             $table->engine = 'InnoDB';
             $table->increments('id');
             $table->integer('petty_cash_id')->unsigned()->nullable()->index();
             $table->integer('status_id')->nullable()->unsigned();
             $table->decimal('price', 15, 2)->nullable();
             $table->integer('created_by')->unsigned()->nullable()->index();
             $table->integer('updated_by')->unsigned()->nullable()->index();
             $table->string('note')->nullable();
             $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_finance_petty_line_approves');
    }
}
