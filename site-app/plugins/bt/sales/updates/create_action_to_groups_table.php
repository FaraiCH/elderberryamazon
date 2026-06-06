<?php namespace Bt\Sales\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateActionToGroupsTable extends Migration
{
    public function up()
    {
        Schema::create('bt_sales_action_to_groups', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('user_groups_id')->unsigned()->nullable()->index();
            $table->integer('quote_statuses_id')->unsigned()->nullable()->index();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_sales_action_to_groups');
    }
}
