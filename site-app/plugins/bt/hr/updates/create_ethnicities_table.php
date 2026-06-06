<?php namespace Bt\Hr\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

/**
 * CreateEthnicitiesTable Migration
 */
class CreateEthnicitiesTable extends Migration
{
    public function up()
    {
        Schema::create('bt_hr_ethnicities', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('created_by')->unsigned()->nullable()->index();
            $table->integer('updated_by')->unsigned()->nullable()->index();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_hr_ethnicities');
    }
}
