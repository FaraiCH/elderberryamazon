<?php namespace Bt\Sales\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class UpdateNewquoteTableAddDeliveryMissingColumns extends Migration
{
    public function up()
    {
        Schema::table('bt_sales_newquote', function(Blueprint $table) {
            $table->decimal('deliveryamounthidden', 15, 2)->nullable()->default(0)->after('priceperkg');
            $table->decimal('deliveryamountmargins', 15, 2)->nullable()->default(0)->after('deliveryamounthidden');
            $table->decimal('buyoutmargins', 15, 2)->nullable()->default(0)->after('deliveryamountmargins');
            $table->decimal('deliveryamount', 15, 2)->nullable()->default(0)->after('notes');
        });
    }

    public function down()
    {
        Schema::table('bt_sales_newquote', function(Blueprint $table) {
            $table->dropColumn(['deliveryamounthidden', 'deliveryamountmargins', 'buyoutmargins', 'deliveryamount']);
        });
    }
}
