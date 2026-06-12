<?php namespace Bt\Production\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class UpdateSchedulesTableAddControlsheetId extends Migration
{
    public function up()
    {
        if (Schema::hasTable('bt_production_schedules')) {
            Schema::table('bt_production_schedules', function($table)
            {
                if (!Schema::hasColumn('bt_production_schedules', 'controlsheet_id')) {
                    $table->integer('controlsheet_id')->unsigned()->nullable()->index();
                }
            });
        }
    }

    public function down()
    {
        if (Schema::hasTable('bt_production_schedules')) {
            Schema::table('bt_production_schedules', function($table)
            {
                if (Schema::hasColumn('bt_production_schedules', 'controlsheet_id')) {
                    $table->dropColumn('controlsheet_id');
                }
            });
        }
    }
}
