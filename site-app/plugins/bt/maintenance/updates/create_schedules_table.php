<?php namespace Bt\Maintenance\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateSchedulesTable extends Migration
{
    public function up()
    {
        Schema::create('bt_maintenance_schedules', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('line_id')->nullable()->unsigned();
            $table->datetime('scheduledate')->nullable();
            $table->string('job_summary')->nullable();
            $table->integer('machine_off')->nullable()->default(0); 
            $table->integer('durationmin')->nullable()->default(0);
            $table->integer('actiontype_id')->nullable()->default(0);
            $table->integer('assignedto_id')->nullable()->default(0);
            $table->integer('status_id')->nullable()->default(0);
            $table->integer('completedby_id')->nullable()->default(0);
            $table->datetime('completeddate')->nullable();
            $table->string('instruction_notes')->nullable();
            $table->string('completion_notes')->nullable();
            $table->string('spares_used')->nullable();
            $table->decimal('budget', 15, 2)->nullable();
            $table->string('budget_note')->nullable();
            $table->integer('priority')->nullable()->default(0);
            $table->timestamps();
        });

        Schema::table('bt_maintenance_schedules', function(Blueprint $table) {
            $table->integer('active')->nullable()->default(0);
        });
        
    }

    public function down()
    {
        Schema::dropIfExists('bt_maintenance_schedules');
    }
}
   