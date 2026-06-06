<?php namespace Bt\Boardroom\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

/**
 * CreateBookingApprovalsTable Migration
 */
class CreateBookingApprovalsTable extends Migration
{
    public function up()
    {
        Schema::create('bt_boardroom_booking_approvals', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('booking_id')->unsigned()->nullable()->index();
            $table->integer('status_id')->nullable()->unsigned();
            $table->integer('created_by')->unsigned()->nullable()->index();
            $table->integer('updated_by')->unsigned()->nullable()->index();
            $table->timestamps();

        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_boardroom_booking_approvals');
    }
}
