<?php namespace Bt\Sheq\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateFiresTable extends Migration
{
    public function up()
    {
        Schema::create('bt_sheq_fires', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name');
            $table->dateTime('date')->nullable();

            $table->timestamps();
        });

        Schema::table('bt_sheq_fires', function (Blueprint $table){

            $table->integer('created_by')->unsigned()->nullable()->index();
            $table->integer('updated_by')->unsigned()->nullable()->index();
            $table->datetime('service')->nullable();

        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_sheq_fires');
    }
}
