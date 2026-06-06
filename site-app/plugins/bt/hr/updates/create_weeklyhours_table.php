<?php namespace Bt\Hr\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

/**
 * CreateWeeklyhoursTable Migration
 */
class CreateWeeklyhoursTable extends Migration
{
    public function up()
    {
        Schema::create('bt_hr_weeklyhours', function (Blueprint $table) {
            $table->increments('id');
            $table->date('date')->nullable();
            $table->decimal('total_hours_weekly',15,2)->nullable();
            $table->decimal('total_overtime_weekly',15,2)->nullable();
            $table->integer('department_id')->unsigned()->nullable()->index();
            $table->timestamps();
        });
        Schema::table('bt_hr_weeklyhours', function (Blueprint $table) {
            $table->decimal('sat_overtime_weekly',15,2)->nullable();
            $table->decimal('sund_overtime_weekly',15,2)->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_hr_weeklyhours');
    }
}
