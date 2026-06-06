<?php namespace Bt\It\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

/**
 * CreateTicketStagesTable Migration
 */
class CreateTicketStagesTable extends Migration
{
    public function up()
    {
        Schema::create('bt_it_ticket_stages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_it_ticket_stages');
    }
}
