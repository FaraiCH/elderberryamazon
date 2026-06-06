<?php namespace Bt\Production\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateControlSheetsTable extends Migration
{
    public function up()
    {
        Schema::create('bt_production_control_sheets', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('jobcard_id')->unsigned()->nullable()->index();
            $table->integer('assignedto_id')->nullable()->default(0);
            $table->string('pipesize')->nullable();
            $table->decimal('standardweight', 15, 2)->nullable()->default(0);
            $table->decimal('mass', 15, 2)->nullable()->default(0);
            $table->decimal('pipelenght', 15, 2)->nullable()->default(0);
            $table->string('rawmaterialpe')->nullable()->default('PE 100');
            $table->string('shift')->nullable();
            $table->datetime('opendate')->nullable();
            $table->integer('line_id')->unsigned();

            $table->string('maxwall')->nullable();
            $table->string('minwall')->nullable();
            $table->string('avrwall')->nullable();
            $table->string('pipeod')->nullable();
            $table->string('ovality')->nullable();

            $table->integer('editlevel_id')->unsigned()->nullable()->index()->default(0);
            $table->integer("ov_comply")->default(0);
            $table->integer("wt_comply")->default(0);
            $table->integer("od_comply")->default(0);
            $table->integer("active")->default(0);
            $table->string("ponumber")->nullable();
            $table->decimal("total_weight", 15, 2)->nullable()->default(0);
            $table->integer('target_num_pipes')->nullable();
            $table->integer('plan_id')->nullable()->index();
            $table->integer('planitem_id')->nullable()->index();
            $table->integer('raw_plan_id')->nullable()->index();
            $table->decimal('raw_material_cost', 15, 2)->nullable();
            $table->decimal('purge_cost', 15, 2)->nullable();
            $table->decimal('purge_weight', 15, 1)->nullable();
            $table->decimal('lab_sample_weight', 15, 1)->nullable();
            $table->integer('operator_signature')->nullable()->index();
            $table->integer('supervisor_signature')->nullable()->index();
            $table->integer('qc_signature')->nullable()->index();

            $table->integer('created_by')->unsigned()->nullable()->index();
            $table->integer('updated_by')->unsigned()->nullable()->index();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_production_control_sheets');
    }
}
