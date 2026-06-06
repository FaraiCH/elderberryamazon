<?php namespace Bt\Sheq\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

/**
 * CreateEmployeeQuetionnaireAnswersTable Migration
 */
class CreateEmployeeQuetionnaireAnswersTable extends Migration
{
    public function up()
    {
        Schema::create('bt_sheq_employee_quetionnaire_answers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('question_id')->unsigned()->index()->nullable();
            $table->text('answer')->nullable();
            $table->timestamps();
        });
        Schema::table('bt_sheq_employee_quetionnaire_answers', function (Blueprint $table) {
            $table->integer('employee_id')->unsigned()->index()->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_sheq_employee_quetionnaire_answers');
    }
}
