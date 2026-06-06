<?php namespace Bt\Maintenance\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateJobCardsTable extends Migration
{
    public function up()
    {
        Schema::create('bt_maintenance_job_cards', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->datetime('opendate')->nullable();
            $table->string('job_summary')->nullable();
            $table->integer('assignedto_id')->nullable()->default(0);
            $table->integer('department_id')->nullable()->default(0);
            $table->integer('jobtype_id')->nullable()->default(0);
            $table->integer('status_id')->nullable()->default(0);
            $table->string('spares_used')->nullable();
            $table->string('job_description')->nullable();
            $table->text('comments')->nullable();
            $table->datetime('closedate')->nullable();
            $table->decimal('budget', 15, 2)->nullable();
            $table->string('budget_note')->nullable();
            $table->integer('priority')->nullable()->default(0);
            $table->integer('created_by')->unsigned()->nullable()->index();
            $table->integer('updated_by')->unsigned()->nullable()->index();
            $table->integer('supervisor_id')->nullable()->index();
            $table->datetime('enddate')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_maintenance_job_cards');
    }
}
