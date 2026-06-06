<?php namespace Bt\Finance\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateRequisitionsTable extends Migration
{
    public function up()
    {
        Schema::create('bt_finance_requisitions', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('suppliername')->nullable();
            $table->date('req_date')->nullable();
            $table->text('description')->nullable();
            $table->decimal('amount', 15, 2)->nullable();

            $table->integer('requestedby_id')->unsigned()->nullable()->index();
            $table->integer('linemanager_id')->unsigned()->nullable()->index();

            $table->integer('created_by')->unsigned()->nullable()->index();
            $table->integer('updated_by')->unsigned()->nullable()->index();

            $table->timestamps();
            $table->integer('project_id')->unsigned()->nullable()->default(1)->index();
            $table->integer('expense')->nullable();
            $table->integer('expense_options')->nullable();
            $table->string('other')->nullable();
            $table->integer('req_project_id')->nullable();
            $table->integer('currencytype_id')->default(1)->nullable();
            $table->decimal('currentexchange_rate', 15, 2)->nullable();
            $table->decimal('amount_other_currency', 15, 2)->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_finance_requisitions');
    }
}
