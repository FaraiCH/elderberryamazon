<?php namespace Bt\Sales\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

/**
 * CreateQuoteProductionPlansTable Migration
 */
class CreateQuoteProductionPlansTable extends Migration
{
    public function up()
    {
        Schema::create('bt_sales_quote_production_plans', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('isbtproduct')->default(true);
            $table->integer('quote_id')->nullable()->unsigned();

            $table->integer('reason_id')->nullable()->unsigned();

            $table->integer('quoteitem_id')->unsigned()->nullable()->index();
            $table->integer('quotecatitem_id')->unsigned()->nullable()->index();
            $table->integer('units')->unsigned();
            $table->text('notes')->nullable();
            $table->date('schedule_date')->nullable();


            $table->integer('created_by')->unsigned()->nullable()->index();
            $table->integer('updated_by')->unsigned()->nullable()->index();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_sales_quote_production_plans');
    }
}
