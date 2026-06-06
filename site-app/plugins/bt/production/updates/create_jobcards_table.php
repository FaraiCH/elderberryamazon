<?php namespace Bt\Production\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateJobcardsTable extends Migration
{
    public function up()
    {
        Schema::create('bt_production_jobcards', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->datetime('opendate')->nullable();
            $table->integer('assignedto_id')->nullable()->default(0); 
            $table->string('product_description')->nullable();
            $table->integer('orderqty')->nullable()->default(0); 
            $table->decimal('lengthsinm', 15, 2)->nullable()->default(0); 
            $table->integer('line_id')->unsigned();
            $table->string('total_tonnage')->nullable();
            $table->string('runrate_kg_hr')->nullable();

            $table->string('changeover_time_allowed')->nullable();

          
            $table->string('die_size')->nullable();
            $table->string('mendril_size')->nullable();
            $table->string('calibrator_size')->nullable();

            $table->string('screw_speed')->nullable();
            $table->string('haull_of_speed')->nullable();
            $table->string('machine_torque')->nullable();
            $table->string('melt_pressure')->nullable();

            $table->string('vacuum_pressure1')->nullable();
            $table->string('vacuum_pressure2')->nullable(); 
            $table->string('vacuum_pressure3')->nullable();

            $table->string('BZ1')->nullable();
            $table->string('BZ2')->nullable();
            $table->string('BZ3')->nullable();
            $table->string('BZ4')->nullable();
            $table->string('BZ5')->nullable();
            $table->string('BZ6')->nullable();
            $table->string('BZ7')->nullable();
            $table->string('ADAPTOR')->nullable();
            $table->string('DZ1')->nullable();
            $table->string('DZ2')->nullable();
            $table->string('DZ3')->nullable();
            $table->string('DZ4')->nullable();
            $table->string('DZ5')->nullable();
            $table->string('DZ6')->nullable();
            $table->string('DZ7')->nullable();
            $table->string('DZ8')->nullable();
            $table->string('DZ9')->nullable();
            $table->string('DZ10')->nullable();
            $table->string('DZ11')->nullable();
            $table->string('DZ12')->nullable();
            $table->string('DZ13')->nullable();
            $table->string('DZ14')->nullable();
            $table->string('DZ15')->nullable();
            $table->string('DZ16')->nullable();
            $table->string('DZ17')->nullable();
            $table->string('DZ18')->nullable();
            $table->string('DZ19')->nullable();
            $table->string('DZ20')->nullable();
            $table->string('DZ21')->nullable();
            $table->string('DZ22')->nullable();
            $table->string('DZ23')->nullable();
            $table->string('DZ24')->nullable();
            $table->datetime('production_startdatetime')->nullable();
            $table->datetime('production_finishdatetime')->nullable();

            $table->integer('created_by')->unsigned()->nullable()->index();
            $table->integer('updated_by')->unsigned()->nullable()->index();

            $table->timestamps();
        });

        Schema::table('bt_production_jobcards', function(Blueprint $table) {
            $table->string('printing_requirments')->nullable();
        });

        Schema::table('bt_production_jobcards', function(Blueprint $table) {
            $table->string('pipe_id')->nullable();
        });
        Schema::table('bt_production_jobcards', function(Blueprint $table) {        
            $table->integer('status_id')->nullable()->default(1);
            $table->string('notes')->nullable();

        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_production_jobcards');
    }
}
