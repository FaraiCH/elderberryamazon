<?php namespace Bt\Sales\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateDeliveryPlansTable extends Migration
{
    public function up()
    {
        Schema::create('bt_sales_delivery_plans', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('client_id')->nullable()->unsigned();
            $table->integer('invoice_id')->nullable()->unsigned();
            $table->integer('type_id')->nullable()->unsigned();
            $table->string('notes')->nullable();
            $table->string('address')->nullable();
            $table->string('truck_number_plate')->nullable();
            $table->date('schedule_date')->nullable();
            $table->integer('created_by')->unsigned()->nullable()->index();
            $table->integer('updated_by')->unsigned()->nullable()->index();
            $table->timestamps();
        });
        Schema::table('bt_sales_delivery_plans', function (Blueprint $table){
            $table->text('address')->nullable()->change();
            $table->text('notes')->nullable()->change();
            $table->dateTime('load_date')->nullable();
            $table->string('unit_complexname_number')->nullable();
            $table->string('street_number')->nullable();
            $table->string('street_name')->nullable();
            $table->string('city')->nullable();
            $table->string('suburb')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('transporter_name')->nullable();

        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_sales_delivery_plans');
    }
}
