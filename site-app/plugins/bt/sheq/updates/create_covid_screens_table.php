<?php namespace Bt\SHEQ\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateCovidScreensTable extends Migration
{
    public function up()
    {
        Schema::create('bt_sheq_covid_screens', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->datetime('capturedate')->nullable();
            $table->integer('no_screen')->nullable()->default(0);
            $table->integer('no_infected')->nullable()->default(0);
            $table->decimal('highest_temperature', 15, 2)->nullable()->default(0);
            $table->text('notes')->nullable();
            $table->integer('created_by')->unsigned()->nullable()->index();
            $table->integer('updated_by')->unsigned()->nullable()->index();
            $table->timestamps();
        });

        Schema::table('bt_sheq_covid_screens', function(Blueprint $table) {
            $table->integer('potential_infection')->nullable()->default(0);
        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_sheq_covid_screens');
    }
}
