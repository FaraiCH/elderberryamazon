<?php namespace Bt\Finance\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class UpdateRequisitionsTableAddArchived extends Migration
{
    public function up()
    {
        if (Schema::hasTable('bt_finance_requisitions')) {
            Schema::table('bt_finance_requisitions', function(Blueprint $table) {
                if (!Schema::hasColumn('bt_finance_requisitions', 'archived')) {
                    $table->boolean('archived')->default(false)->index();
                }
            });
        }
    }

    public function down()
    {
        if (Schema::hasTable('bt_finance_requisitions')) {
            Schema::table('bt_finance_requisitions', function(Blueprint $table) {
                if (Schema::hasColumn('bt_finance_requisitions', 'archived')) {
                    $table->dropColumn('archived');
                }
            });
        }
    }
}
