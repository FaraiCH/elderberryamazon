<?php namespace Bt\Inventory\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateBuyOutsTable extends Migration
{
    public function up()
    {
        Schema::dropIfExists('bt_inventory_buy_outs');
        Schema::create('bt_inventory_buy_outs', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('quote_id')->nullable()->index();
            $table->datetime('date_received')->nullable();
            $table->string('invoice_no')->nullable()->index();
            $table->text('items')->nullable();
            $table->text('damageditems')->nullable();
            $table->text('comments')->nullable();
            $table->string('ponumber')->nullable();

            $table->integer('created_by')->unsigned()->nullable()->index();
            $table->integer('updated_by')->unsigned()->nullable()->index();
            $table->integer('supplier_id')->unsigned()->nullable()->index();

            $table->timestamps();
        });

    }

    public function down()
    {
        Schema::dropIfExists('bt_inventory_buy_outs');
    }
}
