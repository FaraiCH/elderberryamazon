<?php namespace Bt\Sales\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class UpdateCategoriesTableAddIsmanaged extends Migration
{
    public function up()
    {
        if (Schema::hasTable('bt_sales_categories')) {
            Schema::table('bt_sales_categories', function(Blueprint $table) {
                if (!Schema::hasColumn('bt_sales_categories', 'ismanaged')) {
                    $table->boolean('ismanaged')->default(false)->index();
                }
            });
        }
    }

    public function down()
    {
        if (Schema::hasTable('bt_sales_categories')) {
            Schema::table('bt_sales_categories', function(Blueprint $table) {
                if (Schema::hasColumn('bt_sales_categories', 'ismanaged')) {
                    $table->dropColumn('ismanaged');
                }
            });
        }
    }
}
