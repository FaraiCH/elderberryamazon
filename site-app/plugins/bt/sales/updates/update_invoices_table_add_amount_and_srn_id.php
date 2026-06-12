<?php namespace Bt\Sales\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class UpdateInvoicesTableAddAmountAndSrnId extends Migration
{
    public function up()
    {
        Schema::table('bt_sales_invoices', function(Blueprint $table) {
            $table->decimal('amount', 15, 2)->nullable()->default(0);
            $table->integer('srn_id')->unsigned()->nullable()->index();
            $table->date('invoice_date')->nullable();
        });
    }

    public function down()
    {
        Schema::table('bt_sales_invoices', function(Blueprint $table) {
            $table->dropColumn(['amount', 'srn_id', 'invoice_date']);
        });
    }
}
