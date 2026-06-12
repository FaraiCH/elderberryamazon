<?php namespace Bt\Sales\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class UpdateQuoteStatusesTableAddEmailGroupsId extends Migration
{
    public function up()
    {
        if (Schema::hasTable('bt_sales_quote_statuses') && !Schema::hasColumn('bt_sales_quote_statuses', 'email_groups_id')) {
            Schema::table('bt_sales_quote_statuses', function(Blueprint $table) {
                $table->integer('email_groups_id')->unsigned()->nullable()->after('updated_at');
                $table->index('email_groups_id');
            });
        }
    }

    public function down()
    {
        if (Schema::hasTable('bt_sales_quote_statuses') && Schema::hasColumn('bt_sales_quote_statuses', 'email_groups_id')) {
            Schema::table('bt_sales_quote_statuses', function(Blueprint $table) {
                $table->dropColumn('email_groups_id');
            });
        }
    }
}
