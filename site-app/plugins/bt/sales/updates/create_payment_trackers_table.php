<?php namespace Bt\Sales\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreatePaymentTrackersTable extends Migration
{
    public function up()
    {
        Schema::create('bt_sales_payment_trackers', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->timestamps();
            $table->integer('quote_id')->unsigned()->nullable()->index();
            $table->decimal('amount', 15, 2)->nullable();
            $table->date('payment_date')->nullable();
            $table->text('comment')->nullable();
            $table->integer('created_by')->unsigned()->nullable()->index();
            $table->integer('updated_by')->unsigned()->nullable()->index();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_sales_payment_trackers');
    }
}
