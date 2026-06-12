<?php namespace Bt\Sales\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class UpdateNewquoteTableAddClientId extends Migration
{
    public function up()
    {
        if (Schema::hasTable('bt_sales_newquote')) {
            Schema::table('bt_sales_newquote', function(Blueprint $table) {
                if (!Schema::hasColumn('bt_sales_newquote', 'client_id')) {
                    $table->integer('client_id')->unsigned()->nullable()->index()->after('user_id');
                }
            });
        }
    }

    public function down()
    {
        if (Schema::hasTable('bt_sales_newquote')) {
            Schema::table('bt_sales_newquote', function(Blueprint $table) {
                if (Schema::hasColumn('bt_sales_newquote', 'client_id')) {
                    $table->dropColumn('client_id');
                }
            });
        }
    }
}
