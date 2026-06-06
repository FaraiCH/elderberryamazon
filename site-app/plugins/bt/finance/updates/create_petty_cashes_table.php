<?php namespace Bt\Finance\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

/**
 * CreatePettyCashesTable Migration
 */
class CreatePettyCashesTable extends Migration
{
    public function up()
    {
        Schema::create('bt_finance_petty_cashes', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('paymenttype_id')->unsigned()->nullable()->index();
            $table->text('subject');
            $table->date('date')->nullable();
            $table->string('message')->nullable();
            $table->decimal('amount', 15, 2)->nullable();
            $table->text('comments');
            $table->integer('requestedby_id')->unsigned()->nullable()->index();
            $table->integer('approvedby_id')->unsigned()->nullable()->index();
            $table->integer('created_by')->unsigned()->nullable()->index();
            $table->integer('updated_by')->unsigned()->nullable()->index();
            $table->timestamps();

            $table->integer('is_completed')->nullable()->default(0);
            $table->integer('active')->nullable()->default(1);
            $table->decimal('amount_left', 15, 2)->nullable();
            $table->string('requested_to')->nullable();
            $table->integer('response')->nullable()->default(0);
            $table->integer('cancel')->nullable()->default(0);
            $table->integer('linemanager_id')->nullable()->index();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_finance_petty_cashes');
    }
}
