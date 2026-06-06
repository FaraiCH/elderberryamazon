<?php namespace Bt\IT\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateTaskResponsesTable extends Migration
{
    public function up()
    {
        Schema::create('bt_it_task_responses', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('job_id')->unsigned()->nullable()->index();
            $table->integer('isolved')->nullable();
            $table->string('subject')->nullable();
            $table->text('description')->nullable();
            $table->integer('created_by')->unsigned()->nullable()->index();
            $table->integer('updated_by')->unsigned()->nullable()->index();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_it_task_responses');
    }
}
