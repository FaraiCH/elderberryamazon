<?php namespace Bt\Sheq\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

/**
 * CreateQuestionnairesTable Migration
 */
class CreateQuestionnairesTable extends Migration
{
    public function up()
    {
        Schema::create('bt_sheq_questionnaires', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->text('description')->nullable();
            $table->integer('sort_order')->nullable();
            $table->integer('created_by')->unsigned()->nullable()->index();
            $table->integer('updated_by')->unsigned()->nullable()->index();
            $table->timestamps();
        });
        Schema::table('bt_sheq_questionnaires', function (Blueprint $table){
            $table->integer('active')->nullable()->default(0);
           $table->text('introduction')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_sheq_questionnaires');
    }
}
