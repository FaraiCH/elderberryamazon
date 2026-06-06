<?php namespace Bt\Qc\Updates;

use Bt\Logistics\Models\Schedule;
use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateTestingMatricesTable extends Migration
{
    public function up()
    {
        Schema::create('bt_qc_testing_matrices', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('testtype_id')->unsigned()->nullable()->index();
            $table->integer('pipedescrip_id')->unsigned()->nullable()->index();
            $table->string('hydrotype')->nullable();
            $table->string('mfibatch_no_id')->nullable();
            $table->integer('mfi_num_bags')->nullable();
            $table->string('mfi_results')->nullable();
            $table->integer('mfimaterial_id')->unsigned()->nullable()->index();
            $table->string('therm_pipebatch_no')->nullable();
            $table->string('therm_material_batch')->nullable();
            $table->string('tensile_pipebatch_no')->nullable();
            $table->string('tensile_material_batch')->nullable();
            $table->string('hydro100_pipebatch_no')->nullable();
            $table->string('hydro165_pipebatch_no')->nullable();
            $table->string('hydro1k_pipebatch_no')->nullable();
            $table->string('oit_result')->nullable();
            $table->string('oit_material_batch')->nullable();
            $table->string('carbon_type')->nullable();
            $table->string('content_material_batch')->nullable();
            $table->double('content_result')->nullable();
            $table->string('dispersion_material_batch')->nullable();
            $table->double('dispersion_result')->nullable();
            $table->string('density_material_batch')->nullable();
            $table->double('density_result')->nullable();
            $table->date('test_date')->nullable();
            $table->integer('sabs')->default(0)->nullable();
            $table->integer('created_by')->unsigned()->nullable()->index();
            $table->integer('updated_by')->unsigned()->nullable()->index();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_qc_testing_matrices');
    }
}
