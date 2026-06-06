<?php namespace Bt\Reporting\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

/**
 * CreateUserActivityLogsTable Migration
 */
class CreateUserActivityLogsTable extends Migration
{
    public function up()
    {
        Schema::create('bt_reporting_user_activity_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('type', ['create', 'update', 'delete'])->nullable();
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->integer('user_id')->unsigned()->nullable()->index();
            $table->json('old_data')->nullable();
            $table->json('new_data')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_reporting_user_activity_logs');
    }
}
