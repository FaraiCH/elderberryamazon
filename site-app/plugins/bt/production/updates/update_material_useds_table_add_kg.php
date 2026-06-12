<?php namespace Bt\Production\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class UpdateMaterialUsedsTableAddKg extends Migration
{
    public function up()
    {
        if (Schema::hasTable('bt_production_material_useds')) {
            Schema::table('bt_production_material_useds', function(Blueprint $table) {
                if (!Schema::hasColumn('bt_production_material_useds', 'kg')) {
                    $table->decimal('kg', 15, 2)->nullable()->default(0);
                }
            });
        }
    }

    public function down()
    {
        if (Schema::hasTable('bt_production_material_useds')) {
            Schema::table('bt_production_material_useds', function(Blueprint $table) {
                if (Schema::hasColumn('bt_production_material_useds', 'kg')) {
                    $table->dropColumn('kg');
                }
            });
        }
    }
}
