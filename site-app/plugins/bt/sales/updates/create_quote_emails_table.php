<?php namespace Bt\Sales\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateQuoteEmailsTable extends Migration
{
    public function up()
    {
        Schema::create('bt_sales_quote_emails', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('user_id')->unsigned()->nullable()->index();
            $table->integer('quote_id')->nullable()->unsigned();
            $table->integer('email_status')->default(1); 
            $table->string('email_cc')->nullable();
            $table->string('email_to')->nullable();
            $table->string('email_from')->nullable();
            $table->text('body')->nullable();
            $table->text('quote_html')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_sales_quote_emails');
    }
}
