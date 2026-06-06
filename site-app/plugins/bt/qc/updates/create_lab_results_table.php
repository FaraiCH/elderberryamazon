<?php namespace Bt\QC\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateLabResultsTable extends Migration
{
    public function up()
    {
        Schema::create('bt_qc_lab_results', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->text('hydrostatic_test')->nullable();
            $table->integer('hydrostatic_comply')->default(0);
            $table->integer('thermal_comply')->default(0);
            $table->integer('elongation_comply')->default(0);
            $table->integer('iot_comply')->default(0);
            $table->integer('mfi_comply')->default(0);
            $table->string('testing')->nullable();
            $table->decimal('thermal_revision_test', 15, 2 )->nullable();
            $table->decimal('elongation_at_break_test', 15, 2 )->nullable();
            $table->decimal('iot', 15, 2 )->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_qc_lab_results');
    }
}
