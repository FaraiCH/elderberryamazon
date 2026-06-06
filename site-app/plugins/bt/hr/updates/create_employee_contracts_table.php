<?php namespace Bt\Hr\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

/**
 * CreateEmployeeContractsTable Migration
 */
class CreateEmployeeContractsTable extends Migration
{
    public function up()
    {
        Schema::create('bt_hr_employee_contracts', function (Blueprint $table) {
            $table->increments('id');
            $table->dateTime('date')->nullable();
            $table->string('name');
            $table->text('version')->nullable();
            $table->integer('created_by')->unsigned()->nullable()->index();
            $table->integer('updated_by')->unsigned()->nullable()->index();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_hr_employee_contracts');
    }
}
