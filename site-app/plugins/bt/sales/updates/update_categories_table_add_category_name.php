<?php namespace Bt\Sales\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class UpdateCategoriesTableAddCategoryName extends Migration
{
    public function up()
    {
        if (Schema::hasTable('bt_sales_categories')) {
            Schema::table('bt_sales_categories', function(Blueprint $table) {
                if (!Schema::hasColumn('bt_sales_categories', 'category_name')) {
                    $table->string('category_name')->nullable()->after('name');
                }
                if (!Schema::hasColumn('bt_sales_categories', 'created_by')) {
                    $table->integer('created_by')->unsigned()->nullable()->index();
                }
                if (!Schema::hasColumn('bt_sales_categories', 'updated_by')) {
                    $table->integer('updated_by')->unsigned()->nullable()->index();
                }
            });
        }

        if (Schema::hasTable('bt_sales_catalogues')) {
            Schema::table('bt_sales_catalogues', function(Blueprint $table) {
                if (!Schema::hasColumn('bt_sales_catalogues', 'category_id')) {
                    $table->integer('category_id')->unsigned()->nullable()->index();
                }
                if (!Schema::hasColumn('bt_sales_catalogues', 'created_by')) {
                    $table->integer('created_by')->unsigned()->nullable()->index();
                }
                if (!Schema::hasColumn('bt_sales_catalogues', 'updated_by')) {
                    $table->integer('updated_by')->unsigned()->nullable()->index();
                }
            });
        }
    }

    public function down()
    {
        if (Schema::hasTable('bt_sales_categories')) {
            Schema::table('bt_sales_categories', function(Blueprint $table) {
                if (Schema::hasColumn('bt_sales_categories', 'category_name')) {
                    $table->dropColumn('category_name');
                }
                if (Schema::hasColumn('bt_sales_categories', 'created_by')) {
                    $table->dropColumn('created_by');
                }
                if (Schema::hasColumn('bt_sales_categories', 'updated_by')) {
                    $table->dropColumn('updated_by');
                }
            });
        }

        if (Schema::hasTable('bt_sales_catalogues')) {
            Schema::table('bt_sales_catalogues', function(Blueprint $table) {
                if (Schema::hasColumn('bt_sales_catalogues', 'category_id')) {
                    $table->dropColumn('category_id');
                }
                if (Schema::hasColumn('bt_sales_catalogues', 'created_by')) {
                    $table->dropColumn('created_by');
                }
                if (Schema::hasColumn('bt_sales_catalogues', 'updated_by')) {
                    $table->dropColumn('updated_by');
                }
            });
        }
    }
}
