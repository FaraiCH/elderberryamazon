<?php namespace Bt\HR\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateDepartmentsTable extends Migration
{
    public function up()
    {
        Schema::create('bt_hr_departments', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name')->nullable();
            $table->timestamps();
        });

        Schema::table('bt_hr_departments', function(Blueprint $table){
            $table->string('short_name')-> nullable();
            $table->integer('emps_in_department')->nullable();
            $table->integer('total_hours')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_hr_departments');
    }
}
