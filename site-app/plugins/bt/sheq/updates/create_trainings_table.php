<?php namespace Bt\Sheq\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

/**
 * CreateTrainingsTable Migration
 */
class CreateTrainingsTable extends Migration
{
    public function up()
    {
        Schema::create('bt_sheq_trainings', function (Blueprint $table) {
            $table->increments('id');
            $table->date('date');
            $table->string('subject');
            $table->text('description');
            $table->text('attend');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_sheq_trainings');
    }
}
