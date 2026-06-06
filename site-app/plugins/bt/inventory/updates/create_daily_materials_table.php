<?php namespace Bt\Inventory\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

/**
 * CreateDailyMaterialsTable Migration
 */
class CreateDailyMaterialsTable extends Migration
{
    public function up()
    {
       Schema::create('bt_inventory_daily_materials', function (Blueprint $table) {
            $table->increments('id');
            $table->date('datecaptured')->nullable();
            $table->integer('created_by')->unsigned()->nullable()->index();
            $table->integer('updated_by')->unsigned()->nullable()->index();
            $table->timestamps();
       });
    }

    public function down()
    {
        Schema::dropIfExists('bt_inventory_daily_materials');
    }
}
