<?php namespace Bt\Finance\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

/**
 * CreateRequisitionProjectsTable Migration
 */
class CreateRequisitionProjectsTable extends Migration
{
    public function up()
    {
        Schema::create('bt_finance_requisition_projects', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('description')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_finance_requisition_projects');
    }
}
