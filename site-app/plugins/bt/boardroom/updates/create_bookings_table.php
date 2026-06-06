<?php namespace Bt\Boardroom\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

/**
 * CreateBookingsTable Migration
 */
class CreateBookingsTable extends Migration
{
    public function up()
    {
        Schema::create('bt_boardroom_bookings', function (Blueprint $table) {
            $table->increments('id');
            $table->date('date')->nullable();
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->integer('bookedby_id')->unsigned()->nullable()->index();
            $table->integer('department_id')->unsigned()->nullable()->index();
            $table->integer('status_id')->unsigned()->nullable()->index();
            $table->integer('no_of_attendees')->nullable();
            $table->integer("booking_type")->nullable()->default(1);
            $table->integer("boardroom_name")->nullable()->default(1);
            $table->string('notes')->nullable();
            $table->integer('created_by')->unsigned()->nullable()->index();
            $table->integer('updated_by')->unsigned()->nullable()->index();
            $table->integer('approvedby_id')->unsigned()->nullable()->index();
            $table->integer('response')->nullable()->default(0);
            $table->integer("status")->nullable()->default(1);
            $table->string('duration')->nullable();
            $table->string('subject')->nullable();
            $table->text('departments')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_boardroom_bookings');
    }
}
