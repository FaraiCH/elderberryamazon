<?php namespace Bt\Production\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateJobcardapprovesTable extends Migration
{
    public function up()
    {
        Schema::create('bt_production_jobcardapproves', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('jobcard_id')->unsigned()->nullable()->index();
            $table->integer('status_id')->nullable()->unsigned();
            $table->integer('created_by')->unsigned()->nullable()->index();
            $table->integer('updated_by')->unsigned()->nullable()->index();
            $table->timestamps();
        });
        Schema::table('bt_production_jobcardapproves', function(Blueprint $table) {
            $table->string('note')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_production_jobcardapproves');
    }
}
