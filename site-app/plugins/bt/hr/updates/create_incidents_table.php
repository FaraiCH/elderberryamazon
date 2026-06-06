<?php namespace Bt\HR\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateIncidentsTable extends Migration
{
    public function up()
    {
        Schema::create('bt_hr_incidents', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('employee_id')->unsigned()->nullable()->index();
            $table->integer('status_id')->nullable();
            $table->date('incident_date')->nullable();
            $table->text('incident')->nullable();
            $table->text('solution')->nullable();
            $table->integer('created_by')->unsigned()->nullable()->index();
            $table->integer('updated_by')->unsigned()->nullable()->index();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_hr_incidents');
    }
}
