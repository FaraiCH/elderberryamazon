<?php namespace Bt\Sales\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class UpdateQuoteitemsTableAddPriceperkg extends Migration
{
    public function up()
    {
        Schema::table('bt_sales_quoteitems', function(Blueprint $table) {
            $table->decimal('priceperkg', 15, 2)->nullable()->default(0)->after('totalweight');
        });
    }

    public function down()
    {
        Schema::table('bt_sales_quoteitems', function(Blueprint $table) {
            $table->dropColumn('priceperkg');
        });
    }
}
