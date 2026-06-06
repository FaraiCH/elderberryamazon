<?php namespace Bt\Logistics\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateSchedulesTable extends Migration
{
    public function up()
    {

        Schema::create('bt_logistics_schedules', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->datetime('schedule_date')->nullable();

            $table->datetime('return_date')->nullable();
            
              
            $table->integer('quote_id')->unsigned()->nullable()->index(); 
            $table->integer('vehice_id')->unsigned()->nullable()->index();
            $table->integer('department_id')->unsigned()->nullable()->index();
            $table->integer('requestedby_id')->unsigned()->nullable()->index();
            $table->integer('usagetype_id')->unsigned()->nullable()->index();

            $table->string('addressto')->nullable();
            $table->string('notes')->nullable();
            $table->integer('created_by')->unsigned()->nullable()->index();
            $table->integer('updated_by')->unsigned()->nullable()->index();
            $table->timestamps();
            $table->integer('mileage_start')->nullable();
            $table->integer('mileage_end')->nullable();
            $table->integer('driver_id')->unsigned()->nullable()->index();

            $table->text('damages_notes')->nullable();
            $table->text('trafficoffense_notes')->nullable();

            $table->integer('approve_id')->unsigned()->nullable()->index();
            $table->integer('response')->nullable()->default(0);

        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_logistics_schedules');
    }
}
