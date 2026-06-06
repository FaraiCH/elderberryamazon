<?php namespace Bt\Maintenance\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateToolsUsagesTable extends Migration
{
    public function up()
    {
        Schema::create('bt_maintenance_tools_usages', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('tool_id')->nullable()->default(0);
            $table->datetime('opendate')->nullable();
            $table->integer('inout_id')->nullable()->default(0);
            $table->integer('quantity')->default(1);
            $table->string('reason')->nullable();
            $table->string('condition_id')->nullable();
            $table->integer('usedby_id')->nullable()->default(0);
            $table->timestamps();

        });
        Schema::table('bt_maintenance_tools_usages', function(Blueprint $table) {
            $table->integer('created_by')->unsigned()->nullable()->index();
            $table->integer('updated_by')->unsigned()->nullable()->index();
        });

    }

    public function down()
    {
        Schema::dropIfExists('bt_maintenance_tools_usages');
    }
}
