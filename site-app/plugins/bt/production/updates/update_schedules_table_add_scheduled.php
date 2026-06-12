<?php namespace Bt\Production\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class UpdateSchedulesTableAddScheduled extends Migration
{
    public function up()
    {
        if (Schema::hasTable('bt_production_schedules') && !Schema::hasColumn('bt_production_schedules', 'scheduled')) {
            Schema::table('bt_production_schedules', function(Blueprint $table) {
                $table->integer('scheduled')->nullable()->default(0)->index();
            });
        }
    }

    public function down()
    {
        if (Schema::hasTable('bt_production_schedules') && Schema::hasColumn('bt_production_schedules', 'scheduled')) {
            Schema::table('bt_production_schedules', function(Blueprint $table) {
                $table->dropColumn('scheduled');
            });
        }
    }
}
