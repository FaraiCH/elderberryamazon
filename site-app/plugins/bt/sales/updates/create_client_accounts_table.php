<?php namespace Bt\Sales\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateClientAccountsTable extends Migration
{
    public function up()
    {
        Schema::create('bt_sales_client_accounts', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('client_id')->unsigned()->nullable()->index();
            $table->integer('quote_id')->unsigned()->nullable()->index();
            $table->decimal('amount', 15, 2)->nullable();
            $table->text('note')->nullable();
            $table->integer('created_by')->unsigned()->nullable()->index();
            $table->integer('updated_by')->unsigned()->nullable()->index();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_sales_client_accounts');
    }
}
