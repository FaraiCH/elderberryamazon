<?php namespace Bt\Production\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateControlSheetItemsTable extends Migration
{
    public function up()
    {
        Schema::dropIfExists('bt_production_control_sheet_items');
        Schema::create('bt_production_control_sheet_items', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('controlsheet_id')->unsigned()->nullable()->index();
            $table->datetime('timeofreading')->nullable();
            $table->integer('hopper_temperature')->nullable()->change();

            for ($i=1; $i < 8; $i++) {
            $table->integer('barel_zone'.$i )->nullable()->change();
            }

            $table->integer('barel_zone_adaptor')->nullable()->change();

            for ($i=1; $i < 25; $i++) {
            $table->integer('die_zone'.$i)->nullable()->change();
            }

            $table->decimal('motor_speed', 15, 2)->nullable()->default(0);
            $table->decimal('haul_off_speed', 15, 2)->nullable()->default(0);
            $table->decimal('machine_torque', 15, 2)->nullable()->default(0);
            $table->decimal('vacuum_1_reading', 15, 2)->nullable()->default(0);
            $table->decimal('vacuum_2_reading', 15, 2)->nullable()->default(0);
            $table->decimal('vacuum_3_reading', 15, 2)->nullable()->default(0);

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

            $table->integer('hourly_production')->nullable()->default(0);
            $table->decimal('hourly_scrap', 15, 2)->nullable()->default(0);

            $table->integer('reasonscrap_id')->unsigned()->nullable()->index();
            $table->string('comments')->nullable();

            $table->integer('created_by')->unsigned()->nullable()->index();
            $table->integer('updated_by')->unsigned()->nullable()->index();
            $table->integer('editlevel_id')->unsigned()->nullable()->index()->default(0);
            $table->timestamps();
       });

          Schema::table('bt_production_control_sheet_items', function(Blueprint $table) {
         $table->integer('delay_id')->unsigned()->nullable()->index();
         $table->integer('minutes_delay')->nullable();
            $table->integer('temperature_of_material')->nullable();
            $table->integer('dryer_temperature_by_hand')->nullable();
            $table->integer('line_change_id')->nullable();
            $table->integer('breakdown_id')->nullable();
            $table->string('colour')->nullable();

          });

    }

    public function down()
    {
        Schema::dropIfExists('bt_production_control_sheet_items');
    }
}
