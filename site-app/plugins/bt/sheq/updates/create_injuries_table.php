<?php namespace Bt\SHEQ\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateInjuriesTable extends Migration
{
    public function up()
    {
        Schema::dropIfExists('bt_sheq_injuries');
        Schema::create('bt_sheq_injuries', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->datetime('injurydate')->nullable();
            $table->string('firstname')->nullable();
            $table->string('lastname')->nullable();
            $table->text('description_of_injury')->nullable();
            $table->text('description_of_first_aid_applied')->nullable();
            $table->text('items_used_to_treat')->nullable();
            $table->integer('scale_of_injury')->nullable()->default(0);

            $table->integer('created_by')->unsigned()->nullable()->index();
            $table->integer('updated_by')->unsigned()->nullable()->index();
            $table->timestamps();
        });
        Schema::table('bt_sheq_injuries', function (Blueprint $table){
            $table->integer('status')-> nullabel();
        });

    }

    public function down()
    {
        Schema::dropIfExists('bt_sheq_injuries');
    }
}
