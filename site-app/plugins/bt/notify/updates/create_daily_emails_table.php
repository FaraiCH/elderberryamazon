<?php namespace Bt\Notify\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateDailyEmailsTable extends Migration
{
    public function up()
    {
        Schema::create('bt_notify_daily_emails', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_notify_daily_emails');
    }
}
