<?php namespace Bt\Sales\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

/**
 * CreateTripSheetsTable Migration
 */
class CreateTripSheetsTable extends Migration
{
    public function up()
    {
        Schema::create('bt_sales_trip_sheets', function (Blueprint $table) {
            $table->increments('id');
            $table->string('driver_name')->nullable();
            $table->string('truck_reg_number')->nullable();
            $table->string('signature')->nullable();
            $table->string('transporter')->nullable();
            $table->timestamps();
            $table->integer('vehicle_id')->nullable()->index();

            $table->dateTime('vehicle_arrival')->nullable();
            $table->dateTime('vehicle_load_start')->nullable();
            $table->dateTime('vehicle_load_end')->nullable();
            $table->dateTime('vehicle_departure')->nullable();
            $table->decimal('deliveryprice', 15, 2)->nullable()->index();
            $table->string('notes')->nullable();

        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_sales_trip_sheets');
    }
}
