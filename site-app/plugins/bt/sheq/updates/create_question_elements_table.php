<?php namespace Bt\Sheq\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

/**
 * CreateQuestionElementsTable Migration
 */
class CreateQuestionElementsTable extends Migration
{
    public function up()
    {
        Schema::create('tbl_question_element', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('label')->nullable();
            $table->text('questions')->nullable();
            $table->integer('questionelement_id')->unsigned()->nullable()->index();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tbl_question_element');
    }
}
