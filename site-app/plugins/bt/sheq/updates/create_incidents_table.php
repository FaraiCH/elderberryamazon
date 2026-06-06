<?php namespace Bt\Sheq\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateIncidentsTable extends Migration
{
    public function up()
    {
        Schema::dropIfExists('bt_sheq_incidents');
        Schema::create('bt_sheq_incidents', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->text('incident_no')->nullable();
            $table->text('name');
            $table->datetime('incident_date');
            $table->datetime('invest_date')->nullable();
            $table->integer('team_id')->nullable()->index();
            $table->text('root')->nullable();
            $table->text('control')->nullable();
            $table->datetime('close_date')->nullable();
            $table->datetime('recall_date')->nullable();
            $table->text('teams');
            $table->timestamps();
        });

        Schema::table('bt_sheq_incidents', function (Blueprint $table){
            $table->text('teams')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_sheq_incidents');
    }
}
