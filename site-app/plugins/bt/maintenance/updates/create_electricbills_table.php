<?php namespace Bt\Maintenance\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

/**
 * CreateElectricbillsTable Migration
 */
class CreateElectricbillsTable extends Migration
{
    public function up()
    {
        Schema::create('bt_maintenance_electricbills', function (Blueprint $table) {
            $table->increments('id');
            $table->date('date');
            $table->decimal('bill', 15,2)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_maintenance_electricbills');
    }
}
