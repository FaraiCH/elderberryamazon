<?php namespace Bt\Production\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

/**
 * CreateControlSheetQcItemsTable Migration
 */
class CreateControlSheetQcItemsTable extends Migration
{
    public function up()
    {
        Schema::create('bt_production_control_sheet_qc_items', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('controlsheet_id')->unsigned()->nullable()->index();
            $table->datetime('timeofreading')->nullable();

            $table->decimal('wall_thikness_n', 15, 2)->nullable()->default(0);
            $table->decimal('max_wall_ne', 15, 2)->nullable()->default(0);
            $table->decimal('max_wall_e', 15, 2)->nullable()->default(0);
            $table->decimal('max_wall_se', 15, 2)->nullable()->default(0);
            $table->decimal('max_wall_s', 15, 2)->nullable()->default(0);
            $table->decimal('max_wall_sw', 15, 2)->nullable()->default(0);
            $table->decimal('min_wall_w', 15, 2)->nullable()->default(0);
            $table->decimal('min_wall_nw', 15, 2)->nullable()->default(0);

            $table->decimal('avr_wall', 15, 2)->nullable()->default(0);
            $table->decimal('pipe_od', 15, 2)->nullable()->default(0);
            $table->decimal('ovality', 15, 2)->nullable()->default(0);

            $table->decimal('actual_weight', 15, 2)->nullable()->default(0);
            $table->decimal('actual_lenght', 15, 2)->nullable()->default(0);

            $table->integer('pipe_number_start')->nullable()->default(0);
            $table->integer('pipe_number_end')->nullable()->default(0);

            $table->string('outside_workmanship')->nullable();
            $table->string('inside_workmanship')->nullable();
            $table->string('printer_clear')->nullable();
            $table->string('printer_correct')->nullable();
            $table->string('end_squire')->nullable();

            $table->text('material')->nullable();
            $table->text('material_batch')->nullable();
            $table->string('recycle_material_batch')->nullable();
            $table->integer('qc_pass_id')->nullable();

            $table->string('comments')->nullable();
            $table->integer('created_by')->unsigned()->nullable()->index();
            $table->integer('updated_by')->unsigned()->nullable()->index();
            $table->integer('editlevel_id')->unsigned()->nullable()->index()->default(0);
            $table->timestamps();
        });
        Schema::table('bt_production_control_sheet_qc_items', function(Blueprint $table) {
            $table->string('colour')->nullable();
            $table->decimal('sample_weight', 15, 2)->nullable()->default(0);
            $table->integer('sample_length')->nullable()->default(0);
            $table->decimal('scrap_weight', 15, 2)->nullable()->default(0);
            $table->integer('number_pipe_passed_qc')->nullable()->default(0);
            $table->integer('number_pipe_failed_qc')->nullable()->default(0);
            $table->integer('hourly_production')->nullable()->default(0);

        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_production_control_sheet_qc_items');
    }
}
