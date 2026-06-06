<?php namespace Bt\HR\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateTrainingsTable extends Migration
{
    public function up()
    {
        Schema::create('bt_hr_trainings', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('employee_id')->unsigned()->nullable()->index();
            $table->integer('type_id')->nullable();
            $table->date('training_date')->nullable();
            $table->text('notes')->nullable();
            $table->integer('created_by')->unsigned()->nullable()->index();
            $table->integer('updated_by')->unsigned()->nullable()->index();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_hr_trainings');
    }
}
