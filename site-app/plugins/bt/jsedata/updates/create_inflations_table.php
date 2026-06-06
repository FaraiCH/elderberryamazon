<?php namespace Bt\JSEData\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateInflationsTable extends Migration
{
    public function up()
    {
        Schema::create('bt_jsedata_inflations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');

            $table->integer('i_year')->nullable();
            $table->decimal('i_jan', 15, 2)->nullable();
            $table->decimal('i_feb', 15, 2)->nullable();


            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_jsedata_inflations');
    }
}
