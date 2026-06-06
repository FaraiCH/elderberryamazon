<?php namespace Bt\Maintenance\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

/**
 * CreateProvincialBillsTable Migration
 */
class CreateProvincialBillsTable extends Migration
{
    public function up()
    {
        Schema::create('bt_maintenance_provincial_bills', function (Blueprint $table) {
            $table->increments('id');
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->integer('line_id')->nullable();
            $table->decimal('off_peak_kwh')->nullable();
            $table->decimal('off_peak_amount')->nullable();
            $table->decimal('standard_kwh')->nullable();
            $table->decimal('standard_amount')->nullable();
            $table->decimal('on_peak_kwh')->nullable();
            $table->decimal('on_peak_amount')->nullable();
            $table->decimal('max_demand_amount')->nullable();
            $table->decimal('fixed_charge_amount')->nullable();
            $table->decimal('network_access_amount')->nullable();
            $table->decimal('total_amount')->nullable();

            $table->timestamps();
        });

        Schema::table('bt_maintenance_provincial_bills', function (Blueprint $table){
            $table->decimal('total_kwh')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_maintenance_provincial_bills');
    }
}
