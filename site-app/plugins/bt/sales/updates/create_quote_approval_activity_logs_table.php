<?php

namespace Bt\Sales\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

/**
 * CreateQuoteApprovalActivityLogsTable Migration
 */
class CreateQuoteApprovalActivityLogsTable extends Migration
{
    public function up()
    {
        Schema::create('bt_sales_quote_approval_activity_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('quote_id')->unsigned()->index();
            $table->string('title');
            $table->text('description');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_sales_quote_approval_activity_logs');
    }
}
