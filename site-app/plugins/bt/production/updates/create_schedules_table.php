<?php namespace Bt\Production\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateSchedulesTable extends Migration
{
    public function up()
    {
        Schema::create('bt_production_schedules', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('user_id')->unsigned()->nullable()->index();
            $table->integer('pipe_id')->nullable()->unsigned();
            $table->integer('production_days')->nullable()->default(0);
            $table->date('production_date')->nullable();
            $table->integer('target_kg_processed')->nullable()->default(0);
            $table->integer('target_units_produced')->nullable()->default(0);
            $table->integer('total_kg_processed')->nullable()->default(0);
            $table->integer('total_units_produced')->nullable()->default(0);
            $table->integer('total_units_passed_qc')->nullable()->default(0);
            $table->decimal('weight_scrap_kg', 15, 1)->nullable()->default(0);
            $table->decimal('over_weight_kg', 15, 1)->nullable()->default(0);
            $table->string('reason_deviation_processed')->nullable();
            $table->string('reason_qc_Fail')->nullable();
            $table->string('reason_overweight')->nullable();
            $table->string('recovery_plan')->nullable();
            $table->string('material_used')->nullable();
            $table->string('batch_numbers')->nullable();
            $table->integer('running_hours')->nullable()->default(0);
            $table->string('maintenance')->nullable();

            $table->timestamps();
        });

         Schema::table('bt_production_schedules', function(Blueprint $table) {
            $table->integer('assignedto_id')->nullable()->default(0);
            $table->integer('shiftno')->nullable()->default(0);
            $table->string('reason_scrap')->nullable();
            $table->integer('scrapcode_id')->nullable()->default(0);
            $table->string('reason_onhold')->nullable();
            $table->decimal('priceperpipe', 15, 2)->nullable()->default(0);
            $table->decimal('materialvalue', 15, 2)->nullable()->default(0);
            $table->decimal('production_costperkg', 15, 2)->nullable()->default(0);
            $table->decimal('total_cost_schedule', 15, 2)->nullable()->default(0);
            $table->decimal('unitprice', 15, 2)->nullable()->default(0);
            $table->decimal('total_scrap_cost', 15, 2)->nullable()->default(0);
            $table->integer('checkedout')->nullable()->default(0);
            $table->integer('is_stock')->nullable()->default(0);
            $table->text('extrapipe')->nullable();
            $table->decimal('raw_material_cost', 15, 2)->nullable();
            $table->decimal('purge_cost', 15, 2)->nullable();
            $table->decimal('purge_weight', 15, 1)->nullable();
            $table->decimal('lab_sample_weight', 15, 1)->nullable();
            $table->decimal('overrun_weight', 15, 1)->nullable();



         });
    }

    public function down()
    {
        Schema::dropIfExists('bt_production_schedules');
    }
}
