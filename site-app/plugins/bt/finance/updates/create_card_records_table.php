<?php namespace Bt\Finance\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateCardRecordsTable extends Migration
{
    public function up()
    {
        Schema::create('bt_finance_card_records', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');

            $table->integer('project_id')->unsigned()->nullable()->default(1)->index();

            $table->date('purchase_date')->nullable();

            $table->text('items');
            $table->text('comments');

            $table->string('storename')->nullable();

            $table->string('mainitem')->nullable();

            $table->decimal('amount', 15, 2)->nullable();

            $table->integer('purchasedby_id')->unsigned()->nullable()->index();
            $table->integer('approvedby_id')->unsigned()->nullable()->index();

            $table->integer('created_by')->unsigned()->nullable()->index();
            $table->integer('updated_by')->unsigned()->nullable()->index();
            $table->timestamps();

            $table->integer('pettycash_id')->unsigned()->nullable()->index();

        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_finance_card_records');
    }
}
