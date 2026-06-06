<?php namespace Bt\Sales\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateSrnItemsTable extends Migration
{
    public function up()
    {
        Schema::create('bt_sales_srn_items', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('srn_id')->nullable()->unsigned();
            $table->integer('pipe_id')->unsigned()->nullable()->index();
            $table->string('description')->nullable();
            $table->integer('units')->unsigned();
            $table->string('unitdescription')->nullable();
            $table->integer('created_by')->unsigned()->nullable()->index();
            $table->integer('updated_by')->unsigned()->nullable()->index();
            $table->timestamps();
            $table->decimal('stockweight', 15, 2)->nullable();
            $table->decimal('stockvalue', 15, 2)->nullable();
            $table->integer('quoteitem_id')->nullable()->unsigned();
            $table->integer('pickslip_id')->nullable()->unsigned();
            $table->dropColumn('pickslip_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_sales_srn_items');
    }
}
