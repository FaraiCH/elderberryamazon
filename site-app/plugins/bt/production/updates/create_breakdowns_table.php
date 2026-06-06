<?php namespace Bt\Production\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

/**
 * CreateBreakdownsTable Migration
 */
class CreateBreakdownsTable extends Migration
{
    public function up()
    {
    
        Schema::create('bt_production_breakdowns', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('line_id')->nullable()->unsigned();
            $table->datetime('startdate')->nullable();
            $table->integer('breakdown_id')->nullable()->unsigned();
            $table->integer('controlsheet_id')->nullable()->unsigned();
            $table->integer('created_by')->unsigned()->nullable()->index();
            $table->integer('updated_by')->unsigned()->nullable()->index();
            $table->timestamps();
        });
        Schema::table('bt_production_breakdowns', function (Blueprint $table) {
            $table->integer('jobcard_id')->nullable()->unsigned();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_production_breakdowns');
    }
}
