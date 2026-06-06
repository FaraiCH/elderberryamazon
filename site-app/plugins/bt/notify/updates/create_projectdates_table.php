<?php namespace Bt\Notify\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateProjectdatesTable extends Migration
{
    public function up()
    {
        Schema::create('bt_notify_projectdates', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('project_id')->unsigned()->nullable()->default(1)->index();
            $table->datetime('projectdate')->nullable();

            $table->string('title')->nullable();
            $table->text('body')->nullable(); 
            $table->integer('status')->nullable()->default(0);
            $table->integer('created_by')->unsigned()->nullable()->index();
            $table->integer('updated_by')->unsigned()->nullable()->index();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_notify_projectdates');
    }
}
