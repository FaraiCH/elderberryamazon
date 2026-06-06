<?php

namespace Bt\Sales\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

/**
 * CreateQuoteApprovalIntrosTable Migration
 */
class CreateQuoteApprovalIntrosTable extends Migration
{
    public function up()
    {
        Schema::create('bt_sales_quote_approval_intro', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('quote_id')->unsigned()->index();
            $table->string('subject');
            $table->text('body');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_sales_quote_approval_intro');
    }
}
