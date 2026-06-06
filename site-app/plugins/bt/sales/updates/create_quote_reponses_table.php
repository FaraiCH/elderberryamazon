<?php namespace Bt\Sales\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateQuoteReponsesTable extends Migration
{
    public function up()
    {
        Schema::create('bt_sales_quote_reponses', function(Blueprint $table) {
       $table->decimal('poamount', 15, 2)->nullable();
       $table->text('poamountcomment')->nullable();
            
        });

        Schema::table('bt_sales_quote_reponses', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('user_id')->unsigned()->nullable()->index();
            $table->integer('quote_id')->nullable()->unsigned();
            $table->text('response')->nullable();
            $table->integer('quote_status_id')->unsigned();

               
            $table->decimal('amountpaid', 15, 2)->nullable();
            $table->decimal('amountdiscount', 15, 2)->nullable();
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_sales_quote_reponses');
    }
}
