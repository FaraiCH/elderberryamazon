<?php namespace Bt\Sales\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class UpdateNewquoteTableAddPriceperkg extends Migration
{
    public function up()
    {
        Schema::table('bt_sales_newquote', function(Blueprint $table) {
            $table->decimal('priceperkg', 15, 2)->nullable()->default(0)->after('quote_status_id');
        });
    }

    public function down()
    {
        Schema::table('bt_sales_newquote', function(Blueprint $table) {
            $table->dropColumn('priceperkg');
        });
    }
}
