<?php namespace Bt\Sales\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateQuoteStatusesTable extends Migration
{
    public function up()
    {
        Schema::create('bt_sales_quote_statuses', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');            
            $table->string('name')->nullable();
            $table->string('action')->nullable();
            $table->timestamps();
        });
        Schema::table('bt_sales_quote_statuses', function(Blueprint $table) {
            $table->integer('candelete')->nullable()->default(0);
        }); 
    }

    public function down()
    {
        Schema::dropIfExists('bt_sales_quote_statuses');
    }
}
