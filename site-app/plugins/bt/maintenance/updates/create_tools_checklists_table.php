<?php namespace Bt\Maintenance\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateToolsChecklistsTable extends Migration
{
     public function up()
    {
        Schema::create('bt_maintenance_tools_checklists', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('tool_id')->unsigned()->nullable()->index();
            $table->integer('checklist_id')->unsigned()->nullable()->index();
            $table->integer('assignedto_id')->nullable()->default(0);  
            $table->datetime('scheduledate')->nullable();
            $table->integer('status_id')->nullable()->default(0);
            $table->string('condition_id')->nullable();
            $table->text('instructions');
            $table->text('comments');
            $table->integer('created_by')->unsigned()->nullable()->index();
            $table->integer('updated_by')->unsigned()->nullable()->index();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_maintenance_tools_checklists');
    }
}
