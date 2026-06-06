<?php namespace Bt\Production\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreatePurchasesTable extends Migration
{
    public function up()
    {
        Schema::create('bt_production_purchases', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('quote_id')->nullable()->index();
            $table->string('client_name')->nullable();
            $table->string('supplier_id')->nullable();

            $table->timestamps();
        });

        Schema::table('bt_production_purchases', function (Blueprint $table){
            $table->integer('vat')->nullable()->default(0);
            $table->date('purchase_date')->nullable();
            $table->date('del_date')->nullable();
            $table->decimal('vat_amount', 15, 2)->nullable();
            $table->decimal('exclusive', 15, 2)->nullable();
            $table->decimal('total', 15, 2)->nullable();
            $table->string('supplier_name')->nullable();
            $table->string('status')->nullable();

            $table->string('order_no')->nullable();
            $table->string('reference')->nullable();
            $table->string('comment')->nullable();
        });
    }


    public function down()
    {
        Schema::dropIfExists('bt_production_purchases');
    }
}
