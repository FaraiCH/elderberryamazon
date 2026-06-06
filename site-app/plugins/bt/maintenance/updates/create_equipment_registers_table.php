<?php namespace Bt\Maintenance\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

/**
 * CreateEquipmentRegistersTable Migration
 */
class CreateEquipmentRegistersTable extends Migration
{
    public function up()
    {
        Schema::create('bt_maintenance_equipment_registers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('equipment_name')->nullable();
            $table->timestamps();
            $table->integer('equipment_id')->nullable()->unsigned();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_maintenance_equipment_registers');
    }
}
