<?php namespace Bt\Production\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateScrapToSheduleTable extends Migration
{
    public function up()
    {
        Schema::create('bt_prod_scrap_shedule', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->integer('schedule_id')->unsigned();
            $table->integer('scrapcode_id')->unsigned();
            $table->primary(['schedule_id','scrapcode_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_production_scrap_shedule_codes');
    }
}
