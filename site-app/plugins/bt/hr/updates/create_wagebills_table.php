<?php namespace Bt\Hr\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

/**
 * CreateWagebillsTable Migration
 */
class CreateWagebillsTable extends Migration
{
    public function up()
    {

        Schema::create('bt_hr_wagebills', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('employee_id')->nullable()->index();
            $table->date('date')->nullable();
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->integer('shift')->nullable();
            $table->decimal('hours_worked', 15, 1)->nullable();
            $table->decimal('normal',15, 1)->nullable();
            $table->decimal('hours_over', 15, 1)->nullable();
            $table->decimal('overtime', 15, 1)->nullable();
            $table->string('comments')->nullable();
            $table->timestamps();
        });

        Schema::table('bt_hr_wagebills', function (Blueprint $table){
            $table->decimal('cancel', 15, 1)->nullable()->default(0);
             $table->decimal('rate', 15, 2)->nullable()->default(0);

            $table->decimal('double', 15, 1)->nullable()->default(0);
            $table->decimal('shifthours', 15, 1)->nullable()->default(0);
            $table->integer('department_id')->unsigned()->nullable()->index();

        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_hr_wagebills');
    }
}
