<?php namespace Bt\Sales\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class UpdateFabricationsTableAddPonumber extends Migration
{
    public function up()
    {
        if (Schema::hasTable('bt_sales_fabrications')) {
            Schema::table('bt_sales_fabrications', function (Blueprint $table) {
                if (!Schema::hasColumn('bt_sales_fabrications', 'ponumber')) {
                    $table->string('ponumber')->nullable()->after('quote_id');
                }
            });
        }
    }

    public function down()
    {
        if (Schema::hasTable('bt_sales_fabrications')) {
            Schema::table('bt_sales_fabrications', function (Blueprint $table) {
                if (Schema::hasColumn('bt_sales_fabrications', 'ponumber')) {
                    $table->dropColumn('ponumber');
                }
            });
        }
    }
}
