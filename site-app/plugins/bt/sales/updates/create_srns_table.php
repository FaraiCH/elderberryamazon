<?php namespace Bt\Sales\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateSrnsTable extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('bt_sales_srns')) {
            Schema::create('bt_sales_srns', function(Blueprint $table) {
                $table->engine = 'InnoDB';
                $table->increments('id');
                $table->integer('client_id')->nullable()->unsigned();
                $table->integer('invoice_id')->nullable()->unsigned();
                $table->string('notes_srn')->nullable();
                $table->string('notes_delivery')->nullable();
                $table->date('schedule_date')->nullable();
                $table->string('prefix_srn')->nullable();
                $table->string('prefix_dn')->nullable();
                $table->string('altinvoice')->nullable();
                $table->integer('linkschedule_id')->nullable()->unsigned();
                $table->text('delivery_address')->nullable();
                $table->integer('active')->nullable()->default(0);
                $table->integer('reporting')->nullable()->default(0);
                $table->integer('pickslip_id')->nullable()->index();
                $table->integer('vehicle_id')->nullable()->index();
                $table->integer("fabrication")->nullable()->default(0);
                $table->dateTime('vehicle_arrival')->nullable();
                $table->dateTime('vehicle_load_start')->nullable();
                $table->dateTime('vehicle_load_end')->nullable();
                $table->dateTime('vehicle_departure')->nullable();
                $table->string('plate_number')->nullable();
                $table->decimal("weight_bridge", 15, 2)->nullable();
                $table->integer("trip_sheet_id")->nullable()->index();
                $table->integer("stops")->nullable();
                $table->integer('stock_order_id')->nullable()->unsigned()->index();
                $table->integer('created_by')->unsigned()->nullable()->index();
                $table->integer('updated_by')->unsigned()->nullable()->index();
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('bt_sales_srns');
    }
}
