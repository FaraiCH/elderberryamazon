<?php namespace Bt\HR\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateAbsenceLeavesTable extends Migration
{
    public function up()
    {
        Schema::create('bt_hr_absence_leaves', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('employee_id')->unsigned()->nullable()->index();
            $table->integer('status_id')->nullable();
            $table->integer('type_id')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('notes')->nullable();
            $table->integer('created_by')->unsigned()->nullable()->index();
            $table->integer('updated_by')->unsigned()->nullable()->index();
            $table->timestamps();
        });
         Schema::table('bt_hr_absence_leaves', function (Blueprint $table){
            $table->integer('days')->nullable()->default(0);

         });
    }

    public function down()
    {
        Schema::dropIfExists('bt_hr_absence_leaves');
    }
}
