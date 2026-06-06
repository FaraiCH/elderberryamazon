<?php namespace Bt\Maintenance\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateUnitTypesTable extends Migration
{
    public function up()
    {
        Schema::create('bt_maintenance_unit_types', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->timestamps();
        });
        Schema::table('bt_maintenance_unit_types', function(Blueprint $table) {
            $table->string('name')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_maintenance_unit_types');
    }
}
