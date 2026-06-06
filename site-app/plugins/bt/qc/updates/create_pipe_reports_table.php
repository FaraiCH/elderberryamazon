<?php namespace Bt\Qc\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreatePipeReportsTable extends Migration
{
    public function up()
    {
        Schema::create('bt_qc_pipe_reports', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->date('date')->nullable();
            $table->text('hydrostatic_test')->nullable();
            $table->integer('hydrostatic_comply')->nullable()->default(0);
            $table->text('hydrostatic_test_2')->nullable();
            $table->integer('hydrostatic_comply_2')->nullable()->default(0);
            $table->text('hydrostatic_test_3')->nullable();
            $table->integer('hydrostatic_comply_3')->nullable()->default(0);
            $table->integer('thermal_comply')->nullable()->default(0);
            $table->integer('elongation_comply')->nullable()->default(0);
            $table->string('pipebatch')->nullable();
            $table->integer('pipedescrip_id')->unsigned()->nullable()->index();
            $table->integer('jobcard_id')->unsigned()->nullable()->index();
            $table->integer('pipe_id')->unsigned()->nullable()->index();
            $table->integer('batch_id')->unsigned()->nullable()->index();
            $table->integer('iot_comply')->default(0);
            $table->integer('mfi_comply')->default(0);
            $table->decimal('mfi', 15, 2)->nullable()->default(0);
            $table->string('testing')->nullable();
            $table->integer('bags')->nullable()->default(0);
            $table->decimal('weight', 15, 1)->nullable()->default(0);
            $table->decimal('damagedbags', 15, 1)->nullable()->default(0);
            $table->integer('active')->nullable()->default(1);
            $table->decimal('thermal_revision_test', 15, 2)->nullable()->default(0);
            $table->decimal('elongation_at_break_test', 15, 2)->nullable()->default(0);
            $table->decimal('iot', 15, 2)->nullable()->default(0);
            $table->decimal('mfi_post', 15, 2)->nullable()->default(0);
            $table->string('coc_pipebatch')->nullable();
            $table->string('coc_specifications')->nullable();
            $table->integer('mfi_comply_post')->nullable()->default(0);
            $table->integer('iot_comply_post')->nullable()->default(0);
            $table->decimal('iot_post', 15, 2)->nullable()->default(0);
            $table->integer('item_id')->unsigned()->nullable()->index();
            $table->integer('quote_id')->unsigned()->nullable()->index();
            $table->integer('supplier_batch_id')->nullable()->index();
            $table->string('testing_oit')->nullable();
            $table->integer('created_by')->unsigned()->nullable()->index();
            $table->integer('updated_by')->unsigned()->nullable()->index();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_qc_pipe_reports');
    }
}
