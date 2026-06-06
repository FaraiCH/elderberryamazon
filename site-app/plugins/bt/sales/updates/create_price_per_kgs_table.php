<?php namespace Bt\Sales\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreatePricePerKgsTable extends Migration
{
    public function up()
    {
        Schema::create('bt_sales_price_per_kgs', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('user_id')->nullable()->unsigned();
            $table->decimal('amount', 15, 2)->nullable();
            $table->integer('active')->unsigned();
            $table->timestamps();
        });

        Schema::table('bt_sales_price_per_kgs', function(Blueprint $table) {

            $table->integer('created_by')->unsigned()->nullable()->index();
            $table->integer('updated_by')->unsigned()->nullable()->index();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_sales_price_per_kgs');
    }
}
