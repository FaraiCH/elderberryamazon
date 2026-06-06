<?php namespace Bt\Qc\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

/**
 * CreateQcEquipmentsTable Migration
 */
class CreateQcEquipmentsTable extends Migration
{
    public function up()
    {
        Schema::create('bt_qc_qc_equipments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('supplier_name')->nullable();
            $table->string('model_number')->nullable();
            $table->string('serial_number')->nullable();
            $table->date('caliberation_date')->nullable();
            $table->date('caliberation_expiry_date')->nullable();
            $table->timestamps();
        
        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_qc_qc_equipments');
    }
}
