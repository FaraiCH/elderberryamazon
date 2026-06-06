<?php namespace Bt\Production\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateBtAccountsTable extends Migration
{
    public function up()
    {
        Schema::create('bt_production_bt_accounts', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->datetime('schedule_date')->nullable();
            $table->integer('product_id')->nullable()->unsigned();
            $table->integer('quote_id')->nullable()->unsigned();
            $table->integer('fromschedule_id')->nullable()->unsigned();
            $table->integer('push_id')->nullable()->unsigned();
            $table->integer('schedule_id')->nullable()->unsigned();
            $table->integer('pipe_id')->nullable()->unsigned();
            $table->decimal('priceperkg', 15, 2)->nullable();
            $table->integer('units')->unsigned();
            $table->decimal('unitlength', 15, 2)->nullable();
            $table->text('notes')->nullable();
            $table->text('description')->nullable();
            $table->integer('created_by')->unsigned()->nullable()->index();
            $table->integer('updated_by')->unsigned()->nullable()->index();

            $table->timestamps();
            $table->integer('catalogueitem_id')->unsigned()->nullable()->index();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_production_bt_accounts');
    }
}
