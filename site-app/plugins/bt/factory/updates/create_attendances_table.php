<?php namespace Bt\Factory\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateAttendancesTable extends Migration
{
    public function up()
    {
        Schema::create('bt_factory_attendances', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->text('attendancetype_id')->nullable();
            $table->integer('numAttendees')->nullable();
            $table->date('date')->nullable();
            $table->text('description')->nullable();
            $table->integer('created_by')->unsigned()->nullable()->index();
            $table->integer('updated_by')->unsigned()->nullable()->index();
            $table->timestamps();
        });
    }

    public function down()
    {
         Schema::dropIfExists('bt_factory_attendances');
    }
}
