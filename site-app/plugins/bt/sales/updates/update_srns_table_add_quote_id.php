<?php namespace Bt\Sales\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class UpdateSrnsTableAddQuoteId extends Migration
{
    public function up()
    {
        if (Schema::hasTable('bt_sales_srns') && !Schema::hasColumn('bt_sales_srns', 'quote_id')) {
            Schema::table('bt_sales_srns', function (Blueprint $table) {
                $table->integer('quote_id')->unsigned()->nullable()->index()->after('id');
            });
        }
    }

    public function down()
    {
        if (Schema::hasTable('bt_sales_srns') && Schema::hasColumn('bt_sales_srns', 'quote_id')) {
            Schema::table('bt_sales_srns', function (Blueprint $table) {
                $table->dropColumn('quote_id');
            });
        }
    }
}
