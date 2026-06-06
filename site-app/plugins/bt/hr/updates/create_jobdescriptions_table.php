<?php namespace Bt\Hr\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

/**
 * CreateJobdescriptionsTable Migration
 */
class CreateJobdescriptionsTable extends Migration
{
    public function up()
    {
         Schema::create('bt_hr_jobdescriptions', function (Blueprint $table) {
             $table->increments('id');
             $table->string('name');
             $table->text('description')->nullable();
             $table->integer('created_by')->unsigned()->nullable()->index();
             $table->integer('updated_by')->unsigned()->nullable()->index();
             $table->integer('rev')->nullable();
             $table->dateTime('date')->nullable();
             $table->timestamps();
         });
    }

    public function down()
    {
        Schema::dropIfExists('bt_hr_jobdescriptions');
    }
}
