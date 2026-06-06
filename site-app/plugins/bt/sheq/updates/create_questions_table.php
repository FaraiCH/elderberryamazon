<?php namespace Bt\Sheq\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

/**
 * CreateQuestionsTable Migration
 */
class CreateQuestionsTable extends Migration
{
    public function up()
    {
        Schema::create('tbl_question', function (Blueprint $table) {
            $table->boolean('swaplabel')->default(false);
            $table->increments('id');

            $table->string('name')->nullable();
            $table->string('type')->nullable();
            $table->string('label')->nullable();
            $table->string('placeholder')->nullable();
            $table->text('field_values')->nullable();
            $table->string('field_validation')->nullable();
            $table->text('validation')->nullable();   

            $table->string('field_custom_code')->nullable(); 
            $table->string('field_custom_code_twig')->nullable(); 
            $table->string('field_custom_code_line')->nullable(); 
            $table->string('field_custom_content')->nullable(); 
            $table->string('field_custom_content_section')->nullable(); 
            $table->string('field_styling')->nullable(); 
            $table->string('wrapper_css')->nullable(); 
            $table->string('label_css')->nullable(); 

            $table->string('field_css')->nullable(); 
            $table->string('section_validation')->nullable(); 

            $table->timestamps();
        });
        Schema::table('tbl_question', function (Blueprint $table) {
               $table->integer('answer')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tbl_question');
    }
}


        

   


