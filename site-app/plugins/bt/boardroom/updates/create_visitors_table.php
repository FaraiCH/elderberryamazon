<?php namespace Bt\Boardroom\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

/**
 * CreateVisitorsTable Migration
 */
class CreateVisitorsTable extends Migration
{
    public function up()
    {
        Schema::create('bt_boardroom_visitors', function (Blueprint $table) {
            $table->increments('id');
            $table->string('visitorname')->nullable();
            $table->string('hostname')->nullable();
            $table->string('company')->nullable();
            $table->string('location')->nullable();
            $table->dateTime('date')->nullable();
            $table->integer('no_of_attendees')->nullable();
            $table->time('end_time')->nullable();
            $table->text('notes')->nullable();
            $table->integer('created_by')->unsigned()->nullable()->index();
            $table->integer('updated_by')->unsigned()->nullable()->index();
            $table->timestamps();
            $table->dateTime('accept_date')->nullable();
            $table->string('email')->nullable();
            $table->string('key_pass')->nullable();
            $table->integer('invited')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_boardroom_visitors');
    }
}
