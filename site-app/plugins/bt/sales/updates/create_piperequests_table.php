<?php namespace Bt\Sales\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

/**
 * CreatePiperequestsTable Migration
 */
class CreatePiperequestsTable extends Migration
{
    public function up()
    {
        Schema::dropIfExists('bt_sales_piperequests');
        Schema::create('bt_sales_piperequests', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('from_quote_id')->nullable()->unsigned()->index();
            $table->integer('to_quote_id')->nullable()->unsigned()->index();
            $table->integer('quote_item_id')->nullable();
            $table->integer('qty')->nullable()->index();
            $table->integer('created_by')->unsigned()->nullable()->index();
            $table->integer('updated_by')->unsigned()->nullable()->index();
            $table->string('note')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_sales_piperequests');
    }
}
