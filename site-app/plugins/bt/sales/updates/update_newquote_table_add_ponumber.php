<?php namespace Bt\Sales\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class UpdateNewquoteTableAddPonumber extends Migration
{
    public function up()
    {
        Schema::table('bt_sales_newquote', function(Blueprint $table) {
            $table->string('ponumber')->nullable()->after('id');
        });
    }

    public function down()
    {
        Schema::table('bt_sales_newquote', function(Blueprint $table) {
            $table->dropColumn('ponumber');
        });
    }
}
